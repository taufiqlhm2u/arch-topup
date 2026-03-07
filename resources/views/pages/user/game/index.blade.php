<x-app-layout>
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl md:text-4xl font-black flex items-center gap-3">
                    Game
                </h2>
            </div>

            <div
                class="grid grid-cols-2 place-items-center sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6 mb-35">

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