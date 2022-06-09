<?php

declare(strict_types=1);

namespace App\Infrastructures\Mails\Client;

use Carbon\Carbon;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

final class EmailVerification extends Notification
{
    /**
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * @param  $notifiable
     * @return void
     */
    public function toMail($notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $verificationUrl)
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }

    /**
     * @param  $notifiable
     * @return void
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => $notifiable->email_verify_token,
            ]
        );
    }
}
