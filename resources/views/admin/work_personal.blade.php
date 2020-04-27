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
				<img src="{{asset('img/logo.png')}}" width="33" height="30" alt="">
			</a>
			<li class="nav-item active">
				<a class="nav-link" href="#">{{ $departmentName ?? ''}}　{{ $operatorName ?? '' }}<span class="sr-only">(current)</span></a>
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
		@if(Session::has('errorOperator'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert" >
				{{ Session::get('errorOperator') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ session()->forget('errorOperator') }}
			</div>
		@elseif (count($errors) > 0)
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
				<h5 class="d-inline"><span class="badge badge-secondary" style="margin-right:1rem;">社員番号</span>{{ $user->emp_no ?? '' }}</h5>
				<h5 class="d-inline" style="margin-left:1rem;"><span class="badge badge-secondary" style="margin-right:1rem;">部門</span>{{ $user->post_name ?? '' }}</h5>
				<h5 class="d-inline" style="margin-left:1rem;"><span class="badge badge-secondary" style="margin-right:1rem;">氏名</span>{{ $user->operator_name ?? '' }}</h5>

				@if (!isset($monthlyReport) || (isset($monthlyReport) && count($monthlyReport) < 1) || $errors->any())
					<div class="float-right">
						<button type="button" class="btn btn-outline-primary btn-sm" disabled><i class="fa fa-download"></i> CSV出力</button>
					</div>
				@else
					<div class="float-right">
						<a class="btn btn-outline-primary btn-sm" onclick="return confirm('現在表示されている勤怠一覧を出力します。よろしいですか？')" href="{{ route('admin.work_personal_csv') }}" role="button" data-toggle="tooltip" data-placement="bottom" title="CSV出力"><i class="fa fa-download"></i> CSV出力</a>
					</div>
				@endif
			</div>
			<div class="card-body">
				<div class="table-responsive mb-3">
					@if (isset($monthlyReport) && count($monthlyReport) > 0)
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
							@foreach ($monthlyReport as $val)
							<tr>
								<td class="text-center" nowrap>
									<button type="button" onclick="checkDate('{{ $val->calendar_ymd }}')"
										class="btn btn-info btn-sm"
										data-date="{{ $val->calendar_ymd }}"
										data-starttime="{{ $val->start_time ?? '00:00' }}"
										data-endtime="{{ $val->end_time ?? '00:00' }}"
										data-memo="{{ $val->memo ?? '' }}"
										data-paid="{{ $val->paid_vacation_cnt > 0 ? 'on' : 'off' }}"
										data-exchange="{{ $val->exchange_day_cnt > 0 ? 'on' : 'off' }}"
										data-special="{{ $val->special_leave_cnt > 0 ? 'on' : 'off' }}"
										data-toggle="modal"
										data-target="#modal">
										修正
									</button>
								</td>
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
								<td class="text-center" nowrap>{{ $val->start_time ?? '00:00' }}</td>
								<td class="text-center" nowrap>{{ $val->end_time ?? '00:00' }}</td>
								<td class="text-center" nowrap>{{ $val->break_time ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->working_time ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->over_time ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->late_over_time ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->interval_time ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->paid_vacation_cnt ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->exchange_day_cnt ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->special_leave_cnt ?? number_format(0, 2) }}</td>
								<td class="text-center" nowrap>{{ $val->memo ?? ''}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						<div class="alert alert-danger">
							{{ config('messages.000003') }}
						</div>
					@endif
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
					<p>{{ $departmentName ?? ''}}　{{ $operatorName ?? '' }}</p>　
					<h5><strong id="date" name='date'></strong></h5>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.work_personal.update', request()->id) }}" id="update" method="post">
				{{ csrf_field() }}
				<div class="modal-body">
					<!-- エラーメッセージ -->
					<input type="hidden" name="date" id='target-date'/>
					<p class="text-danger" id="text-message">開始時間は時刻形式（hh:mm）で入力してください。</p>
					<div class="form-group" id="start-time-div">
						<label for="startTime">開始</label>
						<input type="text" class="form-control" id="startTime" name='start'>
					</div>
					<div class="form-group" id="end-time-div">
						<label for="endTime">終了</label>
						<input type="text" class="form-control" id="endTime" name='end'>
					</div>
					<div class="form-group" id="memo-div">
						<label for="endTime">備考</label>
						<input type="text" class="form-control" id="memo" name='memo'>
					</div>
					<div class="form-group">
						<div class="custom-control custom-switch" id="customSwitchPaid"  style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input"  id="customSwitch1" name='paid'>
							<label class="custom-control-label" for="customSwitch1">休暇取消を実施する <span class="badge badge-warning">有休</span></label>
						</div>
						<div class="custom-control custom-switch" id="customSwitchExchange" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch2" name='exchange'>
							<label class="custom-control-label" for="customSwitch2">休暇取消を実施する <span class="badge badge-info">振休</span></label>
						</div>
						<div class="custom-control custom-switch" id="customSwitchHoliday" style="margin-bottom:0.5rem;">
							<input type="checkbox" class="custom-control-input" id="customSwitch3" name='special'>
							<label class="custom-control-label" for="customSwitch3">休暇取消を実施する <span class="badge badge-dark">特休</span></label>
						</div>
					</div>
				</div>
				<div class="modal-footer footer-div">
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
					<button type="button" id="close-button" class="btn btn-warning" onclick="save()">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>

<footer>
  <p class="small text-center"></p>
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

<script>
	$('#modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var date = button.data('date')
		var start = button.data('starttime')
		var end = button.data('endtime')
		var memo = button.data('memo')
		var paid = button.data('paid')
		var exchange = button.data('exchange')
		var special = button.data('special')

		$('#date').html(date);
		var modal = $(this)
		modal.find('.modal-body #startTime').val(start)
		modal.find('.modal-body #endTime').val(end)
		modal.find('.modal-body #memo').val(memo)
		modal.find('.modal-body #target-date').val(date)

		if (paid === 'on') {
			$('#customSwitch1').attr('checked', true)
		} else {
			$('#customSwitchPaid').attr('style', 'display: none;')
		}
		if (exchange === 'on') {
			$('#customSwitch2').attr('checked', true)
		} else {
			$('#customSwitchExchange').attr('style', 'display: none;')
		}
		if (special === 'on') {
			$('#customSwitch3').attr('checked', true)
		} else {
			$('#customSwitchHoliday').attr('style', 'display: none;')
		}
	});
	function save() {
		$('#update').submit();
	}
	function checkDate(targetDate) {
		var today = new Date().toISOString().slice(0, 10);
		if (targetDate > today) {
			$( "#text-message").text('未来日付の編集はできません。')
			$('#start-time-div').attr('style', 'visibility: hidden;')
			$('#end-time-div').attr('style', 'visibility: hidden;')
			$('#memo-div').attr('style', 'visibility: hidden;')
			$('#customSwitchPaid').attr('style', 'visibility: hidden;')
			$('#customSwitchExchange').attr('style', 'visibility: hidden;')
			$('#customSwitchHoliday').attr('style', 'visibility: hidden;')
			$('#close-button').hide();
		} else {
			$( "#text-message").text('開始時間は時刻形式（hh:mm）で入力してください。')
			$('#start-time-div').attr('style', 'visibility: visible;')
			$('#end-time-div').attr('style', 'visibility: visible;')
			$('#memo-div').attr('style', 'visibility: visible;')
			$('#customSwitchPaid').attr('style', 'visibility: visible;')
			$('#customSwitchExchange').attr('style', 'visibility: visible;')
			$('#customSwitchHoliday').attr('style', 'visibility: visible;')
			$('#close-button').show();
		}
	}
</script>

<!--========== JavaScript ==========-->

</body>
</html>