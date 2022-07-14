@extends('layouts.app')

@section('content')
  <dashboard-page v-bind:menus='{{ $applicationService->getMenuResource() }}'></dashboard-page>
@endsection
