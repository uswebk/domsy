@extends('layouts.app')

@section('content')
  <div class='container'>

    <h3>- Dashboard</h3>

    <div class='d-flex justify-content-left flex-wrap'>
      @foreach ($menus as $menu)
        @if ($menu->isScreen())
          <div class='card w-25 m-1'>
            <a href='{{ route($menu->route) }}' class='text-reset' style='text-decoration:none;'>
              <div class='card-body'>
                <h5 class='card-title'>{{ $menu->name }}</h5>
                <p class='card-text' style='color:gray'>{{ $menu->description }}</p>
              </div>
            </a>
          </div>
        @endif
      @endforeach
    </div>
  </div>
@endsection
