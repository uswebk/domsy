@extends('layouts.app')

@section('app')
    <v-app>
        <p>Registerd!</p>
        <a href='{{ url('/mypage') }}' class='sg-btn'>Back To Mypage</a>
    </v-app>
@endsection
