<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', '盈源工程行')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style type="text/css">
        h2{
            font-weight: 600;
            text-align: center
        }
        .card-header{
            font-size: 17px;
        }
        .copyright {
            text-align: center;
            background-color: aqua;
            color: black;
            border: 1px solid black;
            margin: 1px auto;
            padding: 1px;
            max-width: 200px;
            margin-top:20px;
        }
    </style>
     @yield('styles')
</head>
<body>


    <main class="py-2">
        @yield('content')
        <p class="text-center copyright">CopyRight By @Yihren</p>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     @yield('script')
</body>
</html>