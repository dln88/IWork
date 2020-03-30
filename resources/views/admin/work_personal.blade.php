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
	<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>
	<title>i-work</title>
</head>
<body>

<!-- ----------------------------------------------------------------------------------------------------------------------- -->
<header>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
		<ul class="navbar-nav mr-auto">
			<a class="navbar-brand" href="#">
				<img src="{{asset('/img/logo.png')}}" width="33" height="30" alt="">
			</a>
			<li class="nav-item active">
				<a class="nav-link" href="#">設計部門　山田太郎<span class="sr-only">(current)</span></a>
			</li>
		</ul>
		<ul class="navbar-nav navbar-light">
			<div style="margin-right:1rem;"><a href="{{route('admin.work_dates')}}"><button type="button" class="btn btn-outline-secondary mb-2">一覧に戻る</button></a></div>
		</ul>
		<ul class="navbar-nav navbar-light">
			<div style="margin-right:1rem;"><a href="{{route('logout')}}"><button type="button" class="btn btn-outline-secondary mb-2">ログアウト</button></a></div>
		</ul>
	</nav>

	<!-- drawer -->
<!-- 	<div class="zdo_drawer_menu left"> -->
<!-- 		<div class="zdo_drawer_bg"></div> -->
<!-- 		<button type="button" class="zdo_drawer_button"> -->
<!-- 			<span class="zdo_drawer_bar zdo_drawer_bar1"></span> -->
<!-- 			<span class="zdo_drawer_bar zdo_drawer_bar2"></span> -->
<!-- 			<span class="zdo_drawer_bar zdo_drawer_bar3"></span> -->
<!-- 			<span class="zdo_drawer_menu_text zdo_drawer_text">MENU</span> -->
<!-- 			<span class="zdo_drawer_close zdo_drawer_text">CLOSE</span> -->
<!-- 		</button> -->
<!-- 		<nav class="zdo_drawer_nav_wrapper"> -->
<!-- 			<ul class="zdo_drawer_nav"> -->
<!-- 				<li><span class="text-secondary" style="font-size: 1rem;">設計部門　山田太郎</span></li> -->
<!-- 				<li><a href="work_holiday.html">休暇登録</a></li> -->
<!-- 				<li><a href="#">メニュー2</a></li> -->
<!-- 				<li><a href="#">メニュー3</a></li> -->
<!-- 				<li><a href="#">メニュー4</a></li> -->
<!-- 				<li><a href="#">メニュー5</a></li> -->
<!-- 				<li><a href="#">メニュー6</a></li> -->
<!-- 			</ul> -->
<!-- 		</nav> -->
<!-- 	</div> -->
</header>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->

<!-- <main role="main" class="container"> -->

	<!-- search result -->
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<i class="fas fa-list" style="margin-right:1rem;"></i>月報
				<div class="float-right">
						<a class="btn btn-outline-primary btn-sm" href="{{route('admin.personal_csv', $uid)}}"  target="_blank" role="button" data-toggle="tooltip" data-placement="bottom" title="CSV出力"><i class="fa fa-download"></i> CSV出力</a>

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive mb-3">
					<table class="table table-hover table-bordered mb-0">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" scope="col" nowrap></th>
								<th class="text-center" scope="col" nowrap>社員番号</th>
								<th class="text-center" scope="col" nowrap>部門</th>
								<th class="text-center" scope="col" nowrap>氏名</th>
								<th class="text-center" scope="col" nowrap>日付</th>
								<th class="text-center" scope="col" nowrap>曜日</th>
								<th class="text-center" scope="col" nowrap>開始</th>
								<th class="text-center" scope="col" nowrap>終了</th>
								<th class="text-center" scope="col" nowrap>休憩時間</th>
								<th class="text-center" scope="col" nowrap>実働時間　（00.00）</th>
								<th class="text-center" scope="col" nowrap>残業時間　（00.00）</th>
								<th class="text-center" scope="col" nowrap>深夜残業　（00.00）</th>
								<th class="text-center" scope="col" nowrap>インターバル</th>
								<th class="text-center" scope="col" nowrap>有休</th>
								<th class="text-center" scope="col" nowrap>振休</th>
								<th class="text-center" scope="col" nowrap>特休</th>
								<th class="text-center" scope="col" nowrap>備考</th>
							</tr>
						</thead>
						<tbody>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/1</td>
								<td class="text-center" nowrap>水</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/2</td>
								<td class="text-center" nowrap>木</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/3</td>
								<td class="text-center" nowrap>金</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/4</td>
								<td class="text-center" nowrap>土</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/5</td>
								<td class="text-center" nowrap>日</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/6</td>
								<td class="text-center" nowrap>月</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/7</td>
								<td class="text-center" nowrap>火</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/8</td>
								<td class="text-center" nowrap>水</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/9</td>
								<td class="text-center" nowrap>木</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/10</td>
								<td class="text-center" nowrap>金</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/11</td>
								<td class="text-center" nowrap>土</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/12</td>
								<td class="text-center" nowrap>日</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/13</td>
								<td class="text-center" nowrap>月</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/14</td>
								<td class="text-center" nowrap>火</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/15</td>
								<td class="text-center" nowrap>水</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/16</td>
								<td class="text-center" nowrap>木</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/17</td>
								<td class="text-center" nowrap>金</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/18</td>
								<td class="text-center" nowrap>土</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/19</td>
								<td class="text-center" nowrap>日</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/20</td>
								<td class="text-center" nowrap>月</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/21</td>
								<td class="text-center" nowrap>火</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/22</td>
								<td class="text-center" nowrap>水</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/23</td>
								<td class="text-center" nowrap>木</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/24</td>
								<td class="text-center" nowrap>金</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/25</td>
								<td class="text-center" nowrap>土</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/26</td>
								<td class="text-center" nowrap>日</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/27</td>
								<td class="text-center" nowrap>月</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/28</td>
								<td class="text-center" nowrap>火</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/29</td>
								<td class="text-center" nowrap>水</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><button type="button" class="btn btn-info btn-sm btn-edit" data-id="20200401" id="btnEdit" >修正</button></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020/4/30</td>
								<td class="text-center" nowrap>木</td>
								<td class="text-center" nowrap>9:00</td>
								<td class="text-center" nowrap>18:00</td>
								<td class="text-center" nowrap>1.00</td>
								<td class="text-center" nowrap>8.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>0.00</td>
								<td class="text-center" nowrap>15.00</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>0.0</td>
								<td class="text-center" nowrap>○○○○○○○○○○○○○○○○</td>
							</tr>
						</tbody>
					</table>
					<script type="text/javascript">
						$('.btn-edit').click(function () {
							var date = $(this).data('id');
							console.log(date);
							$.ajax({
								url: '/admin/work/personal/ajax_load/{{$uid}}/' + date ,
								type: 'get',
								dataType: "json",
								data: {
									date: date,
									uid: '{{$uid}}'
								},
								success: function(response){
									console.log(response);
									$('#labelDate').html(response.data.work_date);
									$('#labelName').html(response.data.name);
									$('#txtDate').val(response.data.work_date);
									$('#startTime').val(response.data.start_time);
									$('#endTime').val(response.data.end_time);
									$('#memo').val(response.data.break_time);
									$('#modal').modal('show');
								}
							});
						})
						$.validator.addMethod("time24", function(value, element) {
							if (/^([0-9]{1}|[01]?[0-9]{2}|2[0-3]{2}):[0-5][0-9]$/.test(value)) return true;
							return false;
						}, 'Time format is not right');

						function save() {
							$("#frmEdit").validate({
								// Specify validation rules
								rules: {
									// The key name on the left side is the name attribute
									// of an input field. Validation rules are defined
									// on the right side
									startTime: {
										required: true,
										pattern : '([0-9]{1}|[01]?[0-9]{2}|2[0-3]{2}):[0-5][0-9]'
									},
									endTime: {
										required: true,
										pattern : '([0-9]{1}|[01]?[0-9]{2}|2[0-3]{2}):[0-5][0-9]'
									},
									breakTime: {
										required: true,
										pattern : '([0-9]{1}|[01]?[0-9]{2}|2[0-3]{2}):[0-5][0-9]'
									},
								},
								// Specify validation error messages
								messages: {

								},
								invalidHandler: function(event, validator) {
									// 'this' refers to the form
									// var errors = validator.numberOfInvalids();
									// if (errors) {
									// 	var message = errors == 1
									// 			? 'You missed 1 field. It has been highlighted'
									// 			: 'You missed ' + errors + ' fields. They have been highlighted';
									// 	console.log(message);
									// 	$("div.error span").html(message);
									// 	$("div.error").show();
									// } else {
									// 	$("div.error").hide();
									// }
								},
								// Make sure the form is submitted to the destination defined
								// in the "action" attribute of the form when valid
								success: function(form) {
									//$("#frmEdit").submit();
									// $('#modal').modal('hide');

								},
								submitHandler: function(form) {

								}
							});

							if ($("#frmEdit").valid()) {
								$.ajax({
									url: '{{route('admin.ajax.update_personal_date', $uid)}}' ,
									type: 'post',
									dataType: "json",
									data: $('#frmEdit').serialize(),
									success: function(response){
										console.log(response);
										$('#modal').modal('hide');
										location.reload();
									}
								});
							}
						}
					</script>
				</div>
			</div>
		</div>
	</div>
	<!-- search result end -->

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="exampleModalLabel">
					<p>設計部　<span id="labelName">山田太郎</span></p>　
					<h5><strong id="labelDate">2020/4/10</strong></h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- エラーメッセージ -->
				<p class="text-danger">開始時間は時刻形式（hh:mm）で入力してください。</p>

				<form id="frmEdit" method="POST">
					@csrf
					<input type="hidden" name="work_date" id="txtDate" value="">
					<div class="form-group">
						<label for="startTime">開始</label>
						<input type="text" class="form-control" id="startTime" name="startTime" placeholder="9:00"  >
					</div>
					<div class="form-group">
						<label for="endTime">終了</label>
						<input type="text" class="form-control" id="endTime" name="endTime" placeholder="18:00">
					</div>
					<div class="form-group">
						<label for="endTime">備考</label>
						<input type="text" class="form-control" id="memo" name="breakTime" placeholder="" >
					</div>
					<div class="form-group">
						<div class="custom-control custom-switch" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_closed_date">
							<label class="custom-control-label" for="customSwitch1">休暇取消を実施する <span class="badge badge-warning">有休</span></label>
						</div>
						<div class="custom-control custom-switch" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch2" name="is_rest_date">
							<label class="custom-control-label" for="customSwitch2">休暇取消を実施する <span class="badge badge-info">振休</span></label>
						</div>
						<div class="custom-control custom-switch" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch3" name="is_special_date">
							<label class="custom-control-label" for="customSwitch3">休暇取消を実施する <span class="badge badge-dark">特休</span></label>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-warning" onclick="save()">Save</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
<style>
	.error {
		color: red;
	}
</style>
<!-- </main> -->

<footer>
  <p class="small text-center">&copy; 2020 by <a href="#">xxxxxxxxxxxxxxx</a> v1.0.0</p>
</footer>


<!--========== JavaScript ==========-->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js" type="text/javascript"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/zdo_drawer_menu.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('js/locale/ja.js')}}"></script>
<script src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
<!--========== JavaScript ==========-->

</body>
</html>