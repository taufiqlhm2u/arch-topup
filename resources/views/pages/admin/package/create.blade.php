<x-layouts::app>
    <x-slot:daftar>Tambah Paket Game</x-slot:daftar>
    <div class="mt-4 dark">
        <flux:card class="p-4">

            <form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">

                    <div>
                        <flux:label>Game</flux:label>
                        <flux:select placeholder="Pilih game..." name="game_id">
                            @foreach ($games as $game)
                                <flux:select.option value="{{ $game->id }}">

                                    {{ $game->name }}

                                </flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:label for="type">Tipe</flux:label>
                        <flux:input id="type" name="type" value="{{ old('type') }}"
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
                        <flux:input type="number" id="quantity" name="quantity" placeholder="Jumlah item, contoh: 300 => 300 Diaomond" value="{{ old('quantity') }}" />
                        @error('quantity')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>
                    <div>
                        <flux:label for="price">Harga</flux:label>
                        <flux:input id="price" name="price" value="{{ old('price') }}" />
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