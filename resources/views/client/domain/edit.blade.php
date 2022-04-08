<h1>Domain Edit</h1>

{{ $domain->name }}

<form action="{{ route('domain.update', $domain->id) }}" method="POST">
  @csrf
  <p>name:</p>
  <input type="text" name='name' value={{ old('name', $domain->name) }} ><br>
  <p>price:</p>
  <input type="text" name='price' value={{ old('price', $domain->price) }}><br>
  <p>is_active:</p>
  <input type="checkbox" name='is_active' value='1' {{ (old('is_active', $domain->is_active)) ? "checked" : "" }}><br>
  <p>is_transferred:</p>
  <input type="checkbox" name='is_transferred' value='1' {{ (old('is_transferred', $domain->is_transferred)) ? "checked" : "" }}><br>
  <p>is_management_only:</p>
  <input type="checkbox" name='is_management_only' value='1' {{ (old('is_management_only', $domain->is_management_only)) ? "checked" : "" }}><br>
  <p>purchased:</p>
  <input type="date" name='purchased' value={{ old('purchased', $domain->purchased) }}><br>
  <p>expired_date:</p>
  <input type="date" name='expired_date' value={{ old('expired_date', $domain->expired_date) }}><br>
  <p>canceled_at:</p>
  <input type="date" name='canceled_at' value={{ old('canceled_at', $domain->canceled_at) }}><br>

  <br>

  <button type="submit">
    {{ __('update') }}
  </button>
</form>