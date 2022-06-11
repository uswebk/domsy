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

    <h1 class='h4 m-1'>DNS List</h1>

    @foreach ($domains as $domain)
      <ul class='list-group mb-2'>
        <li class='list-group-item'>
          <div class='row'>
            <span class='col-11'>{{ $domain->name }}</span>
            <span class='col-1 text-end'>
              <a href='{{ route('dns.new', ['domain' => $domain->id, 'domain_id' => $domainIdQuery]) }}'
                class='btn btn-primary btn-sm active' role='button' aria-pressed='true'>+</a>
            </span>
          </div>
        </li>

        <li class='list-group-item p-0 px-2 pt-1'>
          <dl class='row m-0'>
            <dd class='col-3 text-primary small'>Domain</dd>
            <dd class='col-1 text-primary small'>Type</dd>
            <dd class='col-3 text-primary small'>Value</dd>
            <dd class='col-1 text-primary small'>TTL</dd>
            <dd class='col-1 text-primary small'>Priority</dd>
            <dd class='col-3 text-primary small'>Action</dd>
          </dl>
        </li>

        @foreach ($domain->subdomains as $subdomain)
          <li class='list-group-item'>
            <dl class='row'>
              <dt class='col-3'>{{ $subdomain->full_domain_name }}</dt>
              <dd class='col-1'>{{ $subdomain->dns_type }}</dd>
              <dd class='col-3'>{{ $subdomain->value }}</dd>
              <dd class='col-1'>{{ $subdomain->ttl }}</dd>
              <dd class='col-1'>{{ $subdomain->priority }}</dd>

              <dd class='col-3'>
                <a href='{{ route('dns.edit', ['subdomain' => $subdomain->id, 'domain_id' => $domainIdQuery]) }}'
                  class='btn btn-primary btn-sm'> Edit</a>
                {{ Form::open(['url' => route('dns.delete', ['subdomain' => $subdomain->id, 'domain_id' => $domainIdQuery]),'name' => 'delete-form','class' => 'd-inline']) }}
                {{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) }}
                {{ Form::close() }}
              </dd>
            </dl>
          </li>
        @endforeach
      </ul>
    @endforeach
  </div>
@endsection
