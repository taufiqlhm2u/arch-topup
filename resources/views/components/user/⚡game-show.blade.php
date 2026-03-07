<?php

use App\Models\Game;
use App\Models\Package;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    public Game $game;

    public string $accountId  = '';
    public string $serverId   = '';
    public string $whatsapp   = '';
    public string $tab        = 'all';
    public ?int   $selectedId = null;
    public int    $quantity   = 1;

    #[Computed]
    public function packages()
    {
        return Package::where('game_id', $this->game->id)->get();
    }

    #[Computed]
    public function types()
    {
        return $this->packages->pluck('type')->unique()->values();
    }

    #[Computed]
    public function filtered()
    {
        return $this->tab === 'all'
            ? $this->packages
            : $this->packages->where('type', $this->tab)->values();
    }

    #[Computed]
    public function selected(): ?Package
    {
        return $this->selectedId ? $this->packages->find($this->selectedId) : null;
    }

    #[Computed]
    public function total(): float
    {
        return $this->selected ? $this->selected->price * $this->quantity : 0;
    }

    #[Computed]
    public function isReady(): bool
    {
        return $this->accountId !== ''
            && $this->whatsapp !== ''
            && $this->selectedId !== null
            && $this->quantity >= 1
            && (! $this->game->server_id || $this->serverId !== '');
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->selectedId = null;
    }

    public function pick(int $id): void
    {
        $this->selectedId = $this->selectedId === $id ? null : $id;
    }

    public function increment(): void
    {
        $this->quantity++;
    }

    public function decrement(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function placeOrder(): void
    {
        $this->validate([
            'accountId'  => ['required', 'string'],
            'serverId'   => [$this->game->server_id ? 'required' : 'nullable', 'string'],
            'whatsapp'   => ['required', 'string'],
            'selectedId' => ['required', 'exists:packages,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $serverId = $this->game->server_id ? '(' . $this->serverId . ')' : null;
        
        $payload = [
            'game_id'    => $this->game->id,
            'game_name'  => $this->game->name,
            'player_id'  => $this->accountId . ' ' . $serverId,
            'package_id' => $this->selectedId,
            'package'    => $this->selected->quantity . ' ' . $this->selected->type,
            'price'      => $this->selected->price,
            'qty'        => $this->quantity,
            'total'      => $this->total,
            'whatsapp'   => '+62' . $this->whatsapp,
        ];

        dd($payload);

        // TODO: hit payment API
        // $response = PaymentService::create($payload);

        session()->flash('success', 'Pesanan berhasil! Silakan selesaikan pembayaran.');
        $this->reset(['accountId', 'serverId', 'whatsapp', 'selectedId']);
        $this->quantity = 1;
    }
};
?>

<form wire:submit="placeOrder" class="space-y-5">

    {{-- Flash --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 px-4 py-3 text-sm text-emerald-400">
            <flux:icon.check-circle class="w-4 h-4 shrink-0" />
            {{ session('success') }}
        </div>
    @endif

    {{-- ── STEP 1: Data Akun ── --}}
    <div class="rounded-2xl bg-white/3 border border-white/[.07] p-6 backdrop-blur-sm">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-sm font-bold shadow-lg shadow-indigo-500/40 shrink-0">1</div>
            <h2 class="font-bold text-lg">Masukkan Data Akun Anda</h2>
        </div>

        <div class="space-y-4">
            <div>
                <flux:label class="text-xs font-semibold uppercase tracking-widest text-neutral-400 mb-2 block">ID Akun</flux:label>
                <flux:input wire:model.live="accountId" placeholder="Contoh: 19123456" />
                @error('accountId') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
            </div>

            @if ($game->server_id)
                <div>
                    <flux:label class="text-xs font-semibold uppercase tracking-widest text-neutral-400 mb-2 block">Server ID</flux:label>
                    <flux:input wire:model.live="serverId" placeholder="Contoh: 5504" />
                    @error('serverId') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
            @endif
        </div>
    </div>

    {{-- ── STEP 2: Pilih Nominal ── --}}
    <div class="rounded-2xl bg-white/3 border border-white/[.07] p-6 backdrop-blur-sm">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-sm font-bold shadow-lg shadow-indigo-500/40 shrink-0">2</div>
            <h2 class="font-bold text-lg">Pilih Nominal yang Ingin Anda Beli</h2>
        </div>

        {{-- Tabs --}}
        @if ($this->types->count() > 1)
            <div class="flex gap-2 mb-6 flex-wrap">
                <button type="button" wire:click="setTab('all')"
                    @class([
                        'px-4 py-1.5 rounded-full text-sm font-semibold border transition-all duration-200 cursor-pointer',
                        'bg-indigo-500 border-indigo-500 text-white shadow-lg shadow-indigo-500/30' => $tab === 'all',
                        'bg-transparent border-white/10 text-neutral-500 hover:border-indigo-500/40 hover:text-neutral-300' => $tab !== 'all',
                    ])>Semua</button>

                @foreach ($this->types as $type)
                    <button type="button" wire:click="setTab('{{ $type }}')"
                        @class([
                            'px-4 py-1.5 rounded-full text-sm font-semibold border transition-all duration-200 cursor-pointer',
                            'bg-indigo-500 border-indigo-500 text-white shadow-lg shadow-indigo-500/30' => $tab === $type,
                            'bg-transparent border-white/10 text-neutral-500 hover:border-indigo-500/40 hover:text-neutral-300' => $tab !== $type,
                        ])>{{ $type }}</button>
                @endforeach
            </div>
        @endif

        {{-- Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @foreach ($this->filtered as $pkg)
                <button type="button" wire:click="pick({{ $pkg->id }})"
                    @class([
                        'group relative flex items-center gap-3 p-4 rounded-xl border transition-all duration-200 text-left cursor-pointer w-full',
                        'border-indigo-500 bg-indigo-500/10 shadow-lg shadow-indigo-500/20 hover:bg-indigo-500/15 hover:shadow-indigo-500/30' => $selectedId === $pkg->id,
                        'border-white/[.07] bg-white/[.04] hover:border-indigo-500/50 hover:bg-indigo-500/[.06] hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-500/10' => $selectedId !== $pkg->id,
                    ])>

                    @if ($pkg->image)
                        <img src="{{ asset('storage/' . $pkg->image) }}" alt="{{ $pkg->quantity }} {{ $pkg->type }}"
                             class="w-9 h-9 object-contain shrink-0 drop-shadow-[0_2px_8px_rgba(99,102,241,0.5)] group-hover:scale-110 transition-transform duration-200">
                    @else
                        <svg class="w-9 h-9 shrink-0 drop-shadow-[0_2px_8px_rgba(99,102,241,0.5)] group-hover:scale-110 transition-transform duration-200" viewBox="0 0 32 32" fill="none">
                            <polygon points="16,3 28,11 24,27 8,27 4,11" fill="url(#g{{ $pkg->id }})" stroke="rgba(99,102,241,0.4)" stroke-width="1"/>
                            <polygon points="16,3 28,11 16,14" fill="rgba(255,255,255,0.25)"/>
                            <defs>
                                <linearGradient id="g{{ $pkg->id }}" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#818cf8"/><stop offset="100%" stop-color="#4f46e5"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    @endif

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate leading-tight group-hover:text-indigo-100 transition-colors duration-200">
                            {{ number_format($pkg->quantity, 0, ',', '.') }}
                            <span class="font-normal text-neutral-400 text-xs">{{ $pkg->type }}</span>
                        </p>
                        <p class="text-xs font-semibold text-indigo-400 mt-0.5">
                            Rp {{ number_format($pkg->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div @class([
                        'w-4 h-4 rounded-full border-2 shrink-0 flex items-center justify-center transition-all duration-200',
                        'border-indigo-500 bg-indigo-500' => $selectedId === $pkg->id,
                        'border-white/20 group-hover:border-indigo-500/50' => $selectedId !== $pkg->id,
                    ])>
                        @if ($selectedId === $pkg->id)
                            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>

        @error('selectedId') <p class="text-xs text-red-400 mt-3">{{ $message }}</p> @enderror
    </div>

    {{-- ── STEP 3: Konfirmasi ── --}}
    <div class="rounded-2xl bg-white/3 border border-white/[.07] p-6 backdrop-blur-sm">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-sm font-bold shadow-lg shadow-indigo-500/40 shrink-0">3</div>
            <h2 class="font-bold text-lg">Konfirmasi Pesanan</h2>
        </div>

        <div class="space-y-4 mb-5">

            {{-- WhatsApp --}}
            <div>
                <flux:label class="text-xs font-semibold uppercase tracking-widest text-neutral-400 mb-2 block">Nomor WhatsApp Aktif</flux:label>
                <div class="flex gap-2">
                    <div class="flex items-center px-3 rounded-xl bg-white/5 border border-white/8 text-sm text-neutral-400 gap-2 shrink-0 select-none">
                        🇮🇩 <span>+62</span>
                    </div>
                    <flux:input wire:model.live="whatsapp" type="tel" placeholder="812 3456 7890" class="flex-1" />
                </div>
                @error('whatsapp') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                <p class="text-xs text-neutral-600 mt-2">Notifikasi pesanan akan dikirim ke nomor ini</p>
            </div>

            {{-- Quantity --}}
            <div>
                <flux:label class="text-xs font-semibold uppercase tracking-widest text-neutral-400 mb-2 block">Jumlah</flux:label>
                <div class="flex items-center gap-3">
                    <button type="button" wire:click="decrement"
                        @class([
                            'w-9 h-9 rounded-xl border flex items-center justify-center transition-all duration-200 cursor-pointer shrink-0',
                            'bg-white/[.05] border-white/[.08] text-neutral-600 cursor-not-allowed' => $quantity <= 1,
                            'bg-white/[.05] border-white/[.08] text-neutral-400 hover:text-white hover:border-indigo-500/50 hover:bg-indigo-500/10 hover:shadow-md hover:shadow-indigo-500/10 active:scale-95' => $quantity > 1,
                        ])>
                        <flux:icon.minus class="w-4 h-4" />
                    </button>
                    <flux:input
                        wire:model.live="quantity"
                        type="number"
                        min="1"
                        class="text-center w-24 [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                    />
                    <button type="button" wire:click="increment"
                        class="w-9 h-9 rounded-xl bg-white/5 border border-white/8 flex items-center justify-center text-neutral-400 hover:text-white hover:border-indigo-500/50 hover:bg-indigo-500/10 hover:shadow-md hover:shadow-indigo-500/10 active:scale-95 transition-all duration-200 cursor-pointer shrink-0">
                        <flux:icon.plus class="w-4 h-4" />
                    </button>
                </div>
                @error('quantity') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- Summary --}}
        <div class="rounded-xl bg-neutral-800/50 border border-white/5 p-4 mb-5 text-sm space-y-2.5">
            <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 mb-3">Ringkasan Pesanan</p>

            <div class="flex justify-between">
                <span class="text-neutral-400">Produk</span>
                <span class="font-semibold text-white">{{ $game->name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-neutral-400">ID Akun</span>
                <span class="font-semibold text-white font-mono">
                    @if ($game->server_id)
                        {{ $accountId ?: '—' }}
                        @if ($accountId && $serverId)
                            <span class="text-neutral-400 font-sans font-normal">({{ $serverId }})</span>
                        @elseif ($serverId)
                            <span class="text-neutral-500">({{ $serverId }})</span>
                        @endif
                    @else
                        {{ $accountId ?: '—' }}
                    @endif
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-neutral-400">Item</span>
                <span class="font-semibold text-white">
                    {{ $this->selected ? number_format($this->selected->quantity, 0, ',', '.') . ' ' . $this->selected->type : '—' }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-neutral-400">Harga Satuan</span>
                <span class="font-semibold text-white">
                    {{ $this->selected ? 'Rp ' . number_format($this->selected->price, 0, ',', '.') : '—' }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-neutral-400">Jumlah</span>
                <span class="font-semibold text-white">{{ $quantity }}x</span>
            </div>

            <div class="h-px bg-white/5"></div>

            <div class="flex justify-between items-center">
                <span class="font-semibold text-white">Total</span>
                <span class="font-black text-indigo-400 text-base">
                    {{ $this->total > 0 ? 'Rp ' . number_format($this->total, 0, ',', '.') : '—' }}
                </span>
            </div>
        </div>

        {{-- Submit --}}
        <flux:button
            type="submit"
            wire:loading.attr="disabled"
            variant="primary"
            :disabled="! $this->isReady"
            class="w-full">
            <flux:icon.bolt class="w-4 h-4" wire:loading.remove wire:target="placeOrder" />
            <flux:icon.arrow-path class="w-4 h-4 animate-spin" wire:loading wire:target="placeOrder" />
            <span wire:loading.remove wire:target="placeOrder">Pesan Sekarang</span>
            <span wire:loading wire:target="placeOrder">Memproses...</span>
        </flux:button>

        <p class="text-center text-xs text-neutral-600 mt-3">
            Dengan menekan tombol ini, kamu menyetujui
            <a href="#" class="text-neutral-500 hover:text-white transition-colors underline">syarat & ketentuan</a>
            yang berlaku.
        </p>
    </div>

</form>