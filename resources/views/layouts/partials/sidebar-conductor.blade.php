<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }} Conductor</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Vehículos -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('conductor.vehicles.index') }}">
        <i class="fas fa-car"></i>
        <span>Mis Vehículos</span>
    </a>
</li>

<!-- Viajes -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('conductor.trips.index') }}">
        <i class="fas fa-route"></i>
        <span>Viajes</span>
    </a>
</li>




    <hr class="sidebar-divider d-none d-md-block">
</ul>
