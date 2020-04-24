<!DOCTYPE html>
<html lang="ja">
<head>
    <title>i-work</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="content-language" content="ja">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1">

    <!--========== CSS ==========-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{asset('css/font-awesome-all.min.css')}}">
    <!-- drawer -->
    <link rel="stylesheet" href="{{asset('css/zdo_drawer_menu.css')}}">
    <!-- datepicker -->
    <link rel="stylesheet" href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    <!--========== CSS ==========-->

    <style>
        body {
            background-color: #f0f8ff;
        }
        .div-login {
            margin-top:100px;
            margin-bottom:50px;
        }
        .form-signin {
            max-width: 360px;
            margin: 0 auto;
        }
        .input-panel {
            margin-top:5rem;
            padding: 20px 20px 10px 20px;
            background-color: #f5f5f5;
        }
        .reminder {
            margin-top:30px;
        }
    </style>

</head>
<body>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->
<div class="container">
    <div class="mx-auto" style="width:20rem;">
        <img src="{{asset('/img/logo.png')}}" class="img-fluid" alt="Responsive image">
    </div>
</div>

<div class="container div-login">
    <form method="post" class="form-signin" id="frmLogin" action="{{ route('login.post') }}">
        @csrf
        @if (Session::has('permission_error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 30rem;">
        管理者権限がありません。
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @elseif ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 30rem;">
            {{ $errors->first() }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        
        <div class="card input-panel" style="width: 30rem;">
            <div class="card-body">
                <!-- ログインID -->
                <div class="form-group">
                    <input type="text" tabindex="1" {{ !$errors->has('password') || $errors->has('user_id') ? 'autofocus' : '' }} name="user_id"  value="{{ old('user_id') ??  Session::get('user_id') }}" class="form-control input-lg" label="ログインID" placeholder="ログインID" maxlength="200"></input>
                </div>
                <!-- パスワード -->
                <div class="form-group">
                    <input type="password" tabindex="2" {{ !$errors->has('user_id') ? 'autofocus' : '' }}  name="password" class="form-control input-lg" label="パスワード" placeholder="パスワード" maxlength="30" value="{{ old('password') ?? request()->get('password') }}"></input>
                </div>
                <!-- ボタン -->
                <button class="btn btn-lg btn-info btn-block" tabindex="3" type="submit" onclick="login()" >
                    ログイン
                </button>
                <button class="btn btn-lg btn-outline-info btn-block" tabindex="4" type="button" onclick="loginAdmin();" >
                    管理者としてログイン
                </button>
            </div>
        </div>

    </form>
    <script type="text/javascript">
        function login() {
            $('#frmLogin').submit();
        }

        function loginAdmin() {
            $('#frmLogin').attr('action', "{{route('admin.login.post')}}");
            $('#frmLogin').submit();
        }
    </script>
</div>

<footer>
    <div class="container">
        <p class="small text-center text-secondary">&copy; 2020 by <a href="#">xxxxxxxxxxxxxxx</a> v1.0.0</p>
    </div>
</footer>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->

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
