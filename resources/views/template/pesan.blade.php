<head>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-zd5Mk2O5lI0Z8W8YcNXajwE0qcYzE9lGJSfQ8awF9if6FqV64jmvNdFJ0VTI2v8o" crossorigin="anonymous"></script>

</head>
@if (session('success'))
<div class="alert alert-success alert-dismissible">
  {{ session('success') }}
</div>
@endif

 {{-- @if ($errors->any())
  <div class="alert alert-danger">
    Validation Error!
  </div>
  @endif --}}
{{-- @if (session('errors'))
<div class="alert alert-danger alert-block">
  {{ session('errors') }}
</div>
@endif --}}

{{-- @foreach ($errors->get('berat_sayurs.*') as $error)
    <div class="alert alert-danger alert-block">
      {{ $error[0] }}
    </div>
@endforeach --}}

{{-- @foreach ($errors->get('harga_sayurs.*') as $error)
    <div class="alert alert-danger alert-block">{{ $error[0] }}</div>
@endforeach --}}

{{-- @foreach ($errors->get('nama') as $error)
    <div class="alert alert-danger">{{ $error }}</div>
@endforeach --}}

{{-- @foreach ($errors->get('tgl') as $error)
    <div class="alert alert-danger">{{ $error }}</div>
@endforeach --}}

{{-- @foreach ($errors->get('telp') as $error)
    <div class="alert alert-danger">{{ $error }}</div>
@endforeach --}}

{{-- @foreach ($errors->get('total') as $error)
    <div class="alert alert-danger">{{ $error }}</div>
@endforeach --}}