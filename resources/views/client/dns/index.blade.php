@extends('layouts.app')

@section('content')

<div class="container">

  <h1>DNS List</h1>

  @if(isset($greeting))

    <div class="alert alert-primary" role="alert">{{ $greeting }}</div>

  @elseif(isset($failing))

    <div class="alert alert-danger" role="alert">{{ $failing }}</div>

  @endif


  @foreach($domains as $domain)
  <ul class="list-group m-2">
      <li class="list-group-item">
        <div class="row">
          <span class="col-11">{{ $domain->name }}</span>
          <span class="col-1 text-end">
            <a href="{{ route('dns.new', $domain->id) }}" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">+</a>
          </span>
        </div>
      </li>

      <li class="list-group-item p-0 px-2 pt-1">
        <dl class="row m-0">
          <dd class="col-3 text-primary small">Domain</dd>
          <dd class="col-1 text-primary small">Type</dd>
          <dd class="col-3 text-primary small">Value</dd>
          <dd class="col-1 text-primary small">TTL</dd>
          <dd class="col-1 text-primary small">Priority</dd>
          <dd class="col-2 text-primary small">Action</dd>
        </dl>
      </li>

      @foreach($domain->domainDnsRecords as $domainDnsRecord)

        <li class="list-group-item">
          <dl class="row">
            <dt class="col-3">{{ $domainDnsRecord->full_domain_name }}</dt>
            <dd class="col-1">{{ $domainDnsRecord->dns_type }}</dd>
            <dd class="col-3">{{ $domainDnsRecord->value }}</dd>
            <dd class="col-1">{{ $domainDnsRecord->ttl }}</dd>
            <dd class="col-1">{{ $domainDnsRecord->priority }}</dd>
            <dd class="col-2">Edit</dd>
          </dl>
        </li>

      @endforeach
  </ul>
  @endforeach
</div>
@endsection


