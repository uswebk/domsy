@extends('layouts.app')

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class="container m-0">

    <h1 class="h4 m-1">Registrar Create</h1>

    <a href='{{ route('registrar.index') }}' class="btn btn-secondary btn-sm"> < </a>

    {{ Form::open(['url' => route('domain.store'), 'class' => 'w-50 p-3']) }}
    <div class='w-75 mt-2'>
      <div class='form-label'>{{ Form::label('registrar-name', 'Registrar Name') }}</div>

      <div>
        {{ Form::text('name', old('name'), ['placeholder' => '', 'id' => 'registrar-name', 'class' => 'form-control']) }}
      </div>

      @error('name')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-75 mt-2'>
      <div class='form-label'>{{ Form::label('registrar-link', 'Registrar link') }}</div>

      <div>
        {{ Form::text('link', old('link'), ['placeholder' => 'https://example.com','id' => 'registrar-link','class' => 'form-control']) }}
      </div>

      @error('link')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-75 mt-2'>
      <div class='form-label'>{{ Form::label('registrar-note', 'Registrar note') }}</div>

      <div>
        {{ Form::textarea('note', old('note'), ['rows' => '3','placeholder' => 'Remarks','id' => 'registrar-note','class' => 'form-control']) }}
      </div>

      @error('note')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-5">
      {{ Form::button('Create', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
      <div>
        {{ Form::close() }}
      </div>
    </div>

  </div>
@endsection
