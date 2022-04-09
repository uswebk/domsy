<h1>Domain Edit</h1>

<p><a href="{{ route('domain.index') }}">←back</a></p>

{{ $domain->name }}

<form action="{{ route('domain.update', $domain->id) }}" method="POST">
  @csrf
  <p>name:</p>
  <input type="text" name='name' value={{ old('name', $domain->name) }} >
  @error('name')
      <strong>{{ $message }}</strong>
  @enderror

  <p>price:</p>
  <input type="text" name='price' value={{ old('price', $domain->price) }}>
  @error('price')
    <strong>{{ $message }}</strong>
  @enderror

  <p>is_active:</p>
  <input name="is_active" type="hidden" value="0">
  <input type="checkbox" name='is_active' value='1' {{ (old('is_active', $domain->is_active)) ? "checked" : "" }}>
  @error('is_active')
    <strong>{{ $message }}</strong>
  @enderror

  <p>is_transferred:</p>
  <input name="is_transferred" type="hidden" value="0">
  <input type="checkbox" name='is_transferred' value='1' {{ (old('is_transferred', $domain->is_transferred)) ? "checked" : "" }}>
  @error('is_transferred')
    <strong>{{ $message }}</strong>
  @enderror

  <p>is_management_only:</p>
  <input name="is_management_only" type="hidden" value="0">
  <input type="checkbox" name='is_management_only' value='1' {{ (old('is_management_only', $domain->is_management_only)) ? "checked" : "" }}>
  @error('is_management_only')
    <strong>{{ $message }}</strong>
  @enderror

  <p>purchased:</p>
  <input type="date" name='purchased' value={{ old('purchased', $domain->purchased) }}>
  @error('purchased')
    <strong>{{ $message }}</strong>
  @enderror

  <p>expired_date:</p>
  <input type="date" name='expired_date' value={{ old('expired_date', $domain->expired_date) }}>
  @error('expired_date')
    <strong>{{ $message }}</strong>
  @enderror

  <p>canceled_at:</p>
  <input type="date" name='canceled_at' value={{ old('canceled_at', $domain->canceled_at) }}>
  @error('canceled_at')
    <strong>{{ $message }}</strong>
  @enderror

  <br>

  <div><button type="submit">{{ __('update') }}</button></div>
</form>