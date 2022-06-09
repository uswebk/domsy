@extends('layouts.app')

@section('content')
  <div class='container'>

    <h1>Dashboard</h1>

    @foreach ($menus as $menu)

      @if($menu->isScreen())
        <a href='{{ route($menu->route) }}'>

          {{ $menu->name }}

        </a>
      @endif

    @endforeach

  </div>
@endsection
