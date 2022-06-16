@extends('layouts.app')

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class='container m-0'>
    <h1 class='h4 m-1'>Dealing Detail</h1>

    <a href='{{ route('dealing.index') }}' class='btn btn-secondary btn-sm'> back </a>
  </div>
@endsection
