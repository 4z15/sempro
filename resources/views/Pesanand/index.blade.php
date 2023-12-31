 
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

@extends('template.home')
 @section('title', 'Pesanan Beres')

@section('konten')
<div class="container mt-3" >

  <h2 >
   Pesanan
 </h2>

 <p>Cari Data Pesanan :</p>
 <form action="/pesanand/cari" method="GET">
  <input type="text" name="cari" placeholder="Cari Pesanan .." value="{{ old('cari') }}">
  <input type="submit" value="CARI">
</form>

<br>
{{-- <a href="/pesanan/input/" class="btn btn-primary">Tambah</a> --}}

</div>

<div class="container-fluid">
  <table class="table table-hover">
    <thead>
      <tr class="table table-dark">
        <th scope="col">#</th>
        {{-- <th scope="col">status</th> --}}
        <th scope="col">nama</th>
        {{-- <th scope="col">pesanan</th> --}}
        {{--  <th scope="col">berat(kg)</th> --}}
        <th scope="col">status</th>


        <th class="text-left" scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody class>
      @foreach ($customers as $cust)
      <tr>
        <th scope="row">{{ $cust->id }}</th>
       {{--  <td>
         @if($cust->status == 1)
         <a href="/pesanand/up_status/{{ $cust->id }}" class="btn btn-warning" >Non Aktifkan</a> 
         @else
         <a href="/pesanand/up_status/{{ $cust->id }}" class="btn btn-primary" >Aktifkan</a> 
         @endif
       </td> --}}
       <td>
        {{ $cust->nama }}
      </td>

       {{--  @if (count($pesanan->customer()) > 0)
          @foreach($pesanan->customer as $customera)
           <td>
            {{ $customera->nama }}
          </td>
          @endforeach
          @endif --}}
          {{-- <td>{{ $cust->pesanan }}</td> --}}
          {{-- <td>{{ $pesanan->pesanan }}</td> --}}
          {{-- <td>Data</td> --}}



          {{-- <td>{{ $pesanan->berat }}</td> --}}
          <td>
            @if($cust->status == 1)
            <span class="badge bg-success" >Dibayar</span>
            @else
            <span class="badge bg-danger ">Belum Bayar</span>
            @endif
          </td>


          <td>
            {{-- <a href="/pesanand/edit/{{ $cust->id }}" class="btn btn-warning">Edit</a> --}}
            <a href="/pesanand/hapus/{{ $cust->id }}" class="btn btn-danger" >Hapus</a>
            <a href="/pesanand/detail/{{ $cust->id }}" class="btn btn-info">Detail</a>
            <a href="/pesanand/invoice/{{ $cust->id }}" class="btn btn-primary" target="_blank">Struk</a>

          </td>


        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $customers->links()}}

  </div>
  @endsection