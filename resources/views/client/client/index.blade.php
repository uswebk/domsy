@extends('layouts.app')

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class='container m-0'>

    @if (isset($greeting))
      <div class='alert alert-primary' role='alert'>{{ $greeting }}</div>
    @elseif(isset($failing))
      <div class='alert alert-danger' role='alert'>{{ $failing }}</div>
    @endif

    <h1 class='h4 m-1'>Client List</h1>

    <div class='container'>
      <a href='{{ route('client.new') }}' class='btn btn-primary btn-sm active' role='button' aria-pressed='true'>+</a>
    </div>

    <table class='table table-hover mt-2'>
      <tr>
        <th>Clientt Name</th>
        <th>Email</th>
        <th>Zip</th>
        <th>Address</th>
        <th>TEL</th>
        <th>Action</th>
      </tr>

      @foreach ($clients as $client)
        <tr>
          <td>
            {{ $client->name }}
          </td>

          <td>
            {{ $client->email }}
          </td>

          <td>
            {{ $client->zip }}
          </td>

          <td>
            {{ $client->address }}
          </td>

          <td>
            {{ $client->phone_number }}
          </td>

          <td>
            <a href='{{ route('client.edit', $client->id) }}' class='btn btn-primary btn-sm'> Edit</a>

            {{ Form::open(['url' => route('client.delete', $client->id), 'name' => 'delete-form']) }}
            {{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) }}
            {{ Form::close() }}

          </td>
        </tr>
      @endforeach
    </table>

  </div>
@endsection
