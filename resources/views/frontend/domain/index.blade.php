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

    <h1 class='h4 m-1'>Domain List</h1>

    <div class='container'>
      <a href='{{ route('domain.new') }}' class='btn btn-primary btn-sm active' role='button' aria-pressed='true'>+</a>
    </div>

    <table class='table table-hover mt-2'>
      <tr>
        <th>Domain Name</th>
        <th>Price</th>
        <th>Active</th>
        <th>Transferred</th>
        <th>Management <br>Only</th>
        <th>Purchased <br>Date</th>
        <th>Expired <br>Date</th>
        <th>Canceled <br>Date</th>
        <th>Action</th>
      </tr>

      @foreach ($domains as $domain)
        <tr>
          <td>
            <a href='{{ route('domain.edit', $domain->id) }}'> {{ $domain->name }} </a>
          </td>

          <td>
            {{ AppHelper::getPriceFormat($domain->price) }}
          </td>

          <td>
            {{ AppHelper::getCircleSymbol($domain->is_active) }}
          </td>

          <td>
            {{ AppHelper::getCircleSymbol($domain->is_transferred) }}
          </td>

          <td>
            {{ AppHelper::getCircleSymbol($domain->is_management_only) }}
          </td>

          <td>
            {{ DateHelper::getFormattedDateSlash($domain->purchased_at) }}
          </td>

          <td>
            {{ DateHelper::getFormattedDateSlash($domain->expired_at) }}
          </td>

          <td>
            @if(isset($domain->canceled_at))
              {{ DateHelper::getFormattedDateSlash($domain->canceled_at) }}
            @endif
          </td>

          <td>
            <a href='{{ route('domain.edit', $domain->id) }}' class='btn btn-primary btn-sm'> Edit</a>
            <a href='{{ route('dns.index', ['domain_id' => $domain->id]) }}' class='btn btn-warning btn-sm'> DNS</a>
            {{ Form::open(['url' => route('domain.delete', $domain->id), 'name' => 'delete-form']) }}
            {{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) }}
            {{ Form::close() }}
          </td>
        </tr>
      @endforeach
    </table>
  </div>
@endsection
