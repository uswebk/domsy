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
      <th>ドメイン名</th>
      <th>価格</th>
      <th>稼働中</th>
      <th>移管済</th>
      <th>管理のみ</th>
      <th>購入日</th>
      <th>有効期限日</th>
      <th>解約日</th>
      <th>操作</th>
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
          {{ $domain->purchased->toDateString() }}
        </td>

        <td>
          {{ $domain->expired_date->toDateString() }}
        </td>

        <td>
          {{ $domain->canceled_at->toDateString() }}
        </td>

        <td>
          <a href="{{ route('domain.edit', $domain->id) }}"> edit </a><br>
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection
