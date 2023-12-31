@extends('template.home')
@section('title', 'Pesanan')
@section('konten')
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- Tambahkan ini di dalam tag <head> -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

</head>
<div class="container mt-5">
   <a href="{{ route('admin.data_pesanan') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
  <div class="row mt-3">
    <div class="col-md-6">
      <div class="form-group">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ $customers->nama }}" readonly>
      </div>
      <div class="form-group">
        <label for="status" class="form-label">Status</label>
        <input type="text" class="form-control" id="status" name="status" value="{{ ($customers->status == 1) ? 'Dibayar' : 'Belum Bayar' }}" readonly>
      </div>
    </div>
    <div class="col-md-6">
      {{-- <div class="form-group">
        <label for="telp" class="form-label">Telp</label>
        <input type="number" class="form-control" id="telp" name="telp" value="{{ $customers->telp }}" readonly>
      </div> --}}
      <div class="form-group">
        <label for="tgl" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tgl" name="tgl" value="{{ $customers->tanggal }}" readonly>
      </div>
    </div>
  </div>

  <div class="table-responsive mt-4">
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Pesanan</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Harga</th>
        </tr>
      </thead>
      <tbody>
        @foreach($customers->pesanan as $index => $cust)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $cust->pesanan }}</td>
          <td>{{ $cust->berat }}</td>
          <td>{{ $cust->harga }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="text-right">Total</td>
          <td>{{ $cust->total }}</td>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class="form-group mt-4">
    <label for="catatan" class="form-label">Catatan</label>
    <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan Pesanan Pelanggan">{{ $cust->catatan }}</textarea>
  </div>
</div>
@endsection
