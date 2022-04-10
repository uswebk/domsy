@extends('layouts.app')

@section('content')

<div class='container'>

  <h1>Domain Create</h1>

  <p><a href='{{ route('domain.index') }}'>←back</a></p>

  {{ Form::open(['url' => route('domain.create'), 'class' =>'w-50 p-3']) }}
    <div class='w-50 mt-2'>
      <div class='form-label'>{{ Form::label('domain-name', 'ドメイン名') }}</div>

      <div>{{ Form::text('name', old('name'), ['placeholder' => 'example.com', 'id' => 'domain-name', 'class' => 'form-control']) }}</div>

      @error('name')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-50 mt-2'>
      <div>{{ Form::label('domain-price', '価格') }}</div>

      <div>{{ Form::number('price', old('price'), ['placeholder' => '1000', 'id' => 'domain-price', 'class' => 'form-control']) }}</div>

      @error('price')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('domain-purchased', '購入日') }}</div>

      <div>{{ Form::date('purchased',old('purchased'), ['id' => 'domain-purchased','class' => 'form-control']) }}</div>

      @error('purchased')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('domain-expired_date', '有効期限日') }}</div>

      <div>{{ Form::date('expired_date',old('expired_date'), ['id' => 'domain-expired_date', 'class' => 'form-control']) }}</div>

      @error('expired_date')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('domain-canceled_at', '解約日') }}</div>

      <div>{{ Form::date('canceled_at',old('canceled_at'), ['id' => 'domain-canceled_at', 'class' => 'form-control']) }}</div>

      @error('canceled_at')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      {{ Form::hidden('is_active', 0) }}
      {{ Form::checkbox('is_active', '1', old('is_active'), ['id' => 'domain-is_active', 'class' => 'form-check-input']) }}
      {{ Form::label('domain-is_active', '稼働中') }}

      @error('is_active')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      {{ Form::hidden('is_transferred', 0) }}
      {{ Form::checkbox('is_transferred', '1', old('is_transferred'), ['id' => 'domain-is_transferred', 'class' => 'form-check-input']) }}
      {{ Form::label('domain-is_transferred', '移管済') }}

      @error('is_transferred')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      {{ Form::hidden('is_management_only', 0) }}
      {{ Form::checkbox('is_management_only', '1', old('is_management_only'), ['id' => 'domain-is_management_only', 'class' => 'form-check-input']) }}
      {{ Form::label('domain-is_management_only', '管理のみ') }}

      @error('is_management_only')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-5">
      {{ Form::button('作成', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    <div>

    {{Form::close()}}
</div>

@endsection
