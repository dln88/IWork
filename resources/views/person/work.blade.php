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

    <title>i-work</title>
</head>
<body>

<!-- ----------------------------------------------------------------------------------------------------------------------- -->
<header>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
		<ul class="navbar-nav mr-auto">
			<div class="row" style="margin-left:1rem;">
				<a class="navbar-brand" href="#">
					<img src="{{asset('img/logo.png')}}" width="35" height="30" alt="">
				</a>
				<li class="nav-item active">
					<a class="nav-link" href="#">設計部門　山田太郎<span class="sr-only">(current)</span></a>
				</li>
			</div>
		</ul>
		<ul class="navbar-nav navbar-light">
			<div class="d-none d-md-block">
				<div style="margin-right:1rem;"><a href="{{route('person.holiday')}}"><button type="button" class="btn btn-outline-success mb-2">休暇登録</button></a></div>
			</div>
			<div style="margin-right:1rem;"><a href="{{route('logout')}}"><button type="button" class="btn btn-outline-secondary mb-2">ログアウト</button></a></div>
<!-- 			<li class="nav-item"><a class="nav-link" href="login.html" data-toggle="tooltip" data-placement="bottom" title="ログアウト"><i class="fas fa-sign-out-alt"></i></a></li> -->
		</ul>
	</nav>
</header>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->

<!-- <main role="main" class="container"> -->

	<!-- alert start -->
	@if (isset($overTime) && $overTime === true)
	<div class="container-fluid mb-3">
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong><i class="fas fa-exclamation-triangle"></i></strong>　残業時間に注意してください。
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			
		</div>
	</div>
	@endif
	<!-- alert end -->
	<div class="container-fluid mb-3">
		@if (Session::get('message'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{Session::get('message')}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
		@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible fade show" role="alert" >
				@foreach($errors->all() as $error)
					{{ $error }}
				@endforeach
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
	</div>

<!-- for smart phone -->
	<div class="container-fluid mb-3">
		<div class="mx-auto">
			<div class="col-12 d-md-none">
				<div class="card text-center">
					<div class="card-body">
						<div class="input-group date datepicker_time" id="datepicker_1" data-target-input="nearest" style="margin-right:10px;">
							<input name="att_time" novalidate type="text" class="form-control datetimepicker-input text-center" value="{{ $intialTime['start_time'] }}" data-target="#datetimepicker"/>
							<div class="input-group-append" data-target="#datepicker_1" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="far fa-clock"></i></div>
							</div>
						</div>
						<button class="btn btn-info btn-block btn-lg" type="button" style="margin-top:1rem;" onclick="window.location = '{{ route('person.work.register_attendance_time') }}'">出勤</button>
					</div>
				</div>
			</div>
		</div>
		<div class="mx-auto" style="margin-top:3rem;">
			<div class="col-12 d-md-none">
				<div class="card text-center">
					<div class="card-body">
						<div class="input-group date datepicker_time" id="datepicker_2" data-target-input="nearest" style="margin-right:10px;">
							<input name="end_time" novalidate type="text" class="form-control datetimepicker-input text-center" value="{{ $intialTime['end_time'] }}" data-target="#datetimepicker"/>
							<div class="input-group-append" data-target="#datepicker_2" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="far fa-clock"></i></div>
							</div>
						</div>
						<button class="btn btn-warning btn-block btn-lg" type="button" style="margin-top:1rem;" onclick="window.location='{{ route('person.work.register_leave_time') }}'">退勤</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- for smart phone end -->

	<!-- search button -->
	<div class="d-none d-md-block">
		<div class="container-fluid" style="margin-bottom:1rem;">
			<div class="row">
				<div class="col-sm-3">
					<form method="post" novalidate action="{{route('person.work.register_attendance_time')}}">
						@csrf
						<div class="input-group" style="margin-bottom:1rem;">
							<label for="inputStart" class="sr-only">出勤時間</label>
							<input type="text" class="form-control text-center" value="{{ $intialTime['start_time'] }}" id="inputStart" name="start_time" placeholder="{{ $intialTime['start_time'] }}" required>
							<div class="input-group-append" id="button-addon4">
								<button class="btn btn-info" type="submit">出勤</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-sm-3">
					<form method="post" novalidate action="{{route('person.work.register_leave_time')}}">
						@csrf
						<div class="input-group" style="margin-bottom:1rem;">
							<label for="inputEnd" class="sr-only">退勤時間</label>
							<input type="text" class="form-control text-center" value="{{ $intialTime['end_time'] }}" id="inputEnd"  name="end_time" placeholder="{{ $intialTime['end_time'] }}" required>
							<div class="input-group-append" id="button-addon4">
								<button class="btn btn-warning" type="submit">退勤</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	
	<!-- search result -->
	<div class="d-none d-md-block">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<i class="fas fa-list" style="margin-right:1rem;"></i>勤怠一覧
				</div>
				<div class="card-body">
					<div class="table-responsive mb-3">
					<table class="table table-hover table-bordered mb-0">
						@if (count($workDates) > 0)
							<thead class="thead-dark">
								<tr>
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
								</tr>
							</thead>
							<tbody>
								@foreach ($workDates as $workDate)
									<tr>
										<td class="text-center" nowrap>{{ $workDate->calendar_ymd }}</td>
										<td class="text-center" nowrap>
										@switch(\Carbon\Carbon::parse($workDate->calendar_ymd)->dayOfWeek)
											@case(1)
												月
												@break
											@case(2)
												火
												@break
											@case(3)
												水
												@break
											@case(4)
												木
												@break
											@case(5)
												金
												@break
											@case(6)
												土
												@break
											@default
												日
										@endswitch
										</td>
										<td class="text-center" nowrap>{{ isset($workDate->start_time) ? \Carbon\Carbon::parse($workDate->start_time)->format('H:i') : number_format(0, 2) }}</td>
										<td class="text-center" nowrap>{{ isset($workDate->end_time) ? $workDate->end_time : number_format(0, 2) }}</td>
										<td class="text-center" nowrap>{{ $workDate->break_time ?? number_format(00, 2) }}</td>
										<td class="text-center" nowrap>{{ $workDate->working_time ?? number_format(00, 2) }}</td>
										<td class="text-center" nowrap>{{ $workDate->over_time ?? number_format(00, 2) }}</td>
										<td class="text-center" nowrap>{{ $workDate->late_over_time ?? number_format(00, 2) }}</td>
										<td class="text-center" nowrap>{{ $workDate->interval_time ?? number_format(00, 2) }}</td>
										<td class="text-center" nowrap>{{ $workDate->paid_vacation_cnt }}</td>
										<td class="text-center" nowrap>{{ $workDate->exchange_day_cnt }}</td>
										<td class="text-center" nowrap>{{ $workDate->special_leave_cnt }}</td>
									</tr>
								@endforeach
							</tbody>
							@else
								該当のデータは存在しません。
							@endif
						</table>
					</div>
				</div>
				
				<div class="card-footer">
					<div class="row">
						<div class="col-sm-8">
							<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
								<div class="btn-group mr-2" role="group" aria-label="First group">
									<button type="button" class="btn btn-secondary" onclick="window.location='{{ route('person.work.dates', ['yearMonth' => \Carbon\Carbon::create(\Illuminate\Support\Str::substr($yearMonth, 0, 4),\Illuminate\Support\Str::substr($yearMonth, 4, 2))->subMonth()->format('Ym')]) }}'"><</button>
									<button type="button" class="btn btn-secondary active" onclick="window.location='{{ route('person.work.dates') }}'">当月</button>
									<button type="button" class="btn btn-secondary" onclick="window.location='{{ route('person.work.dates', ['yearMonth' => \Carbon\Carbon::create(\Illuminate\Support\Str::substr($yearMonth, 0, 4),\Illuminate\Support\Str::substr($yearMonth, 4, 2))->addMonth()->format('Ym')]) }}'">></button>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- search result end -->

<!-- </main> -->

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