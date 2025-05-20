@extends('report.index')
@section('content')
    <div class="container">
        <h1 style="text-align: center; background-color: #f5f5f5; padding: 10px border-radius: 5px">
            {{ $title }}
        </h1>
        @include('report.barang.detail-barang.table', $data)
    </div>
    <footer class='footer'>
        <p style='text-align: center; margin-bottom: 5px'>
            Copyright &copy; {{ config('app.name') }} {{ date('Y') }}
        </p>
    </footer>
@endsection