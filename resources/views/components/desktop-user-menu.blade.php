<flux:dropdown position="bottom" align="start">
    <flux:sidebar.profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
        icon:trailing="chevrons-up-down" data-test="sidebar-menu-button" />

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        <flux:menu.separator />
        <flux:menu.radio.group>
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>
            <flux:modal.trigger name="logout">
                <flux:menu.item as="button" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </flux:modal.trigger>

        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>

<flux:modal name="logout">
    <div class="space-y-6">
        <div>
            <flex:heading>Logout?</flex:heading>
        </div>
        <flux:text class="mt-4">
            Apakah anda yakin ingin logout ?
        </flux:text>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">
                    Batal
                </flux:button>
            </flux:modal.close>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <flux:button variant="danger" type="submit">
                    Logout
                </flux:button>
            </form>
        </div>
    </div>
</flux:modal>