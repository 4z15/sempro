@extends('template.home')
@section('title', 'Pelanggan')
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
        /* Aturan umum */
.container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
}

/* Aturan responsif */
@media (max-width: 576px) {
    .container {
        max-width: 100%;
        padding-right: 0;
        padding-left: 0;
    }
}

    </style>
    </head>

    <body>

        <div class="container mt-3">
            {{-- <x:notify-messages /> --}}
            <h2>
                Pelanggan
            </h2>

            <p>Cari Data Pelanggan :</p>
            <form action="/cust/cari" method="GET">
                <input type="text" name="cari" id="cari" placeholder="Cari Pelanggan .."
                    value="{{ old('cari') }}">
                <input type="submit" value="CARI">
            </form>
            <br>
            <br>
        </div>

        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">nama</th>
                            {{-- <th scope="col">telp</th> --}}
                            <th scope="col">Terakhir Pesan</th>
                            <th class="text-left" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $cust)
                            <tr>
                                <th scope="row">{{ $cust->id }}</th>
                                <td>{{ $cust->nama }}</td>
                                {{-- <td>{{ $cust->telp }}</td> --}}
                                <td>{{ $cust->tanggal }}</td>
                                <td>
                                    <a href="/cust/add/{{ $cust->id }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i><!-- Tambahkan ikon edit -->
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            
            {{ $customers->onEachSide(0)->links() }}
        </div>
    @endsection
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>
</html>
