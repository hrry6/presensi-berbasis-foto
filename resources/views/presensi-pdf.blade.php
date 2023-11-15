hello

    <!DOCTYPE html>
<html>

<head>
    <style>
        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #09090b;
        color: white;
        }
    </style>
</head>
<body>
    <div>
        <br>
        <h1>Tabel Presensi</h1>
        <br>
        <table id="customers">
            <tr class="">
                <th scope="col">No</th>
                <th scope="col">Nis</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Kelas</th>
                <th scope="col">Kehadiran</th>
                <th scope="col">Keterangan</th>
            </tr>
            @foreach ($presensi as $p)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $p->nis }}</td>
                <td>{{ $p->nama_siswa }}</td>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->tingkatan." ".$p->nama_jurusan." ".$p->nama_kelas}}</td>
                <td>{{ $p->status_kehadiran }}</td>
                <td>{{ $p->keterangan }}</td>
            </tr>
        @endforeach
        </table>
    </div>
</body>