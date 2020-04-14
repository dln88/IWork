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
					<input type="radio" id="customRadioInline1" name="type" value="1" class="custom-control-input" checked="checked">
					<label class="custom-control-label" for="customRadioInline1">有休</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="customRadioInline2" name="type" value="2" class="custom-control-input">
					<label class="custom-control-label" for="customRadioInline2">振休</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="customRadioInline3" name="type" value="3" class="custom-control-input">
					<label class="custom-control-label" for="customRadioInline3">特休</label>
				</div>
			</div>

			<div class="form-group mx-sm-1 mb-2">
				<select class="form-control" id="exampleFormControlSelect1" name="day_type">
					<option value="1">全日休暇</option>
					<option value="2">午前休暇</option>
					<option value="3">午後休暇</option>
				</select>
			</div>

			<div class="form-group mx-sm-1 mb-2">
				<div class="input-group date datepicker" id="datepicker_1" data-target-input="nearest">
					<input type="text" name="date" class="form-control datetimepicker-input" value="2020/01/01" data-target="#datetimepicker"/>
					<div class="input-group-append" data-target="#datepicker_1" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-warning mb-2" onclick="return confirm('登録休暇を実行します。よろしいですか？')">申請</button>
		</form>

		<script type="text/javascript">
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
				<input type="text" class="form-control text-center bg-white" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ $paidVacationDays[0]->grant_days ?? 0.00 }}" style="font-weight:bold;" readonly>

				<div class="input-group-prepend" style="margin-left:2rem;">
					<span class="input-group-text" id="inputGroup-sizing-default">振休残</span>
				</div>
				<input type="text" class="form-control text-center bg-white" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ $balanceLeft ?? 0.00 }}" style="font-weight:bold;" readonly>
			</div>
		</div>

		@if (isset($vacationList) && count($vacationList) > 0)
		<div class="table-responsive mb-2">
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
						<td class="text-center" nowrap>有休</td>
						<td class="text-center" nowrap>午前休暇</td>
						<td class="text-center" nowrap>{{ $vacation->acquisition_st }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@else
			<div class="container">
				<p>該当のデータは存在しません。</p>
			</div>
		@endif
		<!-- 休暇申請 -->

	</div>
</main>

<footer>
  <p class="small text-center">&copy; 2020 by <a href="#">xxxxxxxxxxxxxxx</a> v1.0.0</p>
</footer>



<!--========== JavaScript ==========-->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/zdo_drawer_menu.js"></script>
<script src="js/moment.js"></script>
<script src="js/locale/ja.js"></script>
<script src="js/tempusdominus-bootstrap-4.min.js"></script>
<script src="js/common.js"></script>
<!--========== JavaScript ==========-->
<script type="text/javascript">
$(function() {
	$('#editBtn').click(function() {
		location.href= "agency_edit.html";
	});
});
</script>
</body>
</html>