@extends('layouts.app')

@section('content')
<div class="container">

  {{-- Colores de marca (sin romper Bootstrap) --}}
  <style>
    :root{
      --uv-red: #8f1d22;      /* base */
      --uv-red-dark: #6b1216; /* hover/focus */
    }
    .card-uv{border-radius:1.25rem!important;border:1px solid #e5e7eb!important;box-shadow:0 10px 25px rgba(0,0,0,.06)!important;overflow:hidden;}
    .btn-uv{background-color:var(--uv-red)!important;border-color:var(--uv-red)!important;}
    .btn-uv:hover,.btn-uv:focus{background-color:var(--uv-red-dark)!important;border-color:var(--uv-red-dark)!important;}
    .uv-title{color:#111827;font-weight:600;}
    .uv-subtitle{color:#6b7280;}
    .uv-label{color:#374151;font-weight:500;}
    .uv-help{color:#6b7280;font-size:.9rem;}
    .bg-reset-side{background:linear-gradient(135deg, rgba(143,29,34,.12), rgba(107,18,22,.08));display:flex;align-items:center;justify-content:center;}
    .bg-reset-side .badge{background:rgba(255,255,255,.7);color:var(--uv-red);border:1px solid rgba(143,29,34,.25);backdrop-filter:blur(4px);}
    .form-control:focus{border-color:var(--uv-red-dark);box-shadow:0 0 0 .2rem rgba(107,18,22,.15);}
  </style>

  <div class="my-5">
    <div class="card card-uv border-0">
      <div class="row g-0">
        {{-- Lado ilustración (desktop) --}}
        <div class="col-lg-5 d-none d-lg-flex bg-reset-side p-4">
          <div class="text-center">
            <div class="mb-3">
              <span class="badge rounded-pill px-3 py-2">🔒 Seguridad</span>
            </div>
            <h5 class="fw-semibold mb-1" style="color:#1f2937;">Crea tu nueva contraseña</h5>
            <p class="uv-help mb-0">Usa una clave segura y no la compartas.</p>
          </div>
        </div>

        {{-- Lado formulario --}}
        <div class="col-lg-7">
          <div class="p-4 p-sm-5">
            <div class="text-center mb-3">
              <div class="d-inline-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill" style="background:rgba(143,29,34,.1); color:var(--uv-red);">
                  UniRide
                </span>
              </div>
              <h1 class="h4 uv-title mb-1">Reset Your Password</h1>
              <p class="uv-subtitle mb-0">Ingresa tus datos para establecer una nueva contraseña.</p>
            </div>

            {{-- Formulario: actualiza contraseña --}}
            <form method="POST" action="{{ route('password.update') }}">
              @csrf

              <input type="hidden" name="token" value="{{ $token }}">

              {{-- Email --}}
              <div class="mb-3">
                <label for="email" class="uv-label mb-1">Email Address</label>
                <input
                  id="email"
                  type="email"
                  name="email"
                  class="form-control @error('email') is-invalid @enderror"
                  placeholder="you@example.com"
                  value="{{ $email ?? old('email') }}"
                  required
                  autofocus
                >
                @error('email')
                  <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>

              <div class="row">
                {{-- Nueva contraseña --}}
                <div class="col-sm-6 mb-3">
                  <label for="password" class="uv-label mb-1">New Password</label>
                  <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    required
                  >
                  @error('password')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                  <div class="form-text uv-help">Mínimo 8 caracteres, combina letras y números.</div>
                </div>

                {{-- Confirmación --}}
                <div class="col-sm-6 mb-3">
                  <label for="password_confirmation" class="uv-label mb-1">Confirm Password</label>
                  <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="••••••••"
                    required
                  >
                </div>
              </div>

              <button type="submit" class="btn btn-uv w-100 py-2 mt-1">
                Reset Password
              </button>
            </form>

            <hr class="my-4">
            <div class="text-center">
              <a class="small text-decoration-underline" href="{{ route('login') }}">Back to Login</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
<script>
  (function () {
    const pwd = document.getElementById('password');
    const rep = document.getElementById('password_confirmation');
    function toggle(input){ input.type = input.type === 'password' ? 'text' : 'password'; }
    // Botoncitos simples (no invasivos):
    ['password','password_confirmation'].forEach(id => {
      const el = document.getElementById(id);
      if(!el) return;
      const wrap = el.parentElement;
      wrap.style.position='relative';
      const btn=document.createElement('button');
      btn.type='button';
      btn.textContent='👁';
      btn.title='Mostrar/ocultar';
      btn.className='btn btn-sm btn-light';
      btn.style.position='absolute';
      btn.style.right='0.5rem';
      btn.style.top='50%';
      btn.style.transform='translateY(-50%)';
      btn.addEventListener('click', ()=> toggle(el));
      wrap.appendChild(btn);
    });
  })();
</script>
