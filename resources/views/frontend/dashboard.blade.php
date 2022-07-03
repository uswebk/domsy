@extends('layouts.app')

@section('content')
  <div class='container'>
    <dashboard-page v-bind:menus='{{ $menus }}'></dashboard-page>
  </div>
@endsection
