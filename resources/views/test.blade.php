<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Modal dengan Inputan Berat - Responsif</title>
  <!-- Link CSS Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Menyesuaikan modal agar responsif di semua perangkat */
    @media (min-width: 576px) {
      .modal-dialog {
        max-width: 80%;
        margin: 1.75rem auto;
      }
    }
    @media (min-width: 768px) {
      .modal-dialog {
        max-width: 60%;
        margin: 1.75rem auto;
      }
    }
    @media (min-width: 992px) {
      .modal-dialog {
        max-width: 50%;
        margin: 1.75rem auto;
      }
    }
    @media (min-width: 1200px) {
      .modal-dialog {
        max-width: 40%;
        margin: 1.75rem auto;
      }
    }
  </style>
</head>
<body>

<!-- Tombol untuk membuka modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Buka Modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Masukkan Berat</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <input type="number" id="inputBerat" class="form-control" placeholder="Masukkan berat (kg)">
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="tampilkanBerat()">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      
    </div>
  </div>
</div>

<!-- Link script Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  // Fungsi untuk menampilkan berat dari inputan
  function tampilkanBerat() {
    const berat = document.getElementById('inputBerat').value;
    alert('Berat yang dimasukkan: ' + berat + ' kg');
    $('#myModal').modal('hide'); // Menutup modal setelah menampilkan berat
  }
</script>

</body>
</html>
