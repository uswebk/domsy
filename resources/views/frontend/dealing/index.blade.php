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

    <h1 class='h4 m-1'>Dealings</h1>

    <div class='container'>
      <a href='{{ route('dealing.new') }}' class='btn btn-primary btn-sm active' role='button'
        aria-pressed='true'>+</a>
    </div>

    <table class='table table-hover mt-2'>
      <tr>
        <th>Domain Name</th>
        <th>Client Name</th>
        <th>Subtotal</th>
        <th>First Billing Date</th>
        <th>Interval</th>
        <th>Auto Update</th>
        <th>Action</th>
      </tr>
      @foreach ($domains as $domain)
        @foreach ($domain->domainDealings as $domainDealing)

          <tr>
            <td>
              {{ $domain->name }}
            </td>

            <td>
              {{ $domainDealing->client->name }}
            </td>

            <td>
              {{ AppHelper::getPriceFormat($domainDealing->subtotal) }}
            </td>

            <td>
              {{ DateHelper::getDateStringSlash($domainDealing->billing_date) }}
            </td>

            <td>
              {{ $domainDealing->interval }}
              {{ $intervalCategories[$domainDealing->interval_category] }}
            </td>

            <td>
              {{ AppHelper::getCircleSymbol($domainDealing->is_auto_update) }}
            </td>

            <td>
              <a href='{{ route('dealing.edit', $domainDealing->id) }}' class='btn btn-primary btn-sm'>Edit</a>
              <a href='{{ route('dealing.detail', $domainDealing->id) }}' class='btn btn-primary btn-sm'>Detail</a>
            </td>
        @endforeach
      @endforeach

    </table>

  </div>
@endsection
