<?php

declare(strict_types=1);

namespace App\Mails\Client;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

final class DomainExpiration extends Notification
{
    private Collection $domains;

    private int $domainNoticeNumberDays;

    /**
     * @param Collection $domains
     * @param integer $domainNoticeNumberDays
     */
    public function __construct(Collection $domains, int $domainNoticeNumberDays)
    {
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
     * @return MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject(Lang::get('Notice of domain expiration date'))
            ->markdown('email.domain_expiration', [
                'domains' => $this->domains,
                'domainNoticeNumberDays' => $this->domainNoticeNumberDays,
            ]);
    }
}
