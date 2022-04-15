@extends('layouts.app')

@section('content')

<div class='container'>

  <h1>DNS Edit</h1>

  <p><a href='{{ route('dns.index') }}'>←back</a></p>

  <h2>{{ $domainDnsRecord->full_domain_name }}</h2>

  {{ Form::open(['url' => route('dns.update',['domainDnsRecord' => $domainDnsRecord->id, 'domain_id' => $domainIdQuery]), 'class' =>'w-50 p-3']) }}

    <div class='w-25 mt-2'>
      <div class='form-label'>{{ Form::label('dns-subdomain', 'Subdomain') }}</div>

      <div>{{ Form::text('subdomain', old('subdomain', $domainDnsRecord->subdomain ), ['placeholder' => 'www', 'id' => 'dns-subdomain', 'class' => 'form-control']) }} .{{ $domainDnsRecord->domain->name }}</div>

      @error('subdomain')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('dns-type-id', 'Type') }}</div>

      <div>{{ Form::select('type_id', $dnsTypeIds, old('type_id', $domainDnsRecord->type_id), ['class' => 'form-control']) }}</div>

      @error('type_id')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-50 mt-2'>
      <div>{{ Form::label('dns-value', 'Value') }}</div>

      <div>{{ Form::text('value', old('value', $domainDnsRecord->value), ['id' => 'dns-value','class' => 'form-control']) }}</div>

      @error('value')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('dns-ttl', 'TTL') }}</div>

      <div>{{ Form::number('ttl',old('ttl', $domainDnsRecord->ttl), ['id' => 'dns-ttl', 'class' => 'form-control']) }}</div>

      @error('ttl')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class='w-25 mt-2'>
      <div>{{ Form::label('dns-priority', 'Priority') }}</div>

      <div>{{ Form::number('priority',old('priority', $domainDnsRecord->priority), ['id' => 'dns-priority', 'class' => 'form-control']) }}</div>

      @error('priority')
        <div class='invalid-feedback d-block'>{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-5">
      {{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    <div>

    {{ Form::close() }}
</div>

@endsection
