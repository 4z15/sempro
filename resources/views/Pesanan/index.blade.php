@extends('template.home')
@section('title', 'Pesanan')
@section('konten')
    @if (session('errors'))
        <div class="alert alert-danger alert-block">
            {{ session('errors') }}
        </div>
    @endif

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- Tambahkan ini di dalam tag <head> -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <style>
            /* Ganti warna teks pada tabel dark menjadi putih */
            .table-dark th,
            .table-dark td {
                color: white;
                /* Ubah warna teks menjadi putih */
            }
            .table-dark thead {
                background-color: black; /* Ubah latar belakang header menjadi hitam */
            }

            /* Tambahkan CSS kustom di sini */
            /* Contoh CSS untuk membuat tabel responsif */
            @media (max-width: 767px) {
                table.table {
                    display: block;
                    overflow-x: auto;
                    white-space: nowrap;
                }
                
            }
        </style>
    </head>

    <body>
        <div class="container mt-3">
            <h2>Pesanan</h2>
            <p>Cari Data Pesanan :</p>
            <form action="/admin/cari_pesanan" method="GET">
                <input type="text" name="cari" id="cari" placeholder="Cari Pesanan .." value="{{ old('cari') }}">
                <input type="submit" value="CARI">
            </form>
            <br>
            <a href="{{ route('admin.insert_pesanan') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
            </a>
            <br>
        </div>
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">status</th>
                            <th scope="col">nama</th>
                            <th scope="col">status</th>
                            <th class="text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                  

                    <tbody>
                        @foreach ($customers as $cust)
                            <tr>
                                <th scope="row">{{ $cust->id }}</th>
                                <td>
                                    @if ($cust->status == 1)
                                        <a href="/admin/up_status/{{ $cust->id }}" class="btn btn-warning">
                                            <i class="fas fa-ban"></i>
                                        </a>
                                    @else
                                        <a href="/admin/up_status/{{ $cust->id }}" class="btn btn-primary">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $cust->nama }}</td>
                                <td>
                                    @if ($cust->status == 1)
                                        <span class="badge bg-success">Dibayar</span>
                                    @else
                                        <span class="badge bg-danger">Belum Bayar</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/admin/detail_pesanan/{{ $cust->id }}" class="btn btn-info">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="/pesanan/invoice/{{ $cust->id }}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $customers->onEachSide(0)->links() }}
            </div>
        </div>
    </body>
    <!-- Panggil Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endsection
