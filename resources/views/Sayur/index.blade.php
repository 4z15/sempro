<html>


<body>

  @extends('template.home')
  @section('title', 'Stok Sayuran')
  @section('konten')
  @if (session('errors'))
  <div class="alert alert-danger alert-block">
    {{ session('errors') }}
  </div>
  @endif
  <div class="container mt-3" >
    {{-- <x:notify-messages /> --}}
    <h2 >
     Sayuran
   </h2>

   <p>Cari Data Sayuran :</p>
   <form action="/sayuran/cari" method="GET">
    <input type="text" name="cari" id="cari" placeholder="Cari Sayuran .." value="{{ old('cari') }}">
    <input type="submit" value="CARI">
  </form>


  <br>
  <a href="/sayuran/input/" class="btn btn-primary">
    <i class="fas fa-plus"></i>
  </a>


  <br>
  <br>
</div>


<div class="container-fluid">
  <table class="table table-hover">
    <thead>
      <tr class="table table-dark">
        <th scope="col">#</th>
        <th scope="col">nama</th>
        <th scope="col">harga(kg)</th>
        <th scope="col">stok</th>



        <th class="text-center" scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody class>
      @foreach ($sayurans as $sayur)
      <tr >
        <th scope="row">{{ $sayur->id }}</th>

        <td>
          {{ $sayur->nama }}
        </td>
        <td>
          {{$sayur->harga_kg}}
        </td>
        <td>
            {{$sayur->stok}}
          </td>


        <td>
          <a href="/sayuran/edit/{{ $sayur->id }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> <!-- Tambahkan ikon edit -->
          </a>
          <a href="/sayuran/hapus/{{ $sayur->id }}" class="btn btn-danger">
            <i class="fas fa-trash"></i> <!-- Tambahkan ikon hapus -->
          </a>
          {{-- <a href="/sayuran/detail/{{ $sayur->id }}" class="btn btn-info">
            <i class="fas fa-info-circle"></i> <!-- Tambahkan ikon detail -->
          </a> --}}
          {{-- <a href="/pesanan/invoice/{{ $cust->id }}" class="btn btn-primary" target="_blank">
            <i class="fas fa-file-invoice"></i> <!-- Tambahkan ikon struk -->
          </a> --}}
        </td>



      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $sayurans->links()}}
</div>
{{--   <x-notify::notify/>
@notifyJs --}}
@endsection
</body>
</html>

