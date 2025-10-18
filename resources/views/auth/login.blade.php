<!DOCTYPE html>
<html lang="es">
<style>
  /* ====== Paleta Univalle ====== */
  :root{
  /* Rojo más sobrio */
  --uv-red: #8f1d22;      /* base */
  --uv-red-dark: #6b1216; /* hover/focus */
  }

  /* Fondo que antes era azul */
  body.bg-gradient-primary{
    background-image: linear-gradient(180deg, var(--uv-red) 10%, var(--uv-red-dark) 100%) !important;
  }

  /* Botón primario */
  .btn-primary{
    background-color: var(--uv-red) !important;
    border-color: var(--uv-red) !important;
  }
  .btn-primary:hover,
  .btn-primary:focus{
    background-color: var(--uv-red-dark) !important;
    border-color: var(--uv-red-dark) !important;
    box-shadow: 0 0 0 .2rem rgba(200,30,37,.25) !important;
  }

  /* Enlaces de acción (Olvidaste tu contraseña / Crear cuenta) */
  a.small, a.small:visited{
    color: var(--uv-red) !important;
  }
  a.small:hover{
    color: var(--uv-red-dark) !important;
  }

  /* Borde/Glow en inputs al enfocar (para que no quede azul) */
  .form-control:focus{
    border-color: var(--uv-red) !important;
    box-shadow: 0 0 0 .2rem rgba(200,30,37,.25) !important;
  }

  /* Checkbox “Recordarme” en rojo */
  .custom-control-input:checked ~ .custom-control-label::before{
    background-color: var(--uv-red) !important;
    border-color: var(--uv-red) !important;
  }
  .custom-control-input:focus ~ .custom-control-label::before{
    box-shadow: 0 0 0 .2rem rgba(200,30,37,.25) !important;
  }
</style>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>UniRide – Iniciar sesión</title>

    <!-- Fuentes / estilos del template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Imagen de fondo para la columna izquierda --}}
    <style>
      .bg-login-image{
        background-image: url('{{ asset('img/login-driver.jpg') }}') !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 520px; /* asegura altura en desktop */
      }
    </style>
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>

              <div class="col-lg-6">
                <div class="p-5">

                  <div class="text-center mb-4">
                    <h1 class="h4 text-gray-900 mb-2">¡Bienvenido de nuevo!</h1>
                    <p class="text-muted mb-0">Inicia sesión para continuar</p>
                  </div>

                  {{-- Mensajes del backend --}}
                  @if (session('error'))
                    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                  @endif

                  @if (session('status'))
                    <div class="alert alert-success mb-3">{{ session('status') }}</div>
                    {{-- p. ej.: “Se ha enviado un enlace para restablecer tu contraseña a tu correo.” --}}
                  @endif

                  <!-- Formulario de Login -->
                  <form method="POST" action="{{ route('login') }}" class="user">
                    @csrf

                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user"
                             placeholder="Correo electrónico" value="{{ old('email') }}" required autofocus>
                      @error('email')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user"
                             placeholder="Contraseña" required>
                      @error('password')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="form-group d-flex align-items-center justify-content-between">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="remember" class="custom-control-input" id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customCheck">Recordarme</label>
                      </div>

                      @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                      @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Iniciar sesión
                    </button>
                  </form>

                  <hr>

                  <div class="text-center">
                    <a class="small" href="{{ route('register') }}">Crear una cuenta</a>
                  </div>
                </div>
              </div>

            </div><!-- /.row -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS del template -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>
