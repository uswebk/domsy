@extends('layouts.app')

@section('app')
    <v-app>
        <p>Registerd!</p>
        <a href='{{ url('/dashboard') }}' class='sg-btn'>Back To Dashboard</a>
    </v-app>
@endsection
