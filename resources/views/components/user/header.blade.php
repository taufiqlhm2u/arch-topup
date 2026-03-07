<header class="sticky top-0 z-50 bg-neutral-900/80 backdrop-blur-md border-b border-white/5 shadow-2xl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between md:grid md:grid-cols-3">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                <div
                    class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                    <img src="{{ asset('favicon.png') }}" alt="Logo">
                </div>
                <span
                    class="font-black text-2xl tracking-tighter text-transparent bg-clip-text bg-linear-to-r from-white to-gray-400 hidden sm:block">
                    ARCHTOPUP
                </span>
            </a>

            <!-- Search -->
            <div class="max-w-sm hidden md:block md:justify-self-center w-full">
                <form
                    onsubmit="event.preventDefault(); const q = document.querySelector('input[name=q]').value.trim(); if (q) { window.location.href = '/game/search/' + encodeURIComponent(q); } else { window.location.href = '/game/search'; }"
                    class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-indigo-400 transition-colors duration-300">
                        <flux:icon.magnifying-glass class="w-5 h-5 text-neutral-500" />
                    </div>
                    <input type="search" name="q" autocomplete="off" placeholder="Cari game favoritmu..."
                        class="block w-full pl-11 pr-4 py-2.5 bg-neutral-800/50 border border-white/10 rounded-xl text-sm placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-neutral-800 transition-all duration-300">
                </form>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 md:justify-self-end">
                <!-- Tombol Cari Transaksi -->
                <flux:modal.trigger name="search-transaksi-modal">
                    <button class="p-2 text-neutral-400 hover:text-white transition-colors flex" title="Cari Transaksi">
                        <flux:icon.credit-card class="w-6 h-6" />Cek Transaksi
                    </button>
                </flux:modal.trigger>

                <flux:modal.trigger name="search-modal">
                    <button class="md:hidden p-2 text-neutral-400 hover:text-white transition-colors">
                        <flux:icon.magnifying-glass class="w-6 h-6" />
                    </button>
                </flux:modal.trigger>
            </div>

        </div>
    </div>

    <flux:modal name="search-modal" class="md:w-96">
        <div class="p-4">
            <form
                onsubmit="event.preventDefault(); window.location.href = '/game/search/' + document.querySelector('input[name=qr]').value;"
                method="GET" class="relative group">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-indigo-400 transition-colors duration-300">
                    <flux:icon.magnifying-glass class="w-5 h-5 text-neutral-500" />
                </div>
                <input type="search" name="qr" autocomplete="off" placeholder="Cari game favoritmu..."
                    class="block w-full pl-11 pr-4 py-3 bg-neutral-800/50 border border-white/10 rounded-xl text-sm placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-neutral-800 transition-all duration-300 mt-4">
            </form>
        </div>
    </flux:modal>

    <flux:modal name="search-transaksi-modal" class="md:w-96">
    <div class="p-2">
        <!-- Form Pencarian Transaksi -->
        <form onsubmit="event.preventDefault(); // Ganti dengan logika pencarian nanti" method="GET" class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-indigo-400 transition-colors duration-300">
                <flux:icon.magnifying-glass class="w-5 h-5 text-neutral-500" />
            </div>
            <input type="search" name="q_transaction" autocomplete="off" placeholder="Cari transaksi (ID atau nama game)..." class="block w-full pl-11 pr-4 py-3 bg-neutral-800/50 border border-white/10 rounded-xl text-sm placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-neutral-800 transition-all duration-300 mt-4">
        </form>

        <!-- Tempat untuk menampilkan hasil pencarian (opsional, bisa diisi nanti) -->
        <div class="mt-4 text-sm text-neutral-400 text-center">
            Hasil pencarian akan muncul di sini.
        </div>
    </div>
</flux:modal>
</header>