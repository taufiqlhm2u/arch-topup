<x-layouts::app>
    <x-slot:daftar>Tambah Paket Game</x-slot:daftar>
    <div class="mt-4 dark">
        <flux:card class="p-4">

            <form action="{{ route('admin.paket.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="space-y-4">

                    <div>
                        <flux:label>Game</flux:label>
                        <flux:select placeholder="Pilih game..." name="game_id">
                            @foreach ($games as $game)
                                <option value="{{ $game->id }}" {{ $game->id == $item->game_id ? 'selected' : '' }}>

                                    {{ $game->name }}

                                </option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:label for="type">Tipe</flux:label>
                        <flux:input id="type" name="type" value="{{ old('type', $item->type) }}"
                            placeholder="Diaomond, weekly pass, uc, monly pas dll" />
                        @error('type')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>

                    <div>
                        <flux:label for="image">Image</flux:label>
                        <flux:input type="file" id="image" name="image" value="{{ old('image') }}" />
                        @error('image')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>

                    <div>
                        <flux:label for="quantity">Jumlah</flux:label>
                        <flux:input type="number" id="quantity" name="quantity" value="{{ old('quantity', $item->quantity) }}" />
                        @error('quantity')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>
                    <div>
                        <flux:label for="price">Harga</flux:label>
                        <flux:input id="price" name="price" value="{{ old('price', $item->price) }}" />
                        @error('price')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>


                    <div class="flex gap-2">
                        <flux:spacer />
                        <flux:button variant="ghost" href="{{ route('admin.game.index') }}" wire:navigate>
                            Batal
                        </flux:button>
                        <flux:button variant="primary" type="submit">
                            Simpan
                        </flux:button>
                    </div>
                </div>
            </form>
        </flux:card>
    </div>

</x-layouts::app>