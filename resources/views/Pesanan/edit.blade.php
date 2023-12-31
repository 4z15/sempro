 @extends('template.home')
 @section('title', 'Pesanan')
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


  <div class="container mt-5 mr-2">
    <a href="/pesanan" class="btn btn-info mb-5">
      <i class="fas fa-arrow-left"></i> 
    </a>

    <form action="/pesanan/update" method="post" class="row g-3" id="formPesanan">
      @csrf
      <input type="hidden" class="form-control " id="id" name="id" value="{{ $pesanans->id }}" placeholder="Nama">
      <!-- Informasi Customer -->
      <div class="container">
        <div class="row">
          <div class="col">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $pesanans->nama }}" placeholder="Nama" autofocus>
          </div>

          <div class="col">
            <label for="telp" class="form-label">Telp</label>
            <input type="text" class="form-control" id="telp" name="telp" value="{{ $pesanans->telp }}" placeholder="No Telp">
          </div>

          <div class="col">
            <label for="tgl" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tgl" name="tgl" value="{{ $pesanans->tanggal }}">
          </div>
        </div>
      </div>

      <!-- Sayuran yang Dipesan -->
      <div class="container mt-5 mx-auto w-100">
        <div class="row">
          <div class="col-md-5">
            <h3>Cari Sayur</h3>
            <input type="text" id="cariSayur" class="form-control" placeholder="Ketik nama sayur...">
            <ul id="hasilCari" class="list-group mt-2"></ul>
          </div>
          <div class="col-md-7">
            <h3>Sayur Dipilih</h3>
            <table id="tabelSayur" class="table">
              <thead>
                <tr>
                  <th>Nama Sayur</th>
                  <th>Harga</th>
                  <th>Berat (kg)</th>
                  <th>total</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pesanans->pesanan as $pes)
                {{-- @dd($pesanans->pesanan) --}}

                <tr data-id="{{ $pes->id }}">
                  <td>{{ $pes->pesanan }}</td>
                  <td class="harga">{{ $pes->harga }}</td>
                  <td>
                    <input type="number" class="form-control berat" name="sayurs['+id_sayur+'][berat]" placeholder="Masukkan berat" value ="{{ $pes->berat }}" >
                    <div class="invalid-feedback d-none">Berat harus diisi dan lebih dari 0.</div>
                  </td>
                  <td class="total"></td>
                  <td>
                    <button type="button" class="btn btn-danger hapusSayur">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <table id="tabelFooter" class="table">
              <tfoot>
                <tr>
                  <td colspan="3">Total Keseluruhan</td>
                  <td id="totalKeseluruhan">{{ $pes->total }}</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>



      <button type="submit" class="btn btn-primary ml-3">Simpan</button>
    </form>
  </div>

  <!-- Pastikan jQuery dimuat sebelum script Anda -->
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
  {{-- <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script>
   var id_sayurs = []; 
   $(document).ready(function(){
    $('#formPesanan').submit(function(e) {
      e.preventDefault();

      var beratValid = true;

      $('#tabelSayur tbody tr').each(function() {
        var beratInput = $(this).find('.berat');
        var berat = parseInt(beratInput.val());

        if (isNaN(berat) || berat <= 0) {
          beratValid = false;
      beratInput.addClass('is-invalid'); // Menandai input sebagai tidak valid
      beratInput.closest('td').find('.invalid-feedback').removeClass('d-none'); // Menampilkan pesan kesalahan
    } else {
      beratInput.removeClass('is-invalid'); // Menghilangkan tanda tidak valid jika berat valid
      beratInput.closest('td').find('.invalid-feedback').addClass('d-none'); // Sembunyikan pesan kesalahan
    }
  });

      if (!beratValid) {
        $('#errorBerat').removeClass('d-none');
        return;
      }
      var data = {
        _token: '{{ csrf_token() }}',
        nama: $('#nama').val(),
        telp: $('#telp').val(),
        tgl: $('#tgl').val(),
        sayurs: []
      };

      $('#tabelSayur tbody tr').each(function() {

        var id_sayur = $(this).data('id');
        var index = id_sayurs.indexOf(id_sayur);

        data.sayurs.push({
          sayurid: id_sayur,
          nama: $(this).find('td:eq(0)').text(),
          harga: $(this).find('td:eq(1)').text(),
          berat: $(this).find('.berat').val(),
          total: $('#totalKeseluruhan').text(),
        });

        if (index === -1) {
          id_sayurs.push(id_sayur);
        }

      });

      $.ajax({
        url: '{{ route('pesanan.update') }}',
        type: 'POST',
        data: data,
        success: function(response) {


              console.log(response); 
              $('#alertSuccess').show();
              $('.alert-danger').remove();
              // alert('Pesanan berhasil disimpan!');
              // toastr.success('Pesanan berhasil disimpan!');
              $('#nama').val(''); // Mengosongkan input nama
              $('#telp').val(''); // Mengosongkan input telp
              $('#tgl').val(''); // Mengosongkan input tanggal
              $('#tabelSayur tbody').empty(); // Mengosongkan tabel sayur
              $('#totalKeseluruhan').text('0'); // Mengatur total keseluruhan ke 0
              // window.location.href = response.pdfUrl;
            },
            error: function(error) {
              console.log(error);
              $('.alert-danger').remove();

    // Cek jika terdapat error berat
    // if (error.responseJSON.errors && error.responseJSON.errors['sayurs.*.berat']) {
    //   var errorsBerat = error.responseJSON.errors['sayurs.*.berat'];
    //   $('.berat').each(function(index) {
    //     var invalidBerat = $(this).closest('td').find('.invalid-feedback');
    //     if (errorsBerat[index]) {
    //       invalidBerat.text(errorsBerat[index][0]);
    //       invalidBerat.removeClass('d-none');
    //     } else {
    //       invalidBerat.empty();
    //       invalidBerat.addClass('d-none');
    //     }
    //   });
    // }



    // $('.alert-danger').remove();
    // var errors = error.responseJSON.errors;
    // console.log(errors); // Cetak errors ke konsol
    // for (var key in errors) {
    //   if (errors.hasOwnProperty(key)) {
    //     var input = $('#' + key);
    //     input.after('<div class="alert alert-danger">' + errors[key][0] + '</div>');
    //   }
    // }
  }
});
      // console.log('Form submitted'); // Debugging
    });
  });


   $('#cariSayur').on('input', function() {
    var hasilCari = $('#hasilCari');
    hasilCari.empty();

    var keyword = $(this).val().toLowerCase();

    if (keyword.length > 0) {
      $.ajax({
        url: '/cari-sayur/' + keyword,
        type: 'GET',
        success: function(data) {
          if (data.length > 0) {
            data.forEach(function(sayur) {
              hasilCari.append('<li class="list-group-item p-2" data-id="'+sayur.id+'" data-nama="'+sayur.nama+'" data-harga="'+sayur.harga_kg+'">'+sayur.nama+' - '+sayur.harga_kg+' </li>');
            });
          } else {
            hasilCari.append('<li class="list-group-item p-2">Item Tidak ditemukan</li>');
          }
        }
      });
    }
  });

       // ... (kode sebelumnya)

       $(document).on('click', '#hasilCari li', function() {
        id_sayur = $(this).data('id');
        var nama = $(this).data('nama');
        var harga = $(this).data('harga');

        var tabelSayur = $('#tabelSayur tbody');
        var row = $('<tr data-id="'+id_sayur+'"><td>'+nama+'</td><td class="harga">'+harga+'</td><td><input type="number" class="form-control berat" name="sayurs['+id_sayur+'][berat]" placeholder="Masukkan berat"><div class="invalid-feedback d-none">Berat harus diisi dan lebih dari 0.</div></td><td class="total">0</td><td><button type="button" class="btn btn-danger hapusSayur"><i class="fa fa-trash"></i></button></td></tr>');


        row.find('.berat').on('input', function() {
          var berat = $(this).val();
          var hargaSayur = parseInt($(this).closest('tr').find('.harga').text());


          var total = hargaSayur * berat;
          $(this).closest('tr').find('.total').text(total);
          hitungTotalKeseluruhan();


        });

        tabelSayur.append(row);
      });


       // hitung total semua
       function hitungTotalKeseluruhan() {
        var totalKeseluruhan = 0;
        $('#tabelSayur tbody tr').each(function() {
        var harga = parseInt($(this).find('td:eq(1)').text()); // Ambil harga dari kolom kedua
        var berat = parseInt($(this).find('.berat').val()); // Ambil berat dari input
        var total = harga * berat;
        $(this).find('.total').text(total);
        totalKeseluruhan += isNaN(total) ? 0 : total;
      });
        $('#totalKeseluruhan').text(totalKeseluruhan);
      }

      // hapus baris tabel
      $(document).on('click', '.hapusSayur', function() {
        $(this).closest('tr').remove();
        hitungTotalKeseluruhan();

      });

      setTimeout(function(){
        $('#alertSuccess').hide(); // Sembunyikan alert setelah 5 detik
      }, 5000);



    </script>



    @endsection