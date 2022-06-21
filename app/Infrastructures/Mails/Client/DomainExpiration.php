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

    /**
     * @param \Illuminate\Database\Eloquent\Collection $domains
     * @param integer $domainNoticeNumberDays
     */
    public function __construct(
        \Illuminate\Database\Eloquent\Collection $domains,
        int $domainNoticeNumberDays
    ) {
        $this->domains = $domains;
        $this->domainNoticeNumberDays = $domainNoticeNumberDays;
    }

    /**
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(): \Illuminate\Notifications\Messages\MailMessage
    {
        return (new MailMessage())
            ->subject(Lang::get('Notice of domain expiration date'))
            ->markdown('email.domain_expiration', [
                'domains' => $this->domains,
                'domainNoticeNumberDays' => $this->domainNoticeNumberDays,
            ]);
    }
}
