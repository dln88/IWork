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

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles">

    <title>i-work</title>
</head>
<body>

<!-- ----------------------------------------------------------------------------------------------------------------------- -->
<header>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
		<div class="container">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#">休暇登録 <span class="sr-only">(current)</span></a>
				</li>
			</ul>
			<ul class="navbar-nav navbar-light">
				<div style="margin-right:1rem;"><a href="{{route('person.work.dates')}}"><button type="button" class="btn btn-outline-secondary mb-2">CLOSE</button></a></div>
<!-- 				<h2> -->
<!-- 				<li class="nav-item"><a class="nav-link" href="work.html" data-toggle="tooltip" data-placement="bottom" title="閉じる"><i class="fas fa-times"></i></a></li> -->
<!-- 				</h2> -->
			</ul>
		</div>
	</nav>
</header>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->

<main role="main" class="container">

	<div class="container">
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
		<div class="container-fluid mb-3 errors" style="display: none">
			<div class="alert alert-danger alert-dismissible fade show" role="alert" >
				<div class="error-section"></div>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>

		<!-- 休暇申請 -->
		<form method="POST" action="{{route('person.add_holiday')}}" class="form-inline" style="margin-top:2rem;margin-bottom:2rem;" id="form">
			@csrf
			<div class="form-group mx-sm-1 mb-2">
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="customRadioInline1" name="type" value="1" 
						class="custom-control-input" {{ $paidLeave > 0 ? 'checked' : 'disabled' }} >
					<label class="custom-control-label" for="customRadioInline1">有休</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="customRadioInline2" name="type" value="2" 
						class="custom-control-input" {{ request()->old('type') == 2 ? 'checked' : 'null' }}>
					<label class="custom-control-label" for="customRadioInline2">振休</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="customRadioInline3" name="type" value="3" {{ $balanceLeft === 0 ? 'disabled' : '' }}
						class="custom-control-input" {{ request()->old('type') == 3 ? 'checked' : 'null' }}>
					<label class="custom-control-label" for="customRadioInline3">特休</label>
				</div>
			</div>

			<div class="form-group mx-sm-1 mb-2">
				<select class="form-control" id="exampleFormControlSelect1" name="day_type">
					<option value="1"  {{ request()->old('day_type') == 1 ? 'selected' : '' }}>全日休暇</option>
					<option value="2" {{ request()->old('day_type') == 2 ? 'selected' : '' }}>午前休暇</option>
					<option value="3" {{ request()->old('day_type') == 3 ? 'selected' : '' }}>午後休暇</option>
				</select>
			</div>

			<div class="form-group mx-sm-1 mb-2">
				<div class="input-group date datepicker" id="datepicker_1" data-target-input="nearest">
					<input type="text" autofocus name="date" class="form-control datetimepicker-input" value="{{ request()->old('date') ?? $currentDate }}" data-target="#datetimepicker"/>
					<div class="input-group-append" data-target="#datepicker_1" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
					</div>
				</div>
			</div>
			<button type="button" class="btn btn-warning mb-2" onclick="addHoliday()">申請</button>
		</form>

		<script type="text/javascript">
			function addHoliday(){
				Swal.fire({
					html: "登録休暇を実行します。<br>よろしいですか？",
					title: 'Export CSV',
					showCancelButton: true,
					confirmButtonText: 'はい',
					cancelButtonText: 'いいえ'
				}).then((result) => {
					if (result.value) {
						$('#form').submit();
					}
				})
			}
			function add() {
				$('.error-section').html('');
				$('#form').validate({
					rules: {
						'type': {
							required:true
						},
						'day_type': {
							required: true
						},
						'date' : {
							required: true,
							date: true
						},

					},
					messages: {
						'type' : 'Type is required',
						'date' : 'Date is invalid'
					},
					errorPlacement: function(error, element) {
						$('.error-section').html('');
						error.appendTo('.error-section');

						//error.appendTo('.error');
						$('.errors').show();
					},
					invalidHandler: function(event, validator) {
					},

				});
			}
		</script>
		<style type="text/css">
			.error-section {
				color: red;
			}
			 label.error{
				width: 100%;
			}

		</style>

		<hr style="margin-bottom:2rem;">

		<div class="form-group mx-sm-1 mb-2">
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inputGroup-sizing-default">有休残</span>
				</div>
				<input type="text" class="form-control text-center bg-white" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ $paidLeave ?? 0.00 }}" style="font-weight:bold;" readonly>

				<div class="input-group-prepend" style="margin-left:2rem;">
					<span class="input-group-text" id="inputGroup-sizing-default">振休残</span>
				</div>
				<input type="text" class="form-control text-center bg-white" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ $balanceLeft ?? 0.00 }}" style="font-weight:bold;" readonly>
			</div>
		</div>

		<div class="table-responsive mb-2">
			@if (isset($vacationList) && count($vacationList) > 0)
			<table class="table table-bordered mb-0 table-striped">
				<thead class="thead-light">
					<tr>
						<th class="text-center" scope="col" nowrap>取得日</th>
						<th class="text-center" scope="col" nowrap>休暇形態</th>
						<th class="text-center" scope="col" nowrap>休暇種別</th>
						<th class="text-center" scope="col" nowrap>取得状況</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($vacationList as $vacation)
					<tr>
						<td class="text-center" nowrap>{{ $vacation->acquisition_ymd }}</td>
						<td class="text-center" nowrap>{{ $vacation->holiday_form }}</td>
						<td class="text-center" nowrap>{{ $vacation->holiday_class }}</td>
						<td class="text-center" nowrap>{{ $vacation->acquisition_st }}</td>
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
		<!-- 休暇申請 -->

	</div>
</main>

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

<script type="text/javascript">
$(function() {
	$('#editBtn').click(function() {
		location.href= "agency_edit.html";
	});
});
</script>
<!--========== JavaScript ==========-->


</body>
</html>