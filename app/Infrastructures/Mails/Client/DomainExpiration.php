<?php

declare(strict_types=1);

namespace App\Infrastructures\Mails\Client;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

final class DomainExpiration extends Notification
{
    private $domains;
    private $domainNoticeNumberDays;

    public function __construct(
        \Illuminate\Database\Eloquent\Collection $domains,
        int $domainNoticeNumberDays
    ) {
        $this->domains = $domains;
        $this->domainNoticeNumberDays = $domainNoticeNumberDays;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(Lang::get('Notice of domain expiration date'))
            ->markdown('email.domain', [
                'domains' => $this->domains,
                'domainNoticeNumberDays' => $this->domainNoticeNumberDays,
            ]);
    }
}
