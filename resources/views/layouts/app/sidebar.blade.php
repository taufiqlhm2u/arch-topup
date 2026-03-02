<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky collapsible="mobile"
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Platform')" class="grid mb-2">
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group class="grid mb-2">
                <flux:sidebar.item icon="puzzle-piece" :href="route('admin.game.index')"
                    :current="request()->routeIs('admin.game.*')" wire:navigate>
                    {{ __('Game') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group class="grid mb-2">
                <flux:sidebar.item icon="cube" :href="route('admin.paket.index')"
                    :current="request()->routeIs('admin.paket.*')" wire:navigate>
                    {{ __('Paket pembelian') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group class="grid mb-2">
                <flux:sidebar.item icon="chart-bar" :href="route('admin.transaksi.index')"
                    :current="request()->routeIs('admin.transaksi.*')" wire:navigate>
                    {{ __('Transaksi') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group class="grid mb-2">
                <flux:sidebar.item icon="folder" :href="route('admin.laporan.index')"
                    :current="request()->routeIs('admin.laporan.*')" wire:navigate>
                    {{ __('Laporan') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

        </flux:sidebar.nav>

        <flux:spacer />


        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                 <flux:modal.trigger name="logout">
                <flux:menu.item as="button" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </flux:modal.trigger>
            </flux:menu>
        </flux:dropdown>



    </flux:header>

    {{ $slot }}

    @livewireScripts
    @fluxScripts
</body>

</html>