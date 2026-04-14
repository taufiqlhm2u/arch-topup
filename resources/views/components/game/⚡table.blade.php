<?php

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Game;

new class extends Component {
    use \Livewire\WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function games()
    {
        return Game::query()->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)->paginate(5);
    }

    public function count()
    {
        return Game::count();
    }
};
?>
<div>

    <div class="flex justify-between mb-4">
        <div>
            <flux:icon.loading wire:loading class="text-blue-500" />
        </div>
        <flux:button :href="route('admin.game.create')" wire:navigate icon="plus" variant="primary" color="blue">
            Tambah
        </flux:button>
    </div>

    <flux:table :paginate="$this->games">
        <flux:table.columns>
            <flux:table.column class="w-8">No</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                wire:click="sort('name')">Nama game</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'publisher'" :direction="$sortDirection"
                wire:click="sort('publisher')">Publisher</flux:table.column>
            <flux:table.column>Server ID game</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'status'" :direction="$sortDirection"
                wire:click="sort('status')">Status</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                wire:click="sort('created_at')">Dibuat</flux:table.column>
            <flux:table.column>Aksi</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->games as $game)
                <flux:table.row :key="$game->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $this->games->firstItem() + $loop->index }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap flex items-center gap-3">
                        <flux:avatar src="{{ asset('storage/' . $game->image) }}" />
                        {{ $game->name }}
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $game->publisher }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $game->server_id ? 'Ada' : 'Tidak ada' }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" :color="$game->status_color" inset="top bottom">{{ $game->status }}
                        </flux:badge>
                    </flux:table.cell>


                    <flux:table.cell class="whitespace-nowrap">{{ $game->created_at->translatedFormat('d F Y') }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>
                            <flux:menu>
                                <flux:menu.item :href="route('admin.game.edit', $game)" icon="pencil" wire:navigate>
                                    {{ __('Edit') }}
                                </flux:menu.item>

                                <flux:modal.trigger name="hapus-{{ $game->id }}">
                                    <flux:menu.item variant="danger" icon="trash">
                                        Hapus
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu>
                        </flux:dropdown>

                        <flux:modal name="hapus-{{ $game->id }}">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading>Hapus Game</flux:heading>
                                    <flux:text class="mt-2">
                                        Apakah kamu yakin ingin menghapus game ini?
                                    </flux:text>
                                </div>

                                <div class="flex gap-2">
                                    <flux:spacer />

                                    <flux:modal.close>
                                        <flux:button variant="ghost">
                                            Cancel
                                        </flux:button>
                                    </flux:modal.close>

                                    <form action="{{ route('admin.game.destroy', $game) }}" method="POST">
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
            @if ($this->games->count() < 1)
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center">
                        {{ __('Tidak ada data') }}
                    </flux:table.cell>
                </flux:table.row>
            @endif
        </flux:table.rows>
    </flux:table>

</div>
