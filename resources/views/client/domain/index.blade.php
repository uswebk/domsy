@extends('layouts.app')

@section('content')

<div class="container">

  @if(isset($greeting))
    <div class="alert alert-primary" role="alert">{{ $greeting }}</div>
  @endif

  <h1>Domain List</h1>

  <div class="container">
    <a href="{{ route('domain.new') }}" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">+</a>
  </div>

  <table class="table table-hover mt-2">
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

    @foreach($domains as $domain)
      <tr>
        <td>
          <a href="{{ route('domain.edit', $domain->id) }}"> {{ $domain->name }} </a>
        </td>

        <td>
          ￥{{ number_format($domain->price) }}
        </td>

        <td class="text-center">
          {{ AppHelper::getCircleSymbol($domain->is_active) }}
        </td>

        <td class="text-center">
          {{ AppHelper::getCircleSymbol($domain->is_transferred) }}
        </td>

        <td class="text-center">
          {{ AppHelper::getCircleSymbol($domain->is_management_only) }}
        </td>

        <td>
          {{ DateHelper::getFormattedDate($domain->purchased) }}
        </td>

        <td>
          {{ DateHelper::getFormattedDate($domain->expired_date) }}
        </td>

        <td>
          {{ DateHelper::getFormattedDate($domain->canceled_at) }}
        </td>

        <td>
          <a href="{{ route('domain.edit', $domain->id) }}"> edit</a>
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection
