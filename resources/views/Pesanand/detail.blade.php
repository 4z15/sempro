@extends('template.home')
 @section('title', 'Pesanan Belum bayar')

@section('konten')
<div class="container mt-5 ml-7">
 <a href="{{ route('pesanand') }}" class="btn btn-primary" >Kembali</a>
 <br>
 <br>
 <div class="row g-3">
  <div class="col">
    <label for="inputEmail4" class="form-label">Nama</label>
    <input type="text" class="form-control " id="nama" name="nama" value=" {{ $customers->nama }} " readonly>
  </div>
  <div class="col">
    <label for="inputEmail4" class="form-label">Status</label>
    <input type="text" class="form-control " id="nama" name="nama" value="{{ ($customers->status == 1) ? 'Dibayar' : 'Belum Bayar' }}">
    {{-- <span class="badge badge-{{ ($customers->status == 1) ? 'success' : 'danger' }}">
      {{ ($customers->status == 1) ? 'Dibayar' : 'Belum Bayar' }}
    </span>
    --}}
  </div>
  <div class="col">
    <label for="inputEmail4" class="form-label">Telp</label>
    <input type="number" class="form-control  "  id="telp" name="telp" value="{{ $customers->telp  }}" readonly>
  </div>
  <div class="col">
    <label for="inputEmail4" class="form-label">Tanggal</label>
    <input type="date" class="form-control" id="tgl" name="tgl" value="{{  $customers->tanggal }}" >
  </div>
  <br>

</div>
<br>

<table class="table">
  <thead>
    <tr class="table  table-dark">
      <th scope="col">No</th>
      <th scope="col">Pesanan</th>
      <th scope="col">Berat(KG)</th>
      <th scope="col">Harga</th>

    </tr>
  </thead>
  <tbody>

   @foreach($customers->pesanan as $cust)
   <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $cust->pesanan }}</td>
    <td>{{ $cust->berat }}</td>
    <td>{{ $cust->harga }}</td>

  </tr>

</tbody>
@endforeach
<tfoot>
  <tr>
   <td>
    Total
  </td>
  <td>
    {{ $cust->total }}
  </td>
</tr>
</table>
</div>

@endsection
