<x-app-layout>
    @if (!$order)
        <main class="relative z-10 min-h-screen">

            {{-- Background blob --}}
            <div
                class="pointer-events-none fixed top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-indigo-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none fixed bottom-0 right-0 translate-x-1/3 translate-y-1/3 w-[400px] h-[400px] rounded-full bg-emerald-500/8 blur-3xl">
            </div>

            <div class="container h-100 mx-auto px-4 sm:px-6 lg:px-8 py-10 max-w-2xl flex flex-col items-center justify-center">
                <p class="text-4xl text-gray-500">Data tidak ditemukan</p>
                <a href="/" class="text-blue-400 underline">Beranda</a>
            </div>
        </main>
    @else
        <main class="relative z-10 min-h-screen">

            {{-- Background blob --}}
            <div
                class="pointer-events-none fixed top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-indigo-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none fixed bottom-0 right-0 translate-x-1/3 translate-y-1/3 w-[400px] h-[400px] rounded-full bg-emerald-500/8 blur-3xl">
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 max-w-2xl">

                {{-- Status Badge --}}
                @php
                    $status = $order->status;
                    $isPaid = in_array($status, ['successful', 'paid', 'success', 'completed']);
                    $isFailed = in_array($status, ['failed', 'expired']);
                @endphp

                <div class="flex flex-col items-center text-center mb-8">
                    {{-- Icon --}}
                    <div @class([
                        'w-20 h-20 rounded-full flex items-center justify-center mb-5 ring-8 shadow-2xl',
                        'bg-emerald-500/20 ring-emerald-500/10 shadow-emerald-500/20' => $isPaid,
                        'bg-red-500/20 ring-red-500/10 shadow-red-500/20' => $isFailed,
                        'bg-amber-500/20 ring-amber-500/10 shadow-amber-500/20' => !$isPaid && !$isFailed,
                    ])>
         @if ($isPaid)
            <flux:icon.check-circle @class(['w-10 h-10 text-emerald-400']) />
        @elseif ($isFailed)
                            <flux:icon.x-circle @class(['w-10 h-10 text-red-400']) />
                        @else
                            <flux:icon.clock @class(['w-10 h-10 text-amber-400']) />
                        @endif
                    </div>

                    <h1 class="text-2xl font-black tracking-tight mb-1">
                        @if ($isPaid)
                            Pembayaran Berhasil!
                        @elseif ($isFailed)
                            Pembayaran Gagal
                        @else
                            Menunggu Proses
                        @endif
                    </h1>
                    <p class="text-sm text-neutral-500">
                        @if ($isPaid)
                            Top up kamu sedang diproses. Item akan segera masuk ke akunmu.
                        @elseif ($isFailed)
                            Transaksi ini sudah kedaluwarsa atau gagal. Silahkan buat pesanan baru.
                        @else
                            Pesanan kamu sedang di proses
                        @endif
                    </p>
                </div>

                {{-- Receipt Card --}}
                <div class="rounded-2xl bg-white/3 border border-white/[.07] backdrop-blur-sm overflow-hidden">

                    {{-- Game Header --}}
                    <div class="flex items-center gap-4 px-6 py-5 border-b border-white/7 bg-white/2">
                        @if ($order->package->game->image)
                            <div
                                class="w-14 h-14 rounded-xl overflow-hidden border border-white/10 shadow-lg shadow-indigo-500/20 shrink-0">
                                <img src="{{ asset('storage/' . $order->package->game->image) }}"
                                    alt="{{ $order->package->game->name }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div>
                            <p class="text-xs font-semibold text-neutral-500 uppercase tracking-widest mb-0.5">Bukti
                                Pembelian</p>
                            <h2 class="font-black text-lg leading-tight">{{ $order->package->game->name }}</h2>
                            @if ($order->package->game->publisher ?? null)
                                <p class="text-xs text-neutral-500">{{ $order->package->game->publisher }}</p>
                            @endif
                        </div>
                        <div class="ml-auto shrink-0">
                            @php
                                $badgeMap = [
                                    'successful' => ['label' => 'SUKSES', 'class' => 'bg-emerald-500/20 border-emerald-500/30 text-emerald-400'],
                                    'paid' => ['label' => 'SUKSES', 'class' => 'bg-emerald-500/20 border-emerald-500/30 text-emerald-400'],
                                    'success' => ['label' => 'SUKSES', 'class' => 'bg-emerald-500/20 border-emerald-500/30 text-emerald-400'],
                                    'completed' => ['label' => 'SUKSES', 'class' => 'bg-emerald-500/20 border-emerald-500/30 text-emerald-400'],
                                    'failed' => ['label' => 'GAGAL', 'class' => 'bg-red-500/20 border-red-500/30 text-red-400'],
                                    'expired' => ['label' => 'EXPIRED', 'class' => 'bg-red-500/20 border-red-500/30 text-red-400'],
                                    'pending' => ['label' => 'PENDING', 'class' => 'bg-amber-500/20 border-amber-500/30 text-amber-400'],
                                ];
                                $badge = $badgeMap[$status] ?? ['label' => strtoupper($status), 'class' => 'bg-white/10 border-white/20 text-neutral-400'];
                            @endphp
                            <span
                                class="text-[10px] font-bold px-2.5 py-1 rounded-full border {{ $badge['class'] }} uppercase tracking-wider">
                                {{ $badge['label'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail Rows --}}
                    <div class="px-6 py-5 space-y-0 divide-y divide-white/5">

                    <div class="flex items-center justify-between py-3.5">
    <span class="text-sm text-neutral-500">No. Kwitansi</span>
    <div class="flex items-center gap-2">
        <span class="text-sm font-mono font-semibold text-white tracking-wide">
            {{ $order->no_kw }}
        </span>
        <button 
            onclick="copyToClipboard('{{ $order->no_kw }}')" 
            class="text-neutral-400 hover:text-white transition p-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
            title="Salin nomor kwitansi"
        >
            <!-- Ikon salin (Heroicons) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
        </button>
    </div>
</div>

<script>
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            // Opsional: Tampilkan notifikasi sederhana
            alert('Nomor kwitansi berhasil disalin!');
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
            alert('Gagal menyalin, coba manual.');
        });
    } else {
        // Fallback untuk browser lama
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            alert('Nomor kwitansi berhasil disalin!');
        } catch (err) {
            alert('Gagal menyalin, coba manual.');
        }
        document.body.removeChild(textarea);
    }
}
</script>

                        {{-- Tanggal --}}
                        <div class="flex items-center justify-between py-3.5">
                            <span class="text-sm text-neutral-500">Tanggal</span>
                            <span class="text-sm font-semibold text-white">
                                {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
                                WIB
                            </span>
                        </div>

                        {{-- ID Akun --}}
                        <div class="flex items-center justify-between py-3.5">
                            <span class="text-sm text-neutral-500">ID Akun</span>
                            <span class="text-sm font-mono font-semibold text-white">
                                {{ $order->player_id }}
                                @if ($order->server_id)
                                    <span class="text-neutral-400 font-sans font-normal">({{ $order->server_id }})</span>
                                @endif
                            </span>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-center justify-between py-3.5">
                            <span class="text-sm text-neutral-500">Email</span>
                            <span class="text-sm font-semibold text-white">{{ $order->email }}</span>
                        </div>

                        {{-- Item --}}
                        <div class="flex items-center justify-between py-3.5">
                            <span class="text-sm text-neutral-500">Item</span>
                            <span class="text-sm font-semibold text-white">
                                {{ number_format($order->package->quantity, 0, ',', '.') }} {{ $order->package->type }}
                            </span>
                        </div>

                        {{-- Harga Satuan --}}
                        <div class="flex items-center justify-between py-3.5">
                            <span class="text-sm text-neutral-500">Harga Satuan</span>
                            <span class="text-sm font-semibold text-white">
                                Rp {{ number_format($order->package->price, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Jumlah --}}
                        <div class="flex items-center justify-between py-3.5">
                            <span class="text-sm text-neutral-500">Jumlah</span>
                            <span class="text-sm font-semibold text-white">{{ $order->qty }}x</span>
                        </div>

                        {{-- Divider --}}
                        <div class="border-0! pt-2 pb-0"></div>

                        {{-- Total --}}
                        <div class="flex items-center justify-between py-4 border-t! border-white/10!">
                            <span class="text-base font-bold text-white">Total Pembayaran</span>
                            <span class="text-base font-black text-indigo-400">
                                Rp {{ number_format($order->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Dotted divider (like a receipt tear) --}}
                    <div class="relative px-6">
                        <div class="absolute -left-3 w-6 h-6 rounded-full bg-black/60 border border-white/5"></div>
                        <div class="absolute -right-3 w-6 h-6 rounded-full bg-black/60 border border-white/5"></div>
                        <div class="border-t border-dashed border-white/8 mx-2"></div>
                    </div>

                    {{-- Footer: ID Eksternal / QR hint --}}
                    <div class="px-6 py-5 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[10px] text-neutral-600 font-semibold uppercase tracking-widest mb-1">ID
                                Pembayaran</p>
                            <p class="text-xs font-mono text-neutral-400">
                                {{ $order->external_id ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-neutral-600 font-semibold uppercase tracking-widest mb-1">Dibuat</p>
                            <p class="text-xs text-neutral-400">
                                {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                            </p>
                        </div>
                    </div>

                </div>

                {{-- CTA Buttons --}}
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('home') }}"
                        class="flex-1 flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-white/7 bg-white/3 hover:bg-white/6 hover:border-white/10 transition-all duration-200 text-sm font-semibold text-neutral-300 hover:text-white">
                        <flux:icon.arrow-left class="w-4 h-4" />
                        Kembali ke Beranda
                    </a>

                  
                </div>

                {{-- Warning for pending --}}
                @if (!$isPaid && !$isFailed)
                    <div
                        class="mt-4 rounded-xl bg-amber-500/5 border border-amber-500/20 p-3 text-xs text-amber-400/80 italic text-center">
                        ⚠️ Jika terdapat kendala, silahkan hubungi Admin melalui WhatsApp resmi kami.
                    </div>
                @endif

            </div>
        </main>
    @endif
</x-app-layout>