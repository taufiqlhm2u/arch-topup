<x-app-layout>
<main class="relative z-10 min-h-screen">

    <div class="pointer-events-none fixed top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-indigo-500/10 blur-3xl"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 max-w-6xl">

        {{-- Game Header --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 rounded-2xl overflow-hidden border border-white/10 shadow-lg shadow-indigo-500/20 shrink-0">
                <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-2xl font-black tracking-tight">{{ $game->name }}</h1>
                    @if ($game->badge)
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-400 uppercase tracking-wider">
                            {{ $game->badge }}
                        </span>
                    @endif
                </div>
                <p class="text-sm text-neutral-500 mt-0.5">{{ $game->publisher }} · Indonesia Region</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- LEFT: Panduan --}}
            <div class="lg:col-span-1">
                <div class="rounded-2xl bg-white/3 border border-white/[.07] p-5 backdrop-blur-sm">
                    <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 mb-4">
                        Cara Top Up <span class="text-white">{{ $game->name }}</span>
                    </p>

                    <ol class="space-y-3 text-sm text-neutral-400">
                        @php
                            $steps = array_values(array_filter([
                                'Masukkan <span class="text-white font-semibold">ID akun</span> kamu',
                                $game->server_id ? 'Masukkan <span class="text-white font-semibold">Server ID</span> kamu' : null,
                                'Pilih <em class="not-italic text-white font-semibold">Item</em> yang diinginkan',
                                'Masukkan <span class="text-white font-semibold">nomor WhatsApp</span> aktif',
                                'Klik <span class="text-white font-semibold">Pesan Sekarang</span> dan ikuti instruksi pembayaran',
                                '<em class="not-italic text-white font-semibold">Item</em> akan masuk otomatis ke akun kamu',
                            ]));
                        @endphp
                        @foreach ($steps as $i => $step)
                            <li class="flex gap-3">
                                <span class="mt-0.5 shrink-0 w-5 h-5 rounded-full bg-indigo-500/20 border border-indigo-500/40 text-indigo-400 text-[11px] font-bold flex items-center justify-center">
                                    {{ $i + 1 }}
                                </span>
                                <span>{!! $step !!}</span>
                            </li>
                        @endforeach
                    </ol>

                    <div class="mt-5 rounded-xl bg-indigo-500/[.07] border border-indigo-500/20 p-3 text-xs text-neutral-400">
                        <p class="font-bold text-white mb-0.5">Catatan</p>
                        Hanya bisa sukses jika <strong class="text-white">Region akun Indonesia</strong>.
                    </div>

                    <div class="mt-3 rounded-xl bg-amber-500/5 border border-amber-500/20 p-3 text-xs text-amber-400/80 italic">
                        ⚠️ Jika terdapat kendala, silahkan hubungi Admin di Whatsapp resmi kami
                        <a href="#" class="underline text-amber-400 hover:text-amber-300 transition-colors ml-1 not-italic font-semibold">DISINI</a>.
                    </div>
                </div>
            </div>

            {{-- RIGHT: Livewire --}}
            <div class="lg:col-span-2">
                @livewire('user.game-show', ['game' => $game])
            </div>

        </div>
    </div>
</main>
</x-app-layout>