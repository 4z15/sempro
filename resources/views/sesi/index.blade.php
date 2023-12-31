@if (session('errors'))
    <div class="alert alert-danger alert-block">
        {{ session('errors') }}
    </div>
@endif

@include('template.pesan')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Login</title>
  <!-- <link rel="stylesheet" href="styles.css"> -->
  <style>
    /* Reset default margin and padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    /* Apply styles for login form */
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f2f2f2;
        background-image: url('sayur.jpg'); /* Ganti dengan path gambar sayur yang Anda inginkan */
        background-size: cover;
        background-position: center;
    }
    
    .login-container {
        width: 90%; /* Menggunakan lebar container dalam persentase untuk responsivitas */
        max-width: 400px; /* Tetapkan maksimum lebar container */
        margin: 0 auto; /* Pusatkan container */
    }
    
    .login-form {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    h2 {
        margin-bottom: 20px;
        text-align: center;
    }
    
    .input-group {
        margin-bottom: 15px;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
    }
    
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    
    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    button:hover {
        background-color: #0056b3;
    }

    /* Responsiveness using media queries */
    @media (max-width: 768px) {
        .login-container {
            width: 90%; /* Adjust width for smaller devices */
            max-width: none; /* Remove maximum width for smaller screens */
        }
    }
</style>
</head>
<body>

  <div class="login-container">
    <form id="loginForm" class="login-form" action="/admin/login" method="post">
      @csrf
      <h2>Login</h2>
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" name = "username" class="form-control"
                        value = " {{ Session::get('username') }}" autofocus>
                    @if ($errors->has('username'))
                        @foreach ($errors->get('username') as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name = "password" class="form-control">
                    @if ($errors->has('password'))
                        @foreach ($errors->get('password') as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
      </div>
      <button name="submit" type="submit" class="btn btn-primary">
        Login
    </button>
    </form>
  </div>

  <!-- <script src="script.js"></script> -->
  <script>
    // You can add JavaScript logic here if needed


  
  
  
  </script>
  
</body>
</html>
