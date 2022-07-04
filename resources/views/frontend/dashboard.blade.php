@extends('layouts.app')

@section('content')
  <div class='container'>
    <dashboard-page v-bind:menus='{{ $applicationService->getMenuResource() }}'></dashboard-page>
  </div>
@endsection
