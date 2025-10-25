@extends('layouts.pasajero')

@section('content')
{{-- 🔹 Activa Tailwind (CDN) sin tocar tu build actual --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="mx-auto w-full max-w-3xl px-4 sm:px-6 lg:px-8 mt-6">
  <div class="flex items-center gap-3">
    <span class="text-2xl">⭐</span>
    <h4 class="text-xl font-semibold text-slate-800">Reseñar mis viajes realizados</h4>
  </div>
  <div class="h-px bg-slate-200 my-4"></div>

  {{-- ✅ Mensajes de estado --}}
  @if(session('success'))
    <div class="mb-3 rounded-xl bg-emerald-50 text-emerald-700 px-4 py-3 text-sm shadow-sm border border-emerald-200">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-3 rounded-xl bg-rose-50 text-rose-700 px-4 py-3 text-sm shadow-sm border border-rose-200">
      {{ session('error') }}
    </div>
  @endif

  {{-- ✅ Tarjeta del formulario --}}
  <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-5">
    <form action="{{ route('pasajero.resenas.store') }}" method="POST" class="space-y-5">
      @csrf

      {{-- Seleccionar viaje --}}
      <div>
        <label for="tripSelect" class="block text-sm font-medium text-slate-700 mb-1">
          Selecciona un viaje
        </label>
        <select
          id="tripSelect"
          name="trip_id"
          required
          class="block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3 py-2 bg-white shadow-sm"
        >
          <option value="" selected disabled>-- Selecciona un viaje --</option>
          @foreach($trips as $trip)
            <option
              value="{{ $trip->id }}"
              data-driver="{{ $trip->driver->id }}"
            >
              {{ $trip->origin }} → {{ $trip->destination }} ({{ $trip->departure_time }}) - Conductor: {{ $trip->driver->name }}
            </option>
          @endforeach
        </select>
      </div>

      <input type="hidden" name="driver_id" id="driver_id">

      {{-- ⭐ Calificación --}}
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Tu calificación</label>

        <div
          id="rating"
          role="radiogroup"
          aria-label="Calificación de 1 a 5"
          class="flex items-center gap-3 select-none"
        >
          {{-- Estrellas 1 → 5 (izquierda a derecha) --}}
          @for ($i = 1; $i <= 5; $i++)
            <button
              type="button"
              role="radio"
              aria-checked="false"
              data-value="{{ $i }}"
              class="star group inline-flex size-9 items-center justify-center rounded-md text-slate-300 hover:text-slate-400 transition active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
              title="{{ $i }} {{ $i === 1 ? 'estrella' : 'estrellas' }}"
            >
              {{-- SVG estrella (mejor render que el carácter ★) --}}
              <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-7 h-7">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.967 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.176 0L6.605 16.2c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.97 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.08-3.292z"/>
              </svg>
              <span class="sr-only">{{ $i }} {{ $i === 1 ? 'estrella' : 'estrellas' }}</span>
            </button>
          @endfor

          <div class="min-w-12 text-center">
            <span id="ratingValue" class="text-sm font-semibold text-slate-800">0</span>
            <span class="text-sm text-slate-500">/ 5</span>
          </div>

          <button
            type="button"
            id="ratingReset"
            class="ml-auto text-xs text-slate-500 hover:text-slate-700 underline underline-offset-2"
          >
            Limpiar
          </button>
        </div>

        {{-- Input oculto que viaja al controlador --}}
        <input type="hidden" name="rating" id="rating-input" value="0">
      </div>

      {{-- Comentario --}}
      <div>
        <label for="comment" class="block text-sm font-medium text-slate-700 mb-1">Comentario (opcional)</label>
        <textarea
          id="comment"
          name="comment"
          rows="3"
          placeholder="Escribe tu reseña..."
          class="block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3 py-2 shadow-sm"
        ></textarea>
      </div>

      <button
        type="submit"
        class="w-full mt-2 rounded-2xl px-4 py-2.5 text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm font-medium"
      >
        Publicar reseña
      </button>
    </form>
  </div>

  {{-- ✅ Lista de reseñas --}}
  <div class="mt-6">
    <h5 class="text-base font-semibold text-slate-800">Mis reseñas publicadas</h5>

    @if($reviews->isEmpty())
      <p class="text-slate-500 text-sm mt-2">Aún no has publicado ninguna reseña.</p>
    @else
      <div class="mt-3 grid gap-3">
        @foreach($reviews as $review)
          <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
              <strong class="text-sm text-amber-500">⭐ {{ $review->rating }} {{ $review->rating == 1 ? 'estrella' : 'estrellas' }}</strong>
              <span class="text-xs text-slate-400">Viaje #{{ $review->trip_id }}</span>
            </div>
            <div class="mt-1 text-xs text-slate-600">
              👤 Conductor: <b class="text-slate-800">{{ $review->driver->name }}</b>
            </div>
            @if($review->comment)
              <p class="mt-2 text-slate-700 text-sm">{{ $review->comment }}</p>
            @endif
          </article>
        @endforeach
      </div>
    @endif
  </div>
</div>

{{-- ✅ Script: setear driver_id al elegir viaje --}}
<script>
  document.getElementById('tripSelect').addEventListener('change', function () {
    const driverId = this.options[this.selectedIndex].getAttribute('data-driver');
    document.getElementById('driver_id').value = driverId;
  });
</script>

{{-- ⭐ Script del rating (hover gris y selección pinta 1..N con Tailwind) --}}
<script>
(function () {
  const stars = Array.from(document.querySelectorAll('#rating .star'));
  const input = document.getElementById('rating-input');
  const valueLbl = document.getElementById('ratingValue');
  const resetBtn = document.getElementById('ratingReset');

  let selected = Number(input.value || 0);

  function paint(n, {hover = false} = {}) {
    // Quitar color a todas primero
    stars.forEach(btn => {
      btn.classList.remove('text-amber-400', 'drop-shadow');
      btn.classList.add('text-slate-300');
    });
    // Pintar hasta n
    stars.forEach((btn, idx) => {
      const i = idx + 1;
      btn.setAttribute('aria-checked', i === selected ? 'true' : 'false');
      if (i <= n) {
        btn.classList.remove('text-slate-300', 'hover:text-slate-400');
        btn.classList.add('text-amber-400', 'drop-shadow');
      }
    });
    valueLbl.textContent = n;
    if (!hover) input.value = n;
  }

  stars.forEach((btn, idx) => {
    const val = idx + 1;

    // Hover preview
    btn.addEventListener('mouseenter', () => paint(val, {hover:true}));
    btn.addEventListener('mouseleave', () => paint(selected));

    // Click fija selección
    btn.addEventListener('click', () => { selected = val; paint(selected); });

    // Teclado accesible
    btn.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowRight' || e.key === 'ArrowUp') {
        e.preventDefault();
        selected = Math.min(5, (selected || val) + 1);
        paint(selected);
        stars[selected - 1].focus();
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') {
        e.preventDefault();
        selected = Math.max(1, (selected || val) - 1);
        paint(selected);
        stars[selected - 1].focus();
      } else if (e.key === ' ' || e.key === 'Enter') {
        e.preventDefault();
        paint(selected || val);
      }
    });
  });

  // Limpiar
  resetBtn.addEventListener('click', () => { selected = 0; paint(0); stars[0].focus(); });

  // Inicial
  paint(selected);
})();
</script>
@endsection

