<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>UniRide – Crear cuenta</title>

  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900" rel="stylesheet">
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

  <style>
    :root{
      --uv-red:#8f1d22;        /* base sobrio */
      --uv-red-dark:#6b1216;   /* hover/focus */
      --text-strong:#111827;   /* casi negro */
      --muted:#4b5563;         /* gris 600 */
    }

    /* Fondo rojo como en login */
    body.bg-gradient-primary{
      background-image: linear-gradient(180deg, var(--uv-red) 10%, var(--uv-red-dark) 100%) !important;
    }

    /* Centrado y card más compacta */
    .wrap{ min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1.25rem; }
    .card{ border-radius:14px; }
    .card-compact{ max-width:620px; margin:0 auto; }
    .p-compact{ padding:1.25rem !important; } /* menos padding */

    /* Tipografía y legibilidad */
    .title-strong{ color:var(--text-strong)!important; }
    .subtle{ color:var(--muted)!important; }

    /* Inputs cómodos pero no gigantes */
    .form-control-user{
      padding:.8rem 1rem;
      border-radius:9999px;
    }
    .form-control::placeholder{ color:#9ca3af; }
    .form-control:focus{
      border-color:var(--uv-red) !important;
      box-shadow:0 0 0 .18rem rgba(143,29,34,.18) !important;
    }

    /* Botón primario */
    .btn-primary{ background-color:var(--uv-red)!important; border-color:var(--uv-red)!important; }
    .btn-primary:hover,.btn-primary:focus{
      background-color:var(--uv-red-dark)!important; border-color:var(--uv-red-dark)!important;
      box-shadow:0 0 0 .2rem rgba(143,29,34,.25)!important;
    }

    /* Botón “ojo” a la altura del input */
    .input-group .btn-eye{
      border:1px solid #e5e7eb; background:#fff; border-radius:0 9999px 9999px 0; padding:.8rem 1rem;
    }

    a.small, a.small:visited{ color:var(--uv-red)!important; }
    a.small:hover{ color:var(--uv-red-dark)!important; }
    .helper{ font-size:.85rem; color:#6b7280; margin-top:.25rem; }
  </style>
</head>

<body class="bg-gradient-primary">
  <div class="wrap">
    <div class="container">
      <div class="card o-hidden border-0 shadow-lg card-compact">
        <div class="card-body p-compact">

          <div class="text-center mb-3">
           <img src="{{ asset('img/logo_register.svg') }}" alt="UniRide" class="brand-logo mb-2">
           <h2 class="h4 title-strong mb-1">¡Crea tu cuenta!</h2>
           <p class="subtle mb-0">Regístrate para comenzar a usar UniRide</p>
          </div>


          {{-- Mensajes --}}
          @if (session('status'))
            <div class="alert alert-success mb-3">{{ session('status') }}</div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger mb-3">
              <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}" class="user">
            @csrf

            <div class="form-group mb-3">
              <label for="name" class="small text-muted mb-1">Nombre completo</label>
              <input id="name" type="text"
                     class="form-control form-control-user @error('name') is-invalid @enderror"
                     name="name" value="{{ old('name') }}" required autocomplete="name"
                     placeholder="Ej. María Fernanda Ruiz">
              @error('name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="form-group mb-3">
              <label for="email" class="small text-muted mb-1">Correo electrónico</label>
              <input id="email" type="email"
                     class="form-control form-control-user @error('email') is-invalid @enderror"
                     name="email" value="{{ old('email') }}" required autocomplete="email"
                     placeholder="tucorreo@ejemplo.com">
              @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>

            {{-- Contraseña (ancho completo) --}}
            <div class="form-group mb-3">
              <label for="password" class="small text-muted mb-1">Contraseña</label>
              <div class="input-group">
                <input id="password" type="password"
                       class="form-control form-control-user @error('password') is-invalid @enderror"
                       name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
                <div class="input-group-append">
                  <button type="button" class="btn btn-eye" onclick="togglePass('password', this)" title="Mostrar/ocultar">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
              @error('password') <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="form-group mb-3">
              <label for="password-confirm" class="small text-muted mb-1">Confirmar contraseña</label>
              <div class="input-group">
                <input id="password-confirm" type="password"
                       class="form-control form-control-user"
                       name="password_confirmation" required autocomplete="new-password"
                       placeholder="Vuelve a escribir tu contraseña">
                <div class="input-group-append">
                  <button type="button" class="btn btn-eye" onclick="togglePass('password-confirm', this)" title="Mostrar/ocultar">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>

            {{-- Rol claro (con etiqueta + placeholder + ayuda) --}}
            <div class="form-group mb-3">
              <label for="role" class="small text-muted mb-1">Rol en UniRide</label>
              <select id="role" name="role"
                      class="form-control form-control-user @error('role') is-invalid @enderror" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>— ¿Qué quieres ser en UniRide? —</option>
                <option value="Pasajero"  {{ old('role')=='Pasajero'  ? 'selected':'' }}>Pasajero</option>
                <option value="Conductor" {{ old('role')=='Conductor' ? 'selected':'' }}>Conductor</option>
              </select>
              <div class="helper">Elige si usarás la app como <strong>Pasajero</strong> o <strong>Conductor</strong>.</div>
              @error('role') <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-user btn-block">Registrarme</button>
          </form>

          <hr>
          <div class="text-center">
            <a class="small" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
          </div>
          <div class="text-center">
            <a class="small" href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <script>
    function togglePass(id, btn){
      const input = document.getElementById(id);
      const icon = btn.querySelector('i');
      input.type = input.type === 'text' ? 'password' : 'text';
      icon.classList.toggle('fa-eye'); icon.classList.toggle('fa-eye-slash');
    }
  </script>
</body>
</html>
