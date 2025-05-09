<x-layouts.base>
    @if (in_array(request()->route()->getName(), [
            'dashboard',
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

            //Pembayaran
            'pembayaran.sudah-bayar',
            'pembayaran.belum-bayar',

            // kategori
            'kategori-all',
            'kategori-kiloan',
            'kategori-satuan',
            'kategori-express',
        ]))
        {{-- Nav --}}
        @include('layouts.nav')
        {{-- SideNav --}}
        @include('layouts.sidenav')
        <main class="content">
            {{-- TopBar --}}
            @include('layouts.topbar')
            {{ $slot }}
        </main>
    @elseif(in_array(request()->route()->getName(), ['login', 'forgot-password', 'reset-password']))
        {{ $slot }}
    @elseif(in_array(request()->route()->getName(), ['404', '500']))
        {{ $slot }}
    @endif
</x-layouts.base>
