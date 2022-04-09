@extends('layouts.app')

@section('content')

<div class="container">
  <h1>Domain List</h1>

  @if(isset($greeting))
    {{ $greeting }}
  @endif

  @foreach($domains as $domain)

    <p>
      <a href="{{ route('domain.edit', $domain->id) }}"> {{ $domain->name }} </a>
    </p>

  @endforeach
</div>
@endsection
