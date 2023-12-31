{{-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <title>@yield('title')</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
	


</head>
<body>
	
	<div class="container-fluid ">
		
		<div class="row">
			<div class="col-sm-3" >
				@include('template.sidebar')
				
			</div>
			<div class="col-sm-9 ">
				@include('template.pesan')
				@yield('konten')
				
			</div>
		</div>
	</div>


</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
	<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Panggil Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> --}}

    <style>
        /* CSS Kustom */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            /* Sembunyikan sidebar saat layar besar */
            height: 100%;
            width: 250px;
            background-color: #2ecc71;
            padding-top: 50px;
            /* Sesuaikan dengan ukuran navbar jika ada */
            color: #fff;
            transition: all 0.3s ease;
        }

        .content {
            margin-left: 0;
            padding: 20px;
        }

        /* Atur warna link pada sidebar */
        .sidebar a {
            color: #fff;
        }

        .sidebar a:hover {
            color: #ffd700;
            /* Warna emas saat dihover */
            text-decoration: none;
        }

        .navbar-nav .nav-item .nav-link {
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #ffd700;
            /* Warna emas saat dihover */
        }

        /* Ubah warna link yang aktif */
        .sidebar a.active {
            color: #ff0;
            /* Warna yang Anda inginkan untuk link yang aktif */
        }

        /* Media Query untuk tampilan responsif */
        @media (max-width: 768px) {
            .sidebar {
                left: 0;
                z-index: 1;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Edos Sayur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.data_pesanan') }}">Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan') }}">Pelanggan</a>
                </li>
            </ul>
        </div>
        <!-- Tambahkan menu logout di sisi kanan -->
        <div class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logout') }}">Logout</a>
            </li>
        </div>
    </nav>
    

    <div class="container-fluid">
        {{-- <div class="row"> --}}
            <!-- Sidebar -->
            {{-- <div class="col-lg-3 col-md-4 sidebar">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pengaturan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Logout</a>
        </li>
      </ul>
    </div> --}}

            <!-- Konten -->
            <div class="col-lg-9 col-md-8 content">
                {{-- <h2>Halaman Utama</h2>
      <p>Ini adalah konten halaman utama.</p> --}}
                @include('template.pesan')
                @yield('konten')
            </div>
        {{-- </div> --}}
    </div>

    <!-- Panggil Bootstrap JS (Jika Anda memerlukannya) -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
	integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
