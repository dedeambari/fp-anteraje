@extends('report.index')
@section('content')
    <div class="container">
        <h1 style="text-align: center; background-color: #f5f5f5; padding: 10px border-radius: 5px">
            {{ $title }}
        </h1>
        @include('report.pembayaran.sudah-bayar.table', [
            'data' => $data,
            'total_bayar' => $totalSudahBayar
        ])
    </div>
    <footer class='footer'>
        <p style='text-align: center; margin-bottom: 5px'>Copyright &copy; Laundry Version Laravel</p>
    </footer>
@endsection
