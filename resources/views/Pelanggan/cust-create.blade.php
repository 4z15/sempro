@extends('template.home')
@section('title', 'Pesanan')
@section('konten')


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cari dan Simpan Sayur</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- Tambahkan ini di dalam tag <head> -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">


        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"> --}}



        <!-- ... (code sebelumnya) ... -->
        <style>
            /* Untuk mengatur lebar modal pada perangkat mobile */
            @media (max-width: 576px) {
                .modal-dialog {
                    max-width: 90%;
                    margin: auto;
                }
            }

            /* Untuk mengatur lebar modal pada perangkat tablet */
            @media (max-width: 768px) {
                .modal-dialog {
                    max-width: 70%;
                    margin: auto;
                }
            }

            /* Untuk mengatur lebar modal pada perangkat desktop */
            @media (min-width: 992px) {
                .modal-dialog {
                    max-width: 50%;
                    margin: auto;
                }
            }

            @media (max-width: 576px) {
                .modal-content {
                    /* Aturan CSS untuk modal di layar dengan lebar maksimum 576px */
                    /* Contoh pengaturan padding atau margin */
                    padding: 10px;
                }
            }

            @media (max-width: 768px) {

                /* Aturan CSS untuk layar dengan lebar maksimum 768px */
                .table-responsive {
                    /* Tambahkan gaya CSS yang sesuai */
                    overflow-x: auto;
                }

                /* Aturan CSS untuk kolom tabel pada layar kecil */
                .table-responsive table th,
                .table-responsive table td {
                    /* Tambahkan aturan CSS yang sesuai */
                    white-space: nowrap;
                    /* Mencegah pemutaran teks */
                }
            }
        </style>

    </head>


    <div id="alertSuccess" class="alert alert-success" style="display:none;">
        Pesanan berhasil disimpan!
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailSayurModal" tabindex="-1" role="dialog" aria-labelledby="detailSayurModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailSayurModalLabel">Detail Sayuran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Sayuran:</strong> <span id="modalNamaSayur"></span></p>
                    <p><strong>Harga:</strong> <span id="modalHarga"></span></p>
                    <div class="form-group">
                        <label for="beratModal" class="form-label">Berat/Satuan</label>
                        <input type="number" class="form-control" id="beratModal" placeholder="Masukkan nomina"
                            step="0.25">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanSayur">Simpan</button>
                </div>
            </div>
        </div>
    </div>



    <body>

        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <a href="/cust" class="btn btn-info mb-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>

            <form action="/cust/save" method="post" class="row g-3" id="formPesanan">
                @csrf
                <input type="hidden" class="form-control " id="customer_id" name="customer_id" value="{{ $custs->id }}"
                placeholder="Nama">
                {{-- <div class="container"> --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Informasi Pelanggan</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Nama</label>
                                <input type="text" class="form-control " id="nama" name="nama"
                                    value="{{ $custs->nama }}" placeholder="Nama" autofocus>
                            </div>

                            {{-- <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Telp</label>
                                <input type="text" class="form-control " id="telp" name="telp"
                                    value="{{ $custs->telp }}" placeholder="No Telp">
                            </div> --}}

                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tgl" name="tgl"
                                    value="{{ $custs->tanggal }}">
                            </div>
                            {{-- @foreach ($custs->pesanan as $cust) --}}
                            <div class="col-md-6">
                                <label for="catatan" class="form-label">Catatan </label>
                                <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan Pesanan Pelanggan"></textarea>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                    </div>
                </div>




                {{-- <div class="container mt-5 mx-auto w-100"> --}}


                <div class="row">
                    <div class="col-md-5">
                        <h3>Cari Sayur</h3>
                        <input type="text" id="cariSayur" class="form-control" placeholder="Ketik nama sayur,asin...">
                        <ul id="hasilCari" class="list-group mt-2"></ul>
                    </div>
                    <div class="col-md-7">
                        <h3>Sayur Dipilih</h3>
                        <div class="table-responsive">
                            <table id="tabelSayur" class="table">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Nama Sayur</th>
                                        <th class="col-md-3">Harga(Rp)</th>
                                        <th class="col-md-2">Jumlah</th>
                                        <th class="col-md-2">Total</th>
                                        <th class="col-md-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <table id="tabelFooter" class="table">
                                <tfoot>
                                    <tr>
                                        <td colspan="3">Total Keseluruhan</td>
                                        <td id="totalKeseluruhan">0</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Pembayaran</td>
                                        <td>
                                            <input type="number" class="form-control" id="pembayaran" name="pembayaran"
                                                placeholder="Masukkan jumlah pembayaran" step="1">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Sisa</td>
                                        <td>
                                            <input type="text" class="form-control" id="kembalian" name="kembalian"
                                                readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
                {{-- </div> --}}


                {{-- </div> --}}
                <button type="submit" class="btn btn-primary ml-3" name="submit">Simpan</button>
            </form>

        </div>

        <!-- Pastikan jQuery dimuat sebelum script Anda -->
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
        {{-- <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script>
            var id_sayurs = [];
            $(document).ready(function() {
                $('#formPesanan').submit(function(e) {
                    e.preventDefault();

                    // var beratValid = true;
                    // $('#tabelSayur tbody tr').each(function() {
                    //     var beratInput = $(this).find('.berat');
                    //     var berat = parseInt(beratInput.val());

                    //     if (isNaN(berat) || berat < 0) {
                    //         beratValid = false;
                    //         beratInput.addClass('is-invalid'); // Menandai input sebagai tidak valid
                    //         beratInput.closest('td').find('.invalid-feedback').removeClass(
                    //             'd-none'); // Menampilkan pesan kesalahan
                    //     } else {
                    //         beratInput.removeClass(
                    //             'is-invalid'); // Menghilangkan tanda tidak valid jika berat valid
                    //         beratInput.closest('td').find('.invalid-feedback').addClass(
                    //             'd-none'); // Sembunyikan pesan kesalahan
                    //     }
                    // });

                    // if (!beratValid) {
                    //     $('#errorBerat').removeClass('d-none');
                    //     return;
                    // }
                    var total = $('#totalKeseluruhan').text().replace('Rp ', '').replace('.', '');
                    var pembayaran = $('#pembayaran').val().replace('Rp ', '').replace('.', '');
                    var kembalian = $('#kembalian').val().replace('Rp ', '').replace('.', '');
                    var harga = $('#kembalian').val().replace('Rp ', '').replace('.', '');

                    var data = {
                        _token: '{{ csrf_token() }}',
                        nama: $('#nama').val(),
                        telp: $('#telp').val(),
                        tgl: $('#tgl').val(),
                        catatan: $('#catatan').val(),
                        sayurs: []
                    };

                    $('#tabelSayur tbody tr').each(function() {

                        var id_sayur = $(this).data('id');
                        var index = id_sayurs.indexOf(id_sayur);



                        data.sayurs.push({
                            sayurid: id_sayur,
                            nama: $(this).find('td:eq(0)').text(),
                            harga: $(this).find('td:eq(1)').text().replace('Rp ', '').replace(
                                '.', ''),
                            berat: $('#beratModal').val(),
                            total: total,
                            Bayar: pembayaran,
                            Kembalian: kembalian,

                        });

                        if (index === -1) {
                            id_sayurs.push(id_sayur);
                        }

                    });

                    $.ajax({
                        url: '{{ route('pesanan.store') }}',
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
                            $('#catatan').val(''); // Mengosongkan input catatan
                            $('#pembayaran').val(''); // Mengosongkan input pembayaran
                            $('#kembalian').val(''); // Mengosongkan input kembalian


                            $('#tabelSayur tbody').empty(); // Mengosongkan tabel sayur
                            $('#totalKeseluruhan').text('0'); // Mengatur total keseluruhan ke 0
                            // window.location.href = response.pdfUrl;
                        },
                        error: function(error) {
                            console.error(error);
                            alert(error);

                            $('.alert-danger').remove();

                            // Cek jika terdapat error berat
                            if (error.responseJSON.errors && error.responseJSON.errors[
                                    'sayurs.*.berat']) {
                                var errorsBerat = error.responseJSON.errors['sayurs.*.berat'];
                                $('.berat').each(function(index) {
                                    var invalidBerat = $(this).closest('td').find(
                                        '.invalid-feedback');
                                    if (errorsBerat[index]) {
                                        invalidBerat.text(errorsBerat[index][0]);
                                        invalidBerat.removeClass('d-none');
                                    } else {
                                        invalidBerat.empty();
                                        invalidBerat.addClass('d-none');
                                    }
                                });
                            }
                            // $('.alert-danger').remove();
                            var errors = error.responseJSON.errors;
                            console.log(errors); // Cetak errors ke konsol
                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    var input = $('#' + key);
                                    input.after('<div class="alert alert-danger">' + errors[key][
                                        0
                                    ] + '</div>');
                                }
                            }
                        }
                    });
                    console.log('Form submitted'); // Debugging
                });
            });


            $(document).ready(function() {
                // Event handler untuk input pencarian
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
                                        hasilCari.append(
                                            '<li class="list-group-item p-2" data-id="' +
                                            sayur.id + '" data-nama="' + sayur.nama +
                                            '" data-harga="' + sayur.harga_kg + '">' +
                                            sayur.nama +
                                            ' - ' + sayur.harga_kg + ' </li>');
                                    });
                                } else {
                                    hasilCari.append(
                                        '<li class="list-group-item p-2">Item Tidak ditemukan</li>'
                                    );
                                }
                            }
                        });
                    }
                });

                // Event handler untuk menambahkan data sayuran ke dalam tabel
                $(document).on('click', '#hasilCari li', function() {
                    var id_sayur = $(this).data('id');
                    var nama = $(this).data('nama');
                    var harga = $(this).data('harga');
                    tampilkanModal(nama, harga);

                    // var tabelSayur = $('#tabelSayur tbody');
                    // var row = $('<tr data-id="' + id_sayur + '"><td>' + nama +
                    //     '</td><td class="harga">' + harga +
                    //     '</td><td><input type="number" class="form-control berat" name="sayurs[' +
                    //     id_sayur +
                    //     '][berat]" placeholder="Masukkan berat(kg)" step="0.25"><div class="invalid-feedback d-none">Berat minimal 0.25 kg.</div></td><td class="total">Rp.0</td><td><button type="button" class="btn btn-danger hapusSayur"><i class="fa fa-trash"></i></button></td></tr>'
                    // );

                    // row.find('.berat').on('input', function() {
                    //     var berat = $(this).val();
                    //     var hargaSayur = parseInt($(this).closest('tr').find('.harga').text());

                    //     var total = hargaSayur * berat;
                    //     $(this).closest('tr').find('.total').text(total);
                    //     hitungTotalKeseluruhan();
                    // });

                    // tabelSayur.append(row);
                    // var modalBody = $('#detailSayurModal').find('.modal-body');
                    // var inputBerat = '<div class="form-group"><label for="berat">Berat (kg)</label>' +
                    //     '<input type="number" class="form-control berat-modal" id="berat" placeholder="Masukkan berat(kg)" step="0.25"></div>';

                    // modalBody.append(inputBerat);
                    $('#simpanSayur').off('click').on('click', function() {
                        var berat = parseFloat($('#beratModal').val()) || 0;
                        var harga = parseFloat($('#modalHarga').text().replace('Rp ', '').replace('.',
                            '')) || 0; // Harga per kg
                        if (berat < 0) {
                            alert('Berat tidak boleh minus.');
                            return; // Menghentikan penambahan data jika berat tidak valid
                        }

                        var total = harga * berat; // Hitung total per sayuran

                        // Tambahkan item sayuran ke dalam tabelSayur
                        var newRow = $('<tr data-id="' + id_sayur + '">' +
                            '<td>' + nama + '</td>' +
                            '<td class="harga">' + formatRupiah(harga) + '</td>' +
                            '<td>' + berat + '</td>' +
                            '<td class="total">' + formatRupiah(total) + '</td>' +
                            '<td><button type="button" class="btn btn-danger hapusSayur"><i class="fa fa-trash"></i></button></td>' +
                            '</tr>');

                        $('#tabelSayur tbody').append(newRow);

                        // Hitung kembali total keseluruhan
                        hitungTotalKeseluruhan();

                        // Tutup modal
                        $('#detailSayurModal').modal('hide');
                    });
                });
            });



            // hitung total semua
            // hitung total semua
            // function hitungTotalKeseluruhan() {
            //     var totalKeseluruhan = 0;
            //     var beratValid = true; // Inisialisasi variabel untuk mengecek validasi berat

            //     $('#tabelSayur tbody tr').each(function() {
            //         var harga = parseInt($(this).find('.harga').text());
            //         var berat = parseFloat($(this).find('.berat').val()) ||
            //             0; // Gunakan parseFloat untuk fraksi desimal

            //         // if (berat < 0) { // Cek jika berat kurang dari 0
            //         //     beratValid = false;
            //         //     $(this).find('.berat').addClass('is-invalid'); // Tandai input sebagai tidak valid
            //         // } else {
            //         //     $(this).find('.berat').removeClass('is-invalid'); // Hapus tanda tidak valid jika berat valid
            //         // }

            //         var total = harga * berat;
            //         $(this).find('.total').text(total.toFixed(0)); // Menampilkan total dengan 2 digit desimal
            //         totalKeseluruhan += isNaN(total) ? 0 : total;
            //     });

            //     // if (!beratValid) {
            //     //     $('#errorBerat').removeClass('d-none');
            //     //     return;
            //     // } else {
            //     //     $('#errorBerat').addClass('d-none');
            //     // }

            //     $('#totalKeseluruhan').text(totalKeseluruhan.toFixed(
            //         0)); // Menampilkan total keseluruhan dengan 2 digit desimal
            // }

            function hitungTotalKeseluruhan() {
                var totalKeseluruhan = 0;

                $('#tabelSayur tbody tr').each(function() {
                    var totalPerSayur = parseFloat($(this).find('.total').text().replace('Rp ', '').replace('.', '')) ||
                        0;
                    totalKeseluruhan += totalPerSayur;
                });

                $('#totalKeseluruhan').text(formatRupiah(totalKeseluruhan)); // Update total keseluruhan
            }



            // hapus baris tabel
            $(document).on('click', '.hapusSayur', function() {
                $(this).closest('tr').remove();
                hitungTotalKeseluruhan();

            });

            setTimeout(function() {
                $('#alertSuccess').hide(); // Sembunyikan alert setelah 5 detik
            }, 5000);

            function formatRupiah(angka) {
                var number_string = angka.toString();
                var split = number_string.split(',');
                var sisa = split[0].length % 3;
                var rupiah = split[0].substr(0, sisa);
                var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp ' + rupiah;
            }

            function tampilkanModal(nama, harga) {
                $('#detailSayurModal').modal('show'); // Menampilkan modal

                // Menambahkan informasi sayuran ke dalam modal
                $('#modalNamaSayur').text(nama);
                $('#modalHarga').text(formatRupiah(harga));

                // Mengosongkan input berat di modal
                $('.berat-modal').val('');
            }

            $(document).ready(function() {
                $('#pembayaran').on('input', function() {
                    var totalHarga = parseInt($('#totalKeseluruhan').text().replace('Rp ', '').replace('.',
                        '')) || 0;
                    var pembayaran = parseInt($(this).val()) || 0;

                    var kembalian = totalHarga - pembayaran;

                    $('#kembalian').val(formatRupiah(kembalian));
                });
            });
        </script>




    </body>

    </html>


@endsection
