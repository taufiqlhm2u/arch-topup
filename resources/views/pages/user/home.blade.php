<x-app-layout>

  <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Hero Banner -->
    <section class="relative group">
      <div class="relative h-64 md:h-80 w-full overflow-hidden rounded-3xl shadow-2xl">
        <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&q=80&w=1200"
          alt="Hero Banner Promosi"
          class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700 ease-out">
        <!-- Gradient Overlays -->
        <div class="absolute inset-0 bg-linear-to-t from-neutral-950 via-neutral-900/40 to-transparent"></div>
        <div class="absolute inset-0 bg-linear-to-r from-neutral-950/80 via-transparent to-transparent"></div>

        <!-- Hero Content -->
        <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-12">
          <div class="max-w-md space-y-4">
            <span
              class="inline-block px-3 py-1 bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-[10px] font-bold tracking-widest uppercase rounded-lg">PROMO
              TERBATAS</span>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">
              Top Up Game <br />
              <span class="text-transparent bg-clip-text bg-linear-to-r from-indigo-400 to-blue-400">Favoritmu</span>
            </h1>
            <p class="text-neutral-400 text-sm md:text-base font-medium max-w-xs">
              Proses instan, harga kompetitif, dan aman 100% untuk semua platform gaming.
            </p>
            <div class="pt-2">
              <a href="{{ route('game.index') }}">
                <flux:button variant="primary"
                  class="bg-white text-neutral-950 hover:bg-neutral-200 border-none font-bold rounded-xl px-8">
                  Cek Sekarang
                </flux:button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Game Grid Section -->
    <section class="space-y-6">
      <div class="flex items-center justify-between">
        <h2 class="text-xl md:text-2xl font-black flex items-center gap-3">
          <span class="w-1.5 h-8 bg-indigo-600 rounded-full"></span>
          Game Populer
        </h2>
        <a href="{{ route('game.index') }}"
          class="text-sm font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-1 transition-colors group">
          Lihat Semua
          <flux:icon.arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
        </a>
      </div>

      <div
        class="grid grid-cols-2 place-items-center sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">

        @foreach ($games as $game)
          <div class="group cursor-pointer">
            <a href="{{ route('game.show', $game->id) }}">
              <div
                class="relative aspect-3/4 rounded-2xl overflow-hidden bg-neutral-800 border border-white/5 group-hover:border-indigo-500/50 group-hover:shadow-[0_0_20px_rgba(99,102,241,0.15)] transition-all duration-300 group-hover:-translate-y-2">
                <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}"
                  class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                <div
                  class="absolute inset-0 bg-linear-to-t from-neutral-950 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity">
                </div>

                @if($game->badge)
                  <div
                    class="absolute top-3 left-3 px-2.5 py-1 bg-indigo-600/90 text-[10px] font-black tracking-tight text-white rounded-lg shadow-lg border border-white/10">
                    {{ $game->badge }}
                  </div>
                @endif

                <div class="absolute inset-0 flex flex-col justify-end p-4">
                  <h3
                    class="font-bold text-sm sm:text-base leading-tight group-hover:text-indigo-300 transition-colors truncate">
                    {{ $game->name }}
                  </h3>
                  <p class="text-[10px] sm:text-xs text-neutral-400 mt-1">Top up instan</p>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </section>
  </main>


</x-app-layout>