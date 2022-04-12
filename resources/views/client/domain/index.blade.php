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
          {{ DateHelper::getFormattedDate($domain->purchased_at) }}
        </td>

        <td>
          {{ DateHelper::getFormattedDate($domain->expired_at) }}
        </td>

        <td>
          {{ DateHelper::getFormattedDate($domain->canceled_at) }}
        </td>

        <td>
          <a href="{{ route('domain.edit', $domain->id) }}" class="btn btn-primary btn-sm"> edit</a>
          {{ Form::button('delete', ['class' => 'btn btn-danger btn-sm delete-btn', 'data-bs-toggle' => 'modal', 'data-bs-target'=>'deleteModal']) }}
        </td>
      </tr>
    @endforeach
  </table>
</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you really want to delete
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        {{ Form::open(['url' => '', 'name' => 'delete-form']) }}
          {{ Form::button('delete', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
        {{Form::close()}}
      </div>
    </div>
  </div>
</div>

@endsection


