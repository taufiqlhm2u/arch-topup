<x-layouts::app>
    <x-slot:daftar>Tambah Game</x-slot:daftar>
    <div class="mt-4 dark">
        <flux:card class="p-4">

            <form action="{{ route('admin.game.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <flux:label for="name">Nama</flux:label>
                        <flux:input id="name" name="name" value="{{ old('name') }}" />
                        @error('name')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>
                    <div>
                        <flux:label for="publisher">Publisher</flux:label>
                        <flux:input id="publisher" name="publisher" value="{{ old('publisher') }}" />
                        @error('publisher')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>

                    <div>
                        <flux:label for="badge">Badge</flux:label>
                        <flux:input id="badge" name="badge" value="{{ old('badge') }}" />
                        @error('badge')
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
                        <flux:label for="status">Status</flux:label>
                        <flux:select id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:label for="serve_id">Server ID (jika ada)</flux:label>
                        <flux:select id="serve_id" name="serve_id">
                            <option value="false">Tidak ada</option>
                            <option value="true">Ada</option>
                        </flux:select>
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