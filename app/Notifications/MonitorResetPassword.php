<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class MonitorResetPassword extends ResetPassword
{
    protected function resetUrl($notifiable)
    {
        return rtrim(config('monitor.public_url'), '/').route('password.reset', [
            'token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset(),
        ], false);
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)->subject('Restablece tu contraseña · Ofertas Tienda')
            ->view('monitor.emails.reset-password', [
                'url' => $url, 'minutes' => config('auth.passwords.users.expire'),
            ]);
    }
}
