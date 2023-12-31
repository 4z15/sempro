<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <!-- <title>Responsive Sidebar Menu</title> -->
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:600|Open+Sans:600&display=swap');

        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
        }

        .sidebar {
            position: fixed;
            width: 240px;
            left: -240px;
            height: 100%;
            background: #1e1e1e;
            transition: all .5s ease;
        }

        .sidebar header {
            font-size: 28px;
            color: white;
            line-height: 70px;
            text-align: center;
            background: #1b1b1b;
            user-select: none;
            font-family: 'Montserrat', sans-serif;
        }

        .sidebar a {
            display: block;
            height: 65px;
            width: 100%;
            color: white;
            line-height: 65px;
            padding-left: 30px;
            box-sizing: border-box;
            border-bottom: 1px solid black;
            border-top: 1px solid rgba(255, 255, 255, .1);
            border-left: 5px solid transparent;
            font-family: 'Open Sans', sans-serif;
            transition: all .5s ease;
        }

        a.active,
        a:hover {
            border-left: 5px solid #b93632;
            color: #b93632;
        }

        .sidebar a i {
            font-size: 23px;
            margin-right: 16px;
        }

        .sidebar a span {
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        #check {
            display: none;
        }

        label #btn,
        label #cancel {
            position: absolute;
            cursor: pointer;
            color: white;
            border-radius: 5px;
            border: 1px solid #262626;
            margin: 15px 30px;
            font-size: 29px;
            background: #262626;
            height: 45px;
            width: 45px;
            text-align: center;
            line-height: 45px;
            transition: all .5s ease;
        }

        label #cancel {
            opacity: 0;
            visibility: hidden;
        }

        #check:checked~.sidebar {
            left: 0;
        }

        #check:checked~label #btn {
            margin-left: 245px;
            opacity: 0;
            visibility: hidden;
        }

        #check:checked~label #cancel {
            margin-left: 245px;
            opacity: 1;
            visibility: visible;
        }

        @media(max-width : 860px) {
            .sidebar {
                height: auto;
                width: 70px;
                left: 0;
                margin: 100px 0;
            }

            header,
            #btn,
            #cancel {
                display: none;
            }

            span {
                position: absolute;
                margin-left: 23px;
                opacity: 0;
                visibility: hidden;
            }

            .sidebar a {
                height: 60px;
            }

            .sidebar a i {
                margin-left: -10px;
            }

            a:hover {
                width: 200px;
                background: inherit;
            }

            .sidebar a:hover span {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header>Edos Sayur</header>
        <a href="{{ route('home') }}" class="active">
            <i class="fas fa-qrcode"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('pesanan') }}">
            <i class="fas fa-link"></i>
            <span>Pesanan</span>
        </a>
        <a href="{{ route('pelanggan') }}">
            <i class="fas fa-stream"></i>
            <span>Pelanggan</span>
        </a>
        {{-- <a href="#">
            <i class="fas fa-calendar"></i>
            <span>Events</span>
        </a>
        <a href="#">
            <i class="far fa-question-circle"></i>
            <span>About</span>
        </a>
        <a href="#">
            <i class="fas fa-sliders-h"></i>
            <span>Services</span>
        </a>
        <a href="#">
            <i class="far fa-envelope"></i>
            <span>Contact</span>
        </a> --}}
    </div>
</body>

</html>
