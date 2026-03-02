<x-layouts::app>
    <x-slot:daftar>Edit Game</x-slot:daftar>
    <div class="mt-4 dark">
        <flux:card class="p-4">

            <form action="{{ route('admin.game.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <flux:label for="name">Nama</flux:label>
                        <flux:input id="name" name="name" value="{{ $item->name }}" />
                        @error('name')
                            <flux:text class="text-red-500">{{ $message }}</flux:text>
                        @enderror
                    </div>
                    <div>
                        <flux:label for="publisher">Publisher</flux:label>
                        <flux:input id="publisher" name="publisher" value="{{ $item->publisher }}" />
                        @error('publisher')
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
                            <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $item->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:label for="serve_id">Server ID (jika ada)</flux:label>
                        <flux:select id="serve_id" name="serve_id">
                            <option value="false" {{ $item->server_id == false ? 'selected' : '' }}>Tidak ada</option>
                            <option value="true" {{ $item->server_id == true ? 'selected' : '' }}>Ada</option>
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