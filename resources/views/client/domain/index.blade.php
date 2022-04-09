<h1>Domain</h1>

@if(isset($greeting))
  {{ $greeting }}
@endif

@foreach($domains as $domain)

  <p>
    <a href="{{ route('domain.edit', $domain->id) }}"> {{ $domain->name }} </a>
  </p>

@endforeach