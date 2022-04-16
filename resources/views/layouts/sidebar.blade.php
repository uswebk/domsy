<div class='card'>
  <div class='list-group list-group-flush'>
    <a href='{{ route('dashboard.index') }}' class='list-group-item list-group-item-action'> Dashboard </a>
    <div class='card-header'>Domain</div>

    <a href='{{ route('domain.index') }}' class='list-group-item list-group-item-action'> Domain List </a>

    <a href='{{ route('domain.new') }}' class='list-group-item list-group-item-action'> Domain Crate </a>

    <a href='{{ route('dns.index') }}' class='list-group-item list-group-item-action'> DNS List </a>

    <div class='card-header'>Registrar</div>

    <a href='{{ route('registrar.index') }}' class='list-group-item list-group-item-action'> Registrar List </a>

    <a href='{{ route('registrar.new') }}' class='list-group-item list-group-item-action'> Registrar Create </a>
  </div>
</div>
