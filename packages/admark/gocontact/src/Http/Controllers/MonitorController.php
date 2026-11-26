<?php

namespace Admark\GoContact\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('gocontact_submissions')
            ->leftJoin('forms', 'forms.id', '=', 'gocontact_submissions.form_id')
            ->select([
                'gocontact_submissions.id',
                'gocontact_submissions.form_id',
                'gocontact_submissions.database_id',
                'gocontact_submissions.gocontact_id',
                'gocontact_submissions.successful',
                'gocontact_submissions.stage',
                'gocontact_submissions.http_status',
                'gocontact_submissions.error',
                'gocontact_submissions.diagnostics',
                'gocontact_submissions.duration_ms',
                'gocontact_submissions.created_at',
                'forms.lead_id as tracking_lead_id',
            ])
            ->orderByDesc('gocontact_submissions.id');

        $filters = $request->validate([
            'form_id' => ['nullable', 'integer', 'min:1'],
            'database_id' => ['nullable', 'string', 'max:191'],
            'status' => ['nullable', 'in:failed,successful'],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => array_filter(['nullable', 'date_format:Y-m-d', $request->filled('from') ? 'after_or_equal:from' : null]),
            'q' => ['nullable', 'string', 'max:191'],
        ]);
        if (!empty($filters['form_id'])) {
            $query->where('gocontact_submissions.form_id', $filters['form_id']);
        }
        if (!empty($filters['database_id'])) {
            $query->where('gocontact_submissions.database_id', $filters['database_id']);
        }
        if (!empty($filters['status'])) {
            $query->where('gocontact_submissions.successful', $filters['status'] === 'successful');
        }
        if (!empty($filters['from'])) {
            $query->whereDate('gocontact_submissions.created_at', '>=', $filters['from']);
        }
        if (!empty($filters['to'])) {
            $query->whereDate('gocontact_submissions.created_at', '<=', $filters['to']);
        }
        if (!empty($filters['q'])) {
            $query->where(function ($search) use ($filters) {
                $search->where('gocontact_submissions.gocontact_id', $filters['q'])
                    ->orWhere('forms.lead_id', $filters['q']);
            });
        }
        $summary = (clone $query)->reorder()->select([])->selectRaw('COUNT(*) as total, SUM(CASE WHEN gocontact_submissions.successful = 1 THEN 1 ELSE 0 END) as successful, SUM(CASE WHEN gocontact_submissions.successful = 0 THEN 1 ELSE 0 END) as failed, AVG(gocontact_submissions.duration_ms) as duration')->first();
        $databaseOptions = DB::table('gocontact_submissions')->whereNotNull('database_id')->distinct()->orderBy('database_id')->pluck('database_id')
            ->merge([config('gocontact.database_id'), config('gocontact.routing.alternate_database_id')])->filter()->unique()->sort()->values();
        $assignments = DB::table('gocontact_routing_assignments')
            ->selectRaw('database_id, COUNT(*) as total')
            ->groupBy('database_id')->orderBy('database_id')->get();
        $totals = DB::table('gocontact_submissions')
            ->whereNotNull('database_id')
            ->selectRaw('database_id, SUM(CASE WHEN successful = 1 THEN 1 ELSE 0 END) as successful, SUM(CASE WHEN successful = 0 THEN 1 ELSE 0 END) as failed')
            ->groupBy('database_id')->get()->keyBy('database_id');

        $attempts = $query->paginate(50)->withQueryString();
        $attempts->getCollection()->transform(function ($attempt) {
            $diagnostics = json_decode($attempt->diagnostics ?? '', true);
            $attempt->request_id = is_array($diagnostics) ? ($diagnostics['request_id'] ?? null) : null;

            return $attempt;
        });

        return response()
            ->view('gocontact::index', compact('attempts', 'assignments', 'totals', 'summary', 'databaseOptions', 'filters'))
            ->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
