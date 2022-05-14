@component('mail::message')

  @foreach ($domains as $domain)
    {{ $domain->name }}
  @endforeach

@endcomponent