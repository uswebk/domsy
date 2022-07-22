@extends('layouts.app')

@section('app')
  <auth-passwords-reset-page :token='@json($token)' :email='@json($email)'></auth-passwords-reset-page>
@endsection
