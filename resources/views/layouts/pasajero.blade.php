<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ env('APP_NAME') }} - Pasajero</title>

    <!-- Custom fonts -->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style>
        /* 🎨 Colores del sidebar para pasajero */
        .sidebar .sidebar-brand {
            background-color: #8f1d22 !important; /* rojo */
        }

        .sidebar .sidebar-brand-text {
            color: white !important;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar {
            background-color: #2e2e2e;
        }

        /* Botón de usuario con nombre completo y hover rojo */
        .user-btn {
            color: #8f1d22 !important;
            background-color: white !important;
            border: 2px solid #8f1d22;
            border-radius: 30px;
            padding: 6px 14px; /* ancho adaptativo */
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap; /* evita que el nombre se corte */
        }

        .user-btn i {
            margin-right: 8px;
            font-size: 20px; /* icono más grande */
        }

        .user-btn:hover {
            background-color: #8f1d22 !important;
            color: white !important;
            transform: scale(1.05);
            text-decoration: none;
        }

        .user-btn:hover i {
            color: white !important;
        }
    </style>

    @stack('styles')
</head>
<body id="page-top">

<div id="wrapper">

    @include('layouts.partials.sidebar-pasajero') <!-- Sidebar específico para pasajero -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Botón menú responsive -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Menú de usuario con nombre completo -->
                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle user-btn" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            <span class="mr-2 d-lg-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Salir
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            @yield('content') <!-- Contenido dinámico de pasajero -->

        </div>

        @include('layouts.partials.footer')
    </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('layouts.partials.logout-modal')

<!-- Scripts -->
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

@stack('scripts')
@include('sweetalert::alert')

</body>
</html>
