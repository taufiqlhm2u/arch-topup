<?php

use App\Models\Game;
use App\Models\Order;
use Livewire\Component;

new class extends Component {

    use \Livewire\WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';
    public $game_id = '';

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function games()
    {
        return Game::all();
    }

    #[\Livewire\Attributes\Computed]
    public function orders()
    {
        $query = Order::with(['package.game'])
            ->orderByRaw("array_position(ARRAY['pending','success','failed'], status)")
            ->orderBy($this->sortBy, $this->sortDirection);

        if ($this->game_id && $this->game_id != 'semua') {
            $query->whereHas('package.game', function ($query) {
                $query->where('id', $this->game_id);
            });
        }

        $keyword = $this->search;
        if ($keyword) {
            $query->whereHas('package.game', function ($query) use ($keyword) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
            })
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere('no_kw', 'like', '%' . $keyword . '%');
        }

        $packages = $query->paginate(5);
        return $packages;
    }

    public function count()
    {
        return Order::count();
    }
};
?>

<div>

    <div class="mb-4 flex justify-end">
        <flux:button color="orange" variant="primary" href="https://business.flip.id/sandbox/accept-payment-history"
            target="_blank">Ubah transaksi</flux:button>
    </div>

    <div class="flex justify-between mb-4 gap-3">

        <div class="flex-1 max-w-60">
            <flux:input icon="magnifying-glass" wire:model.live="search" autocomplete="off"
                placeholder="Cari game, email, no. kwitansi..." />
        </div>

        <div class="flex items-center shrink-0">
            <flux:icon.loading wire:loading wire:target="sort" class="text-blue-500" />
        </div>

        <div class="shrink-0">
            <flux:select wire:model.live="game_id" placeholder="Pilih Game">
                <flux:select.option value="">Semua</flux:select.option>
                @foreach ($this->games() as $game)
                    <flux:select.option value="{{ $game->id }}">{{ $game->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

    </div>

    <div class="w-full overflow-x-auto rounded-lg">
        <flux:table :paginate="$this->orders">
            <flux:table.columns>
                <flux:table.column class="w-5 whitespace-nowrap">No</flux:table.column>
                <flux:table.column class="whitespace-nowrap">No. Order</flux:table.column>
                <flux:table.column class="whitespace-nowrap">Game</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'package_id'" :direction="$sortDirection"
                    wire:click="sort('package_id')" class="whitespace-nowrap">Paket</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'player_id'" :direction="$sortDirection"
                    wire:click="sort('player_id')" class="whitespace-nowrap">Player ID</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection"
                    wire:click="sort('email')" class="whitespace-nowrap">Email</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'qty'" :direction="$sortDirection"
                    wire:click="sort('qty')" class="whitespace-nowrap text-center">Jumlah</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'amount'" :direction="$sortDirection"
                    wire:click="sort('amount')" class="whitespace-nowrap">Bayar</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'status'" :direction="$sortDirection"
                    wire:click="sort('status')" class="whitespace-nowrap">Status</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->orders as $order)
                    <flux:table.row :key="$order->id">
                        <flux:table.cell>
                            {{ $this->orders->firstItem() + $loop->index }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="block max-w-[180px] truncate font-mono text-blue-400 text-sm"
                                title="{{ $order->no_kw }}">
                                {{ $order->no_kw }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">{{ $order->package->game->name }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $order->package->type }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">
                            {{ $order->server_id ? $order->player_id . ' (' . $order->server_id . ')' : $order->player_id }}
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $order->email }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap text-center">{{ $order->qty }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">
                            {{ 'Rp ' . number_format($order->amount, 0, ',', '.') }}
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">
                            <flux:badge size="sm" :color="$order->status_color" inset="top bottom">
                                {{ $order->status }}
                            </flux:badge>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
                @if($this->orders->count() < 1)
                    <flux:table.row>
                        <flux:table.cell colspan="10" class="text-center py-6 text-zinc-400">
                            {{ __('Tidak ada data') }}
                        </flux:table.cell>
                    </flux:table.row>
                @endif
            </flux:table.rows>
        </flux:table>
    </div>
</div>