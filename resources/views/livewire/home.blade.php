<div class="min-h-screen bg-neutral-900 text-white font-sans selection:bg-indigo-500/30 selection:text-indigo-200">
    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-neutral-900/80 backdrop-blur-md border-b border-white/5 shadow-2xl">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-6">
                <!-- Logo -->
                <div class="flex items-center gap-3 shrink-0 group">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('favicon.png') }}" alt="">
                    </div>
                    <span
                        class="font-black text-2xl tracking-tighter text-transparent bg-clip-text bg-linear-to-r from-white to-gray-400 hidden sm:block">ARCHTOPUP</span>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl group relative hidden md:block">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-indigo-400 transition-colors duration-300">
                        <flux:icon.magnifying-glass class="w-5 h-5 text-neutral-500" />
                    </div>
                    <input type="text" autocomplete="off" wire:model.debounce.500ms="search" placeholder="Cari game favoritmu..."
                        class="block w-full pl-11 pr-4 py-2.5 bg-neutral-800/50 border border-white/10 rounded-2xl text-sm placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-neutral-800 transition-all duration-300">
                </div>
              

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <button class="md:hidden p-2 text-neutral-400 hover:text-white transition-colors">
                        <flux:icon.magnifying-glass class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>
    </header>

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
                            <span
                                class="text-transparent bg-clip-text bg-linear-to-r from-indigo-400 to-blue-400">Favoritmu</span>
                        </h1>
                        <p class="text-neutral-400 text-sm md:text-base font-medium max-w-xs">
                            Proses instan, harga kompetitif, dan aman 100% untuk semua platform gaming.
                        </p>
                        <div class="pt-2">
                            <flux:button variant="primary"
                                class="bg-white text-neutral-950 hover:bg-neutral-200 border-none font-bold rounded-xl px-8">
                                Cek Sekarang
                            </flux:button>
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
                <a href="#"
                    class="text-sm font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-1 transition-colors group">
                    Lihat Semua
                    <flux:icon.arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                </a>
            </div>
              <b>{{ $search }}</b>

            <div
                class="grid grid-cols-2 place-items-center sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">

                @foreach ($games as $game)
                    <div class="group cursor-pointer">
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
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-12 mt-12 bg-neutral-950/50">
        <div class="container mx-auto px-4 text-center">
            <p class="text-neutral-500 text-sm">© 2024 ArchTopup. All rights reserved.</p>
            <div class="flex justify-center gap-4 mt-4 text-neutral-500">
                <a href="#" class="hover:text-white transition-colors">Term of Service</a>
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
            </div>
        </div>
    </footer>
</div>