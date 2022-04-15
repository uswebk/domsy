@extends('layouts.app')

@section('content')
  <div class="container">

    <h1>Dashboard</h1>

    <a href="{{ route('domain.index') }}">Domain Management</a><br>
    <a href="{{ route('dns.index') }}">DNS Management</a>

  </div>
@endsection
