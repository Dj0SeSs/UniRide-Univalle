<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name', 'UniRide'))</title>

  <!-- Fuente básica (opcional) -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">

  <!-- Bootstrap 5 (si usas Vite, puedes quitar estas 2 líneas y dejar tus @vite) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Brand + Navbar UniRide -->
  <style>
    :root{
      --uv-red:#8f1d22;      /* base */
      --uv-red-dark:#6b1216; /* hover/focus */
    }
    .navbar-uv{ background:var(--uv-red) !important; }
    .navbar-uv .navbar-brand,
    .navbar-uv .nav-link,
    .navbar-uv .navbar-text{ color:#fff !important; }
    .navbar-uv .nav-link:hover,
    .navbar-uv .navbar-brand:hover{ color:#f3f4f6 !important; }
    .navbar-uv .btn-outline-light{
      border-color: rgba(255,255,255,.85) !important;
      color:#fff !important;
    }
    .navbar-uv .btn-outline-light:hover{
      background:var(--uv-red-dark) !important;
      border-color:var(--uv-red-dark) !important;
    }
    /* Espaciado consistente del contenido */
    main { padding-block: 1.5rem; }
  </style>

  @stack('head')
</head>
<body>
  <div id="app">

    <!-- NAVBAR rojo con título dinámico -->
    <nav class="navbar navbar-expand-md navbar-dark navbar-uv shadow-sm">
      <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ url('/') }}">
          @yield('navbar_title', 'UniRide')
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Alternar navegación">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Lado derecho -->
          <ul class="navbar-nav ms-auto">
            @guest
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Acceder</a></li>
              @if (Route::has('register'))
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
              @endif
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar sesión
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <!-- CONTENIDO -->
    <main>
      @yield('content')
    </main>
  </div>

  <!-- Bootstrap JS (si usas Vite, puedes quitar esta línea) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  @stack('scripts')
</body>
</html>
