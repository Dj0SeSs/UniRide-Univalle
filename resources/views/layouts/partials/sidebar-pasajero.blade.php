<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #8f1d22;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }} Pasajero</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Mis Viajes -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pasajero.trips.my_trips') }}">
            <i class="fas fa-route"></i>
            <span>Mis Viajes</span>
        </a>
    </li>

    <!-- Viajes Disponibles -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pasajero.trips.index') }}">
            <i class="fas fa-search"></i>
            <span>Viajes Disponibles</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
</ul>
