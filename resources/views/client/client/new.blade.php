@extends('layouts.app')

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class='container m-0'>

    <h1 class='h4 m-1'>Client Create</h1>

    <a href='{{ route('client.index') }}' class='btn btn-secondary btn-sm'> < </a>

    {{ Form::open(['url' => route('client.store'), 'class' => 'w-50 p-3']) }}
    <div class='w-75 mt-2'>
      <div class='form-label'>{{ Form::label('client-name', 'Name') }}</div>

      <div>
        {{ Form::text('name', old('name'), ['placeholder' => '株式会社domsy','id' => 'client-name','class' => 'form-control']) }}
      </div>

      @error('name')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-75 mt-2'>
      <div class='form-label'>{{ Form::label('client-name_kana', 'Name Kana') }}</div>

      <div>
        {{ Form::text('name_kana', old('name_kana'), ['placeholder' => 'カブシキガイシャドムシー','id' => 'client-name_kana','class' => 'form-control']) }}
      </div>

      @error('name_kana')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-75 mt-2'>
      <div class='form-label'>{{ Form::label('client-email', 'Email') }}</div>

      <div>
        {{ Form::text('email', old('email'), ['placeholder' => 'domsy@example.com','id' => 'client-email','class' => 'form-control']) }}
      </div>

      @error('email')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-75 mt-2'>
      <div class='form-label'>{{ Form::label('client-zip', 'Zip') }}</div>

      <div>
        {{ Form::text('zip', old('zip'), ['placeholder' => '5300001', 'id' => 'client-zip', 'class' => 'form-control']) }}
      </div>

      @error('zip')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      <div class='form-label'>{{ Form::label('client-address', 'Address') }}</div>

      <div>
        {{ Form::text('address', old('address'), ['placeholder' => '大阪府大阪市淀川区...','id' => 'client-address','class' => 'form-control']) }}
      </div>

      @error('address')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-2'>
      <div class='form-label'>{{ Form::label('client-phone_number', 'Phone number') }}</div>

      <div>
        {{ Form::text('phone_number', old('phone_number'), ['placeholder' => '00000000000','id' => 'client-phone_number','class' => 'form-control']) }}
      </div>

      @error('phone_number')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='mt-5'>
      {{ Form::button('Create', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
      <div>
        {{ Form::close() }}
      </div>
    </div>

  </div>
@endsection
