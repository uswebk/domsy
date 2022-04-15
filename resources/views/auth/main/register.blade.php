@extends('layouts.app')

@section('content')
  @if (isset($error))
    {{ $error }}
  @else
    <p>Registerd!</p>
    <a href="{{ url('/') }}" class="sg-btn">Back To Top</a>
  @endif
@endsection
