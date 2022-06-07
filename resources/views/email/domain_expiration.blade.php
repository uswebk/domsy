@component('mail::message')

  It's {{ $domainNoticeNumberDays }} days before the domain expiration date.

  Domain List <br>

  @foreach ($domains as $domain)
    {{ $domain->name }} | {{ AppHelper::getPriceFormat($domain->price) }} | {{ DateHelper::getFormattedDateSlash($domain->expired_at) }}
  @endforeach

@endcomponent