@extends('layouts.app')

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class="container m-0">

    <h1 class="h4 m-1">Domain Edit</h1>

    <p><a href='{{ route('domain.index') }}'>←back</a></p>

    <div class="border-bottom">
      <p class="fs-4 m-0">{{ $domain->name }}</p>
    </div>

    {{ Form::open(['url' => route('domain.update', $domain->id), 'class' => 'w-50 p-3']) }}

    <div class='w-50 mt-2'>
      <div class='form-label'>{{ Form::label('domain-name', 'Domain Name') }}</div>

      <div>
        {{ Form::text('name', old('name', $domain->name), ['placeholder' => 'example.com','id' => 'domain-name','class' => 'form-control']) }}
      </div>

      @error('name')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-50 mt-2'>
      <div>{{ Form::label('domain-price', 'Price') }}</div>

      <div>
        {{ Form::number('price', old('price', $domain->price), ['placeholder' => '1000','id' => 'domain-price','class' => 'form-control']) }}
      </div>

      @error('price')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('domain-purchased_at', 'Purchased Date') }}</div>

      <div>
        {{ Form::date('purchased_at', old('purchased_at', $domain->purchased_at), ['id' => 'domain-purchased_at','class' => 'form-control']) }}
      </div>

      @error('purchased_at')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('domain-expired_at', 'Expired Date') }}</div>

      <div>
        {{ Form::date('expired_at', old('expired_at', $domain->expired_at), ['id' => 'domain-expired_at','class' => 'form-control']) }}
      </div>

      @error('expired_at')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('domain-canceled_at', 'Canceled Date') }}</div>

      <div>
        {{ Form::date('canceled_at', old('canceled_at', $domain->canceled_at), ['id' => 'domain-canceled_at','class' => 'form-control']) }}
      </div>

      @error('canceled_at')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      {{ Form::hidden('is_active', 0) }}
      {{ Form::checkbox('is_active', '1', old('is_active', $domain->is_active), ['id' => 'domain-is_active','class' => 'form-check-input']) }}
      {{ Form::label('domain-is_active', 'Active') }}

      @error('is_active')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      {{ Form::hidden('is_transferred', 0) }}
      {{ Form::checkbox('is_transferred', '1', old('is_transferred', $domain->is_transferred), ['id' => 'domain-is_transferred','class' => 'form-check-input']) }}
      {{ Form::label('domain-is_transferred', 'Transferred') }}

      @error('is_transferred')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      {{ Form::hidden('is_management_only', 0) }}
      {{ Form::checkbox('is_management_only', '1', old('is_management_only', $domain->is_management_only), ['id' => 'domain-is_management_only','class' => 'form-check-input']) }}
      {{ Form::label('domain-is_management_only', 'Management Only') }}

      @error('is_management_only')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-5">
      {{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
      <div>

        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection
