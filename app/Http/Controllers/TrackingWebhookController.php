<?php

namespace App\Http\Controllers;

use Admark\Tracking\Http\Controllers\WebhookController;
use Admark\Tracking\Http\Requests\WebhookRequest;

class TrackingWebhookController extends WebhookController
{
    public function post(WebhookRequest $request)
    {
        $data = $request->all();
        // The webhook form_id identifies the external campaign, not forms.id.
        unset($data['id'], $data['form_id']);
        $form = $this->forms->create($data);
        $data['form_id'] = $form->id;

        $idLead = $this->anubis->getIdLead($data['tsource'], $request->get('client'));
        try {
            $response = $this->api->insert($data, $idLead);
        } catch (\Throwable $exception) {
            $form->queued = 1;
            $form->save();
            throw $exception;
        }
        $this->forms->updateResponse($form, $response);

        return response()->json()->withHeaders([
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
        ]);
    }
}
