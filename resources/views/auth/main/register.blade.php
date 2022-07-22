@extends('layouts.app')

@section('app')
    <p>Registerd!</p>
    <a href='{{ url('/dashboard') }}' class='sg-btn'>Back To Dashboard</a>
@endsection
