 @extends('template.home')
 @section('title', 'Pesanan Belum bayar')
 @section('konten')
{{-- @if ($errors->any())
  <div class="alert alert-danger">
    Validation Error!
  </div>
  @endif

  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif --}}


  <div class="container ml-2 mt-3">
    <a href="/pesanan" class="btn btn-primary"> Kembali</a>
    

    {{-- @foreach($pesanans as $pesanan) --}}
    <form action="/pesanan/update" method="POST" class="row g-3">
     @csrf
     {{-- <label for="inputEmail4" class="form-label">Nama</label> --}}
     <input type="hidden" class="form-control " id="nama" name="id" value="{{ $pesanans->id }}" placeholder="Nama">
     <div class="col">
      <label for="inputEmail4" class="form-label">Nama</label>
      <input type="text" class="form-control " id="nama" name="nama" value="{{ $pesanans->nama }}" placeholder="Nama">
    </div>
    <div class="col">
      <label for="inputEmail4" class="form-label">Telp</label>
      <input type="number" class="form-control   id="telp" name="telp" value="{{ $pesanans->telp }}" placeholder="No Telp">
    </div>
    <div class="col">
      <label for="inputEmail4" class="form-label">Tanggal</label>
      <input type="date" class="form-control " id="tgl" name="tgl" value="{{ $pesanans->tanggal }}" >
    </div>
    <button type="button" name = "tambah" id = "tambah" class="btn btn-success" >Tambah</button>
    {{-- <div class="col">
    </div> --}}

    <table class="table table-bordered mt-3 " id = "tabel" >
      <thead>
        <tr>
          {{-- <th>no</th> --}}
          <th scope="col">pesanan</th>
          <th scope="col">berat</th>
          {{-- <th scope="col">harga</th> --}}
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pesanans->pesanan as $pes)
        <tr>
          {{-- <td>
            {{ $loop->iteration }}
          </td> --}}

          <td>
            {{-- <input type="text" placeholder="berat" name="pesanan[]" id ="berat_sayurs" class="form-control" value="{{ $pes->pesanan }}" > --}}
            <select class="form-select" aria-label="Default select example" name="sayuran_id[]" id ="sayuran_id" onchange="hitung()" style = width:150px; >
              <option selected >Pilih</option>
              @foreach($sayurans as $sayur)
              <option value= 
              "{{ $sayur->id }}-{{ $sayur->nama }}" {{ ($pes->sayuran_id == $sayur->id)  ? 'selected' : ''}}
              >
              {{ $sayur->nama }}-{{ $sayur->harga_kg }}
            </option>
            @endforeach
          </select>
        </td>
        <td>
          <input type= "number" placeholder="berat" name="berat_sayurs[]" id ="berat_sayurs" class="form-control berat"
          value = "{{ $pes->berat }}" readonly>
        </td>
        <td>
          <input type="number" placeholder="harga" name="harga_sayurs[]" id ="harga_sayurs" class="form-control harga" value = "{{ $pes->harga }}" readonly>
        </td>
        <td>
          <button type="button" name = "tambah"  class="btn btn-danger delete">Hapus</button>
        </td>
      </tr>
    </tbody>
    @endforeach
    <tfoot>
      <tr>
       <td>
        Total
      </td>
      <td>
        <input type="text" name="total" id = "total"  {{-- value = "{{ $pes->total }}" --}} readonly>
      </td>
    </tr>



  </tfoot>
  
</table>
{{-- @endforeach --}}
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function() {
    hitungTotal(); // Memanggil fungsi hitungTotal() saat halaman pertama kali dimuat
  });

 function hitung() {
  console.log('Fungsi hitung berjalan');
  $(document).on('change', '.sayuran_id', function() {
    var id_sayur = $(this).val();
    var [id, nama, harga_kg] = id_sayur.split('-');
    var nilai_harga = harga_kg;
    $(this).closest('tr').find('.harga').val(nilai_harga);
    hitungTotal();
  });
}

document.addEventListener('input', function(event) {
  const element = event.target;

  if (element.classList.contains('harga') || element.classList.contains('berat')) {
    hitungTotal();
  }
});

function hitungTotal() {
  let total = 0;
  $('.harga').each(function() {
    const harga = parseFloat($(this).val());
    const berat = parseFloat($(this).closest('tr').find('.berat').val());
    const subtotal = berat * harga;
    total += subtotal;
  });
  $('#total').val(total);
}
</script>
<script>
    // tambah baris pesanan
  // var i = 0;

  $('#tambah').on('click' , function(){
    hitungTotal();

    $('#tabel').append(
      `<tr>
      <td>
      <select class="form-select sayuran_id" aria-label="Default select example" name="sayuran_id[]"  onchange="hitung()" style = width:150px;  >
      <option selected >Pilih</option>
      @foreach($sayurans as $sayur)
      <option value= 
      {{ $sayur->id }}-{{ $sayur->nama }}-{{ $sayur->harga_kg }}
      >
      {{ $sayur->nama }}-{{ $sayur->harga_kg }}
      </option>
      @endforeach
      </select>
      </td>
      <td>
      <input type="number" placeholder="berat" name="berat_sayurs[]" id ="berat_sayurs" class="form-control berat">
      </td>
      <td>
      <input type="number" placeholder="harga" name="harga_sayurs[]" id ="harga_sayurs" class="form-control harga">
      </td>
      <td>
      <button type="button"  class="btn btn-danger hapus">Hapus</button>
      </td>
      </tr>`
      );
  });
// hapus baris tabel
$(document).on('click','.hapus',function(){
  $(this).parents('tr').remove();
  hitungTotal();

});
</script>
<script>
  $(document).on('click','.delete',function(){
    $(this).parents('tr').remove();
  });
</script>


@endsection