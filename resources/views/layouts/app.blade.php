<x-layouts.base>
    @if (in_array(request()->route()->getName(), [
            'dashboard',
            'profile',
            // Staf
            'staf',
            'staf.add',
            'staf.edit',

            //Kategori
            'kategori',
            'kategori.add',
            'kategori.edit',

            // barang
            'barang',
            'barang.add',
            'barang.edit',
            'barang.detail',
        ]))
        {{-- Nav --}}
        @include('layouts.nav')
        {{-- SideNav --}}
        @include('layouts.sidenav')
        <main class="content">
            {{-- TopBar --}}
            {{ $slot }}
        </main>
    @elseif(in_array(request()->route()->getName(), ['login', 'forgot-password', 'reset-password']))
        {{ $slot }}
    @elseif(in_array(request()->route()->getName(), ['404', '500']))
        {{ $slot }}
    @endif
</x-layouts.base>
