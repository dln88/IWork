<!doctype html>
<html lang="jp">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="content-language" content="ja">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1">

    <!--========== CSS ==========-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome-all.min.css">
    <!-- drawer -->
    <link rel="stylesheet" href="css/zdo_drawer_menu.css">
    <!-- datepicker -->
    <link rel="stylesheet" href="css/tempusdominus-bootstrap-4.min.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="shortcut icon" href="img/favicon.ico">
    <!--========== CSS ==========-->

    <title>i-work</title>
</head>
<body>

<!-- ----------------------------------------------------------------------------------------------------------------------- -->
<header>
    <!-- Navbar -->
    @section('nav')

    @show
</header>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->

@yield('content')


<footer>
    <p class="small text-center">&copy; 2020 by <a href="#">xxxxxxxxxxxxxxx</a> v1.0.0</p>
</footer>


<!--========== JavaScript ==========-->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/zdo_drawer_menu.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('js/locale/ja.js')}}"></script>
<script src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
<!--========== JavaScript ==========-->

</body>
</html>