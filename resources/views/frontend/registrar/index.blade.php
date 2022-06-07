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

    <h1 class='h4 m-1'>Registrar List</h1>

    <div class='container'>
      <a href='{{ route('registrar.new') }}' class='btn btn-primary btn-sm active' role='button' aria-pressed='true'>+</a>
    </div>

    <table class='table table-hover mt-2'>
      <tr>
        <th>Registrar Name</th>
        <th>URL</th>
        <th>Note</th>
        <th>Action</th>
      </tr>

      @foreach ($registrars as $registrar)
        <tr>
          <td>
            {{ $registrar->name }}
          </td>

          <td>
            {{ $registrar->link }}
          </td>

          <td>
            {{ $registrar->note }}
          </td>

          <td>
            <a href='{{ route('registrar.edit', $registrar->id) }}' class='btn btn-primary btn-sm'> Edit</a>

            {{ Form::open(['url' => route('registrar.delete', $registrar->id), 'name' => 'delete-form']) }}
              {{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) }}
            {{ Form::close() }}

          </td>
        </tr>
      @endforeach
    </table>

  </div>
@endsection
