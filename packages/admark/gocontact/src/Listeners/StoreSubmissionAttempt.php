<?php

namespace Admark\GoContact\Listeners;

use Admark\GoContact\GoContactSubmissionAttempted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class StoreSubmissionAttempt
{
    public function handle(GoContactSubmissionAttempted $event): void
    {
        try {
            DB::table('gocontact_submissions')->insert([
                'form_id' => $event->formId,
                'gocontact_id' => $event->providerLeadId,
                'successful' => $event->successful,
                'stage' => $event->stage,
                'http_status' => $event->httpStatus,
                'error' => $event->error,
                'diagnostics' => json_encode($event->diagnostics, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'duration_ms' => $event->durationMs,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (Throwable $exception) {
            Log::channel(config('gocontact.log_channel', 'gocontact'))->error('Unable to persist GoContact submission attempt', [
                'event' => 'gocontact.audit_persistence.failed',
                'form_id' => $event->formId,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
