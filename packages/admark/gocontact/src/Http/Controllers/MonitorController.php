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

        if ($request->filled('form_id') && ctype_digit((string) $request->input('form_id'))) {
            $query->where('gocontact_submissions.form_id', (int) $request->input('form_id'));
        }

        if ($request->input('status') === 'failed') {
            $query->where('gocontact_submissions.successful', false);
        } elseif ($request->input('status') === 'successful') {
            $query->where('gocontact_submissions.successful', true);
        }

        if ($request->filled('database_id') && is_scalar($request->input('database_id'))) {
            $query->where('gocontact_submissions.database_id', (string) $request->input('database_id'));
        }

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
            ->view('gocontact::index', compact('attempts', 'assignments', 'totals'))
            ->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
