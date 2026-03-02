<?php

use App\Models\Package;
use Livewire\Component;

new class extends Component {

    // use \Livewire\WithPagination;

    public $sortBy = 'game_id';
    public $sortDirection = 'asc';
    public $search = '';

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function packages()
    {
        $query = Package::orderBy($this->sortBy, $this->sortDirection);

        $keyword = $this->search;
        if ($keyword) {
            $query->whereHas('game', function ($query) use ($keyword) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
            })
                ->orWhereRaw("LOWER(type) LIKE ?", ['%' . strtolower($keyword) . '%'])
                ->orWhere('quantity', 'like', '%' . $keyword . '%')
                ->orWhere('price', 'like', '%' . $keyword . '%');
        }

        $packages = $query->paginate(5);
        return $packages;
    }

    public function count()
    {
        return Package::count();
    }
};
?>

<div>
    <div class="flex justify-end mb-4">
        <flux:button :href="route('admin.paket.create')" wire:navigate icon="plus" variant="primary" color="blue">Tambah
        </flux:button>
    </div>

    <div class="flex justify-between mb-4">
        <div>
            <flux:icon.loading wire:loading wire:target="sort" class="text-blue-500" />
        </div>
        <div class="w-50">
            <flux:input icon="magnifying-glass" wire:model.live="search" autocomplete="off" placeholder="Cari paket..." />
        </div>
    </div>

    <flux:table :paginate="$this->packages">
        <flux:table.columns>
            <flux:table.column>No</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'game_id'" :direction="$sortDirection"
                wire:click="sort('game_id')">Game</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'type'" :direction="$sortDirection"
                wire:click="sort('type')">Type</flux:table.column>
            <flux:table.column>Gambar</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'quantity'" :direction="$sortDirection"
                wire:click="sort('quantity')">Quantity</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'price'" :direction="$sortDirection"
                wire:click="sort('price')">Harga</flux:table.column>
            <flux:table.column>Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->packages as $package)
                <flux:table.row :key="$package->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $this->packages->firstItem() + $loop->index }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $package->game->name }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $package->type }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap"><img src="{{ asset('storage/' . $package->image) }}"
                            class="w-10" alt="">
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $package->quantity }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ 'Rp ' . number_format($package->price, 0, ',', '.') }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>
                            <flux:menu>
                                <flux:menu.item :href="route('admin.paket.edit', $package->id)" wire:navigate icon="pencil">
                                    Edit
                                </flux:menu.item>
                                <flux:modal.trigger name="hapus-{{ $package->id }}">
                                    <flux:menu.item variant="danger" icon="trash">
                                        Hapus
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu>
                        </flux:dropdown>
                        <flux:modal name="hapus-{{ $package->id }}">
                            <div class="space-y-6">
                                <div>
                                    <flex:heading>Hapus Paket?</flex:heading>
                                </div>
                                <flux:text class="mt-4">
                                    Apakah anda yakin ingin menghapus paket "{{ $package->quantity . ' ' .  $package->type }}" ?
                                </flux:text>

                                <div class="flex gap-2">
                                    <flux:spacer />

                                    <flux:modal.close>
                                        <flux:button variant="ghost">
                                            Cancel
                                        </flux:button>
                                    </flux:modal.close>

                                    <form action="{{ route('admin.paket.destroy', $package) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button variant="danger" type="submit">
                                            Hapus
                                        </flux:button>
                                    </form>
                                </div>
                            </div>
                        </flux:modal>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
            @if($this->packages->count() < 1)
                <flux:table.row>
                    <flux:table.cell colspan="6" class="text-center">
                        {{ __('Tidak ada data') }}
                    </flux:table.cell>
                </flux:table.row>
            @endif
        </flux:table.rows>
    </flux:table>
</div>