@extends('layouts.app')

@section('content')

<div class='container'>

  <h1>Domain Edit</h1>

  <p><a href='{{ route('domain.index') }}'>←back</a></p>

  <div>{{ $domain->name }}</div>

  {{ Form::open(['url' => route('domain.update', $domain->id), 'class' =>'w-50 p-3']) }}
    <dl>
      <dt class='form-label'>{{ Form::label('domain-name', 'ドメイン名') }}</dt>

      <dd>{{ Form::text('name', old('name', $domain->name), ['placeholder' => 'example.com', 'id' => 'domain-name', 'class' => 'form-control']) }}</dd>

      @error('name')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </dl>

    <dl class='w-50'>
      <dt>{{ Form::label('domain-price', '価格') }}</dt>

      <dd>{{ Form::number('price', old('price', $domain->price), ['placeholder' => '1000', 'id' => 'domain-price', 'class' => 'form-control']) }}</dd>

      @error('price')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </dl>

    <dl class='w-25'>
      <dt>{{ Form::label('domain-purchased', '購入日') }}</dt>

      <dd>
        {{ Form::date('purchased',old('purchased', $domain->purchased), ['id' => 'domain-purchased','class' => 'form-control']) }}
      </dd>

      @error('purchased')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </dl>

    <dl class='w-25'>
      <dt>{{ Form::label('domain-expired_date', '有効期限日') }}</dt>

      <dd>
        {{ Form::date('expired_date',old('expired_date', $domain->expired_date), ['id' => 'domain-expired_date', 'class' => 'form-control']) }}
      </dd>

      @error('expired_date')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </dl>

    <dl class='w-25'>
      <dt>{{ Form::label('domain-canceled_at', '解約日') }}</dt>

      <dd>
        {{ Form::date('canceled_at',old('canceled_at', $domain->canceled_at), ['id' => 'domain-canceled_at', 'class' => 'form-control']) }}
      </dd>

      @error('canceled_at')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </dl>

    <div>
      {{ Form::hidden('domain-is_active', 0) }}
      {{ Form::checkbox('is_active', '1', old('is_active', $domain->is_active), ['id' => 'domain-is_active', 'class' => 'form-check-input']) }}
      {{ Form::label('is_active', '稼働中') }}

      @error('is_active')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div>
      {{ Form::hidden('domain-is_transferred', 0) }}
      {{ Form::checkbox('is_transferred', '1', old('is_transferred', $domain->is_transferred), ['id' => 'domain-is_transferred', 'class' => 'form-check-input']) }}
      {{ Form::label('is_transferred', '移管済') }}

      @error('domain-is_transferred')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div>
      {{ Form::hidden('domain-is_management_only', 0) }}
      {{ Form::checkbox('is_management_only', '1', old('is_management_only', $domain->is_management_only), ['id' => 'domain-is_management_only', 'class' => 'form-check-input']) }}
      {{ Form::label('is_management_only', '管理のみ') }}

      @error('is_management_only')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-1">
      {{ Form::button('更新', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    <div>

    {{Form::close()}}
</div>

@endsection
