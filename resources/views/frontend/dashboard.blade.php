@extends('layouts.app')

@section('content')
  <div class='container'>

    <h3>- Dashboard</h3>

    <div class='d-flex justify-content-left flex-wrap'>
      @foreach ($menus as $menu)
        <div class='card w-25 m-1'>
          <div class='card-body'>
            <h5 class='card-title'>{{ $menu->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"><!-- TODO:MenuDescription --></h6>
            @foreach ($menu->menuItems as $menuItem)
              @if ($menuItem->isScreen())
                <a href='{{ route($menuItem->route) }}' class='card-link'>
                  {{ $menuItem->name }}
                </a>
              @endif
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
