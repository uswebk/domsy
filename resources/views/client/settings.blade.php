@extends('layouts.app')

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class='container'>

    <h1>Setting</h1>

    <setting-index v-bind:mail-categories='{{ $mailCategories }}'></setting-index>

    {{-- @foreach ($mailCategories as $mailCategory ) --}}

    {{-- {{ Form::open(['url' => route('settings.post'), 'name' => 'delete-form']) }}

      {{ $mailCategory->annotation }} <br>

    {{ Form::close() }}
 --}}
    {{-- @endforeach --}}
  </div>
@endsection
