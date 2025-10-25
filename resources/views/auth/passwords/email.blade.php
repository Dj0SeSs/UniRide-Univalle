@extends('layouts.app')
@section('navbar_title', 'Recuperación de contraseña')

@section('content')
<div class="container">

  {{-- Colores + estilos suaves (Bootstrap-friendly) --}}
  <style>
    :root{ --uv-red:#8f1d22; --uv-red-dark:#6b1216; }
    .uv-card{
      max-width: 580px;
      margin-inline: auto;
      border-radius: 1.25rem !important;
      border: 1px solid #e5e7eb !important;
      box-shadow: 0 10px 30px rgba(0,0,0,.06) !important;
    }
    .btn-uv{ background-color:var(--uv-red) !important; border-color:var(--uv-red) !important; }
    .btn-uv:hover,.btn-uv:focus{ background-color:var(--uv-red-dark) !important; border-color:var(--uv-red-dark) !important; }
    .form-control:focus{ border-color:var(--uv-red-dark); box-shadow:0 0 0 .2rem rgba(107,18,22,.15); }
    .uv-title{ color:#111827; font-weight:700; letter-spacing:.2px; }
    .uv-sub{ color:#6b7280; }
    .uv-logo{ height:40px; width:auto; }
  </style>

  <div class="my-5">
    <div class="card uv-card">
      <div class="card-body p-4 p-sm-5">

        {{-- LOGO + encabezado --}}
        <div class="text-center mb-3">
          <img src="{{ asset('img/logo_register.svg') }}" alt="UniRide" class="uv-logo mb-2">
          <h1 class="h4 uv-title mb-1">Recuperar contraseña</h1>
          <p class="uv-sub mb-0">Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>
        </div>

        {{-- Mensaje de estado --}}
        @if (session('status'))
          <div class="alert alert-success mb-3">
            {{ session('status') }}
          </div>
        @endif

        {{-- Formulario: enviar enlace --}}
        <form method="POST" action="{{ route('password.email') }}" novalidate>
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Correo electrónico</label>
            <input
              id="email"
              type="email"
              name="email"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="tucorreo@ejemplo.com"
              value="{{ old('email') }}"
              required
              autofocus
            >
            @error('email')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-uv w-100 py-2">
            Enviar enlace de restablecimiento
          </button>
        </form>

        <hr class="my-4">
        <div class="text-center">
          <a class="text-decoration-underline" href="{{ route('login') }}">Volver a iniciar sesión</a>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
