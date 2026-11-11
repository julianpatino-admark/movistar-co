<?php

namespace App\Http\Requests;

use Admark\Tracking\Http\Requests\WebhookRequest;

class TrackingWebhookRequest extends WebhookRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $source = $this->input('tsource');
        $batch = $this->tsource->sourceHas('batch_id', $source)
            ? $this->tsource->getBatchId($source)
            : config('tracking.webhook_batch_id');

        if ($batch !== null && $batch !== '') {
            $this->merge(['batch_id' => str_replace(' ', '', $batch)]);
        }
    }
}
