<table class="table table-bordered table-striped ">
    <thead>
        <tr style="text-align: center;">
            <th class="col">#</th>
            <th class="col">Nama</th>
            <th class="col">Username</th>
            <th class="col">No Handphone</th>
            <th class="col">Transportasi</th>
            <th class="col">Jumlah Tugas</th>
            <th class="col">Waktu</th>
            <th class="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $user)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->no_hp }}</td>
                <td>{{ $user->transportasi }}</td>
                <td>{{ $user->qty_task }}</td>
                <td>{{ $user->created_at->format('d-m-Y') }}</td>
                <td>
                    <span class="fw-normal {{ $user->status_deactive_staf === 1 ? 'text-success' : 'text-danger' }}">
                        {{ $user->status_deactive_staf === 1 ? 'Active' : 'Inactive' }}
                    </span>
                </td>
            </tr>
        @endforeach
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