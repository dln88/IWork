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
			<a class="navbar-brand" href="#">
				<img src="./img/logo.png" width="33" height="30" alt="">
			</a>
			<li class="nav-item active">
				<a class="nav-link" href="#">設計部門　山田太郎<span class="sr-only">(current)</span></a>
			</li>
		</ul>
		<ul class="navbar-nav navbar-light">
			<div style="margin-right:1rem;"><a href="{{ url()->previous() }}"><button type="button" class="btn btn-outline-secondary mb-2">一覧に戻る</button></a></div>
		</ul>
		<ul class="navbar-nav navbar-light">
			<div style="margin-right:1rem;"><a href="{{ route('login') }}"><button type="button" class="btn btn-outline-secondary mb-2">ログアウト</button></a></div>
		</ul>
	</nav>
</header>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->

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
		<!-- search result -->
		<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<i class="fas fa-list" style="margin-right:1rem;"></i>
				<h5 class="d-inline"><span class="badge badge-secondary" style="margin-right:1rem;">社員番号</span>{{ $user->emp_no }}</h5>
				<h5 class="d-inline" style="margin-left:1rem;"><span class="badge badge-secondary" style="margin-right:1rem;">部門</span>{{ $user->post_name }}</h5>
				<h5 class="d-inline" style="margin-left:1rem;"><span class="badge badge-secondary" style="margin-right:1rem;">氏名</span>{{ $user->operator_name }}</h5>

				<div class="float-right">
					<a class="btn btn-outline-primary btn-sm" href="#" role="button" data-toggle="tooltip" data-placement="bottom" title="CSV出力"><i class="fa fa-download"></i> CSV出力</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive mb-3">
					<table class="table table-hover table-bordered mb-0">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" scope="col" nowrap></th>
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
						@if (isset($monthlyReport) && count($monthlyReport) > 0)
							@foreach ($monthlyReport as $val)
							<tr class="table-danger-c">
								<td class="text-center" nowrap><button type="button" onclick="updateWorkDate($val->operator_cd, $val->calendar_ymd);"
										class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal">修正</button></td>
								<td class="text-center" nowrap>{{ $val->calendar_ymd }}</td>
								<td class="text-center" nowrap>
									@switch(\Carbon\Carbon::parse($val->calendar_ymd)->dayOfWeek)
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
								<td class="text-center" nowrap>{{ $val->start_time }}</td>
								<td class="text-center" nowrap>{{ $val->end_time }}</td>
								<td class="text-center" nowrap>{{ $val->break_time }}</td>
								<td class="text-center" nowrap>{{ $val->working_time }}</td>
								<td class="text-center" nowrap>{{ $val->over_time }}</td>
								<td class="text-center" nowrap>{{ $val->late_over_time }}</td>
								<td class="text-center" nowrap>{{ $val->interval_time }}</td>
								<td class="text-center" nowrap>{{ $val->paid_vacation_cnt }}</td>
								<td class="text-center" nowrap>{{ $val->exchange_day_cnt }}</td>
								<td class="text-center" nowrap>{{ $val->special_leave_cnt }}</td>
								<td class="text-center" nowrap>{{ $val->memo }}</td>
							</tr>	
							@endforeach
						@else
							<div class="container">
								<p>該当のデータは存在しません。</p>
							</div>
						@endif
						</tbody>
					</table>
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
					<p>設計部　山田太郎</p>　
					<h5><strong>2020/4/10</strong></h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- エラーメッセージ -->
				<p class="text-danger">開始時間は時刻形式（hh:mm）で入力してください。</p>

				<form>
					<div class="form-group">
						<label for="startTime">開始</label>
						<input type="text" class="form-control" id="startTime" placeholder="9:00">
					</div>
					<div class="form-group">
						<label for="endTime">終了</label>
						<input type="text" class="form-control" id="endTime" placeholder="18:00">
					</div>
					<div class="form-group">
						<label for="endTime">備考</label>
						<input type="text" class="form-control" id="memo" placeholder="">
					</div>
					<div class="form-group">
						<div class="custom-control custom-switch" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch1">
							<label class="custom-control-label" for="customSwitch1">休暇取消を実施する <span class="badge badge-warning">有休</span></label>
						</div>
						<div class="custom-control custom-switch" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch2">
							<label class="custom-control-label" for="customSwitch2">休暇取消を実施する <span class="badge badge-info">振休</span></label>
						</div>
						<div class="custom-control custom-switch" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch3">
							<label class="custom-control-label" for="customSwitch3">休暇取消を実施する <span class="badge badge-dark">特休</span></label>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-warning">Save</button>
			</div>
		</div>
	</div>
</div>
</div>

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