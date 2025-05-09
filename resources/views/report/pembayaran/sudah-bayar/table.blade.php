<table class="table table-bordered table-striped ">
    <thead>
        <tr style="text-align: center;">
            <th class="border-bottom">No</th>
            <th class="border-bottom">Nama</th>
            <th class="border-bottom">Nomer Handphone</th>
            <th class="border-bottom">Kategori Pesanan</th>
            <th class="border-bottom">Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->user->name }}</td>
                <td>{{ $row->user->no_hp }}</td>
                <td>{{ $row->name_kld }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <span class="w-100 badge badge-medium rounded-pill p-2"
                            style="background-color: rgba(0, 78, 49, 0.81); color: white; padding: 10px; border-radius: 5px">
                            <i class="fas fa-check text-light me-2"></i>
                            Rp.{{ number_format($row->bayar, 0, ',', '.') }}
                        </span>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>

            <td colspan='5' style='text-align: center; background-color: #4d4d4d; color: white; font-weight: bold'>
                Total Sudah Bayar Rp {{ number_format($total_bayar, 0, ',', '.') }}
            </td>

        </tr>
    </tbody>
</table>

<style>
    .text-success {
        color: rgb(12, 132, 12);
    }

    .text-danger {
        color: red;
    }
</style>
