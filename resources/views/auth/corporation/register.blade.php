@extends('layouts.app')

@section('content')
  <form method='POST' action='{{ route('corporation.register') }}'>
    @csrf

    <h6>Corporation</h6>
    <hr />

    <div class='row mb-3'>
      <label for='name' class='col-md-4 col-form-label text-md-end'>{{ __('Name') }}</label>

      <div class='col-md-6'>
        <input id='name' type='text' class='form-control @error('corporation[name]') is-invalid @enderror'
          name='corporation[name]' value='{{ old('corporation[name]') }}' required autocomplete='name'>

        @error('corporation[name]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class='row mb-3'>
      <label for='email' class='col-md-4 col-form-label text-md-end'>{{ __('Email') }}</label>

      <div class='col-md-6'>
        <input id='email' type='text' class='form-control @error('corporation[email]') is-invalid @enderror'
          name='corporation[email]' value='{{ old('corporation[email]') }}' required autocomplete='email'>

        @error('corporation[email]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class='row mb-3'>
      <label for='zip' class='col-md-4 col-form-label text-md-end'>{{ __('Zip') }}</label>

      <div class='col-md-6'>
        <input id='zip' type='text' class='form-control @error('corporation[zip]') is-invalid @enderror'
          name='corporation[zip]' value='{{ old('corporation[zip]') }}' required autocomplete='zip'>

        @error('corporation[zip]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class='row mb-3'>
      <label for='address' class='col-md-4 col-form-label text-md-end'>{{ __('Address') }}</label>

      <div class='col-md-6'>
        <input id='address' type='text' class='form-control @error('corporation[address]') is-invalid @enderror'
          name='corporation[address]' value='{{ old('corporation[address]') }}' required autocomplete='address'>

        @error('corporation[address]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class='row mb-3'>
      <label for='phone_number' class='col-md-4 col-form-label text-md-end'>{{ __('Phone Number') }}</label>

      <div class='col-md-6'>
        <input id='phone_number' type='text'
          class='form-control @error('corporation[phone_number]') is-invalid @enderror' name='corporation[phone_number]'
          value='{{ old('corporation[phone_number]') }}' required autocomplete='phone_number'>

        @error('corporation[phone_number]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>

    <hr />

    <h6>Individual</h6>
    <hr />
    <div class='row mb-3'>
      <label for='name' class='col-md-4 col-form-label text-md-end'>{{ __('Name') }}</label>

      <div class='col-md-6'>
        <input id='name' type='text' class='form-control @error('individual[name]') is-invalid @enderror'
          name='individual[name]' value='{{ old('individual[name]') }}' required autocomplete='name'>

        @error('individual[name]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class='row mb-3'>
      <label for='email' class='col-md-4 col-form-label text-md-end'>{{ __('Email Address') }}</label>

      <div class='col-md-6'>
        <input id='email' type='email' class='form-control @error('individual[email]') is-invalid @enderror'
          name='individual[email]' value='{{ old('individual[email]') }}' required autocomplete='email'>

        @error('individual[email]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>

    <div class='row mb-3'>
      <label for='password' class='col-md-4 col-form-label text-md-end'>{{ __('Password') }}</label>

      <div class='col-md-6'>
        <input id='password' type='password' class='form-control @error('individual[password]') is-invalid @enderror'
          name='individual[password]' required autocomplete='new-password'>

        @error('individual[password]')
          <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>

    <div class='row mb-3'>
      <label for='password-confirm' class='col-md-4 col-form-label text-md-end'>{{ __('Confirm Password') }}</label>

      <div class='col-md-6'>
        <input id='password-confirm' type='password' class='form-control' name='individual[password_confirmation]'
          required autocomplete='new-password'>
      </div>
    </div>

    <div class='row mb-0'>
      <div class='col-md-6 offset-md-4'>
        <button type='submit' class='btn btn-primary'>
          {{ __('Register') }}
        </button>
      </div>
    </div>
  </form>
@endsection
