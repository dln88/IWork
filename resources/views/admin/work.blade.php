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
				<a class="nav-link" href="#">設計部門　山田太郎<span class="sr-only">(current)</span></a>
			</li>
		</ul>
		<ul class="navbar-nav navbar-light">
			<div style="margin-right:1rem;"><a href="{{route('logout')}}"><button type="button" class="btn btn-outline-secondary mb-2">ログアウト</button></a></div>
		</ul>
	</nav>

<!-- 	</div> -->
</header>
<!-- ----------------------------------------------------------------------------------------------------------------------- -->



	<!-- search item -->
	<div class="container-fluid" style="margin-bottom:30px;">
		<div class="card">
			<div class="card-header" id="headingOne">
				<h6 class="mb-0">
					<a class="text-body" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne">
						<i class="fas fa-search">　</i>検索条件
					</a>
				</h6>
			</div>

			<div id="collapseOne" class="collapse " aria-labelledby="headingOne">
				<div class="card-body">
					<form method="get" action="{{route('admin.work_dates')}}" id="frmSearch">
						<!-- card group -->
						<div class="card" style="margin-bottom:30px;">
							<div class="card-body">

								<div class="row">
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<span class="input-group-text search_item_lbl_width" id="name">社員番号</span>
												</div>
												<input type="text" class="form-control" id="shainNo" name="code" aria-describedby="emailHelp" placeholder="" value="{{request('code', null)}}">
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<span class="input-group-text search_item_lbl_width" id="department">部門</span>
												</div>
												<select class="form-control" id="department" name="department_id">
													<option></option>
													<option value="1" {{request('department_id') == 1 ? 'selected' : ''}}>設計部</option>
													<option value="2" {{request('department_id') == 2 ? 'selected' : ''}}>工務部</option>
													<option value="3" {{request('department_id') == 3? 'selected' : ''}}>営業部</option>
													<option value="4" {{request('department_id') == 4? 'selected' : ''}}>総務部</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<span class="input-group-text search_item_lbl_width" id="name">氏名</span>
												</div>
												<input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="" value="{{request('name', null)}}">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- card group end -->
						<!-- card group -->
						<div class="card" style="margin-bottom:30px;">
							<div class="card-body">
								<div class="row" style="margin-bottom:10px;">
									<div class="col-sm-6">
										<div class="form-inline">
											<div class="form-group">
												<label class="my-1 mr-2 search_item_lbl_width" for="targetMM">対象年月</label>
												<div class="input-group date datepickerMM" id="datepicker_1" data-target-input="nearest" style="margin-right:10px;">
													<input type="text"  name="from_month" class="form-control datetimepicker-input" value="{{request('from_month', date('Y/m/d'))}}" data-target="#datetimepicker"/>
													<div class="input-group-append" data-target="#datepicker_1" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
													</div>
												</div>
												～
												<div class="input-group date datepickerMM" id="datepicker_2" data-target-input="nearest" style="margin-left:10px;">
													<input type="text"  name="to_month" class="form-control datetimepicker-input" value="{{request('from_month', date('Y/m/d'))}}" data-target="#datetimepicker"/>
													<div class="input-group-append" data-target="#datepicker_2" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="margin-bottom:10px;">
									<div class="col-sm-6">
										<div class="form-inline">
											<div class="form-group">
												<label class="my-1 mr-2 search_item_lbl_width" for="orvertime">残業時間（合計）</label>
												<div class="input-group date datepicker_time" id="datepicker_3" data-target-input="nearest" style="margin-right:10px;">
													<input type="text" name="ot_min" class="form-control datetimepicker-input" value="{{request('ot_min', null)}}" data-target="#datetimepicker"/>
													<div class="input-group-append" data-target="#datepicker_3" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="far fa-clock"></i></div>
													</div>
												</div>
												～
												<div class="input-group date datepicker_time" id="datepicker_4" data-target-input="nearest" style="margin-left:10px;">
													<input type="text" name="ot_max" class="form-control datetimepicker-input" value="{{request('ot_max', null)}}{{request('ot_min', null)}}" data-target="#datetimepicker"/>
													<div class="input-group-append" data-target="#datepicker_4" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="far fa-clock"></i></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="margin-bottom:10px;">
									<div class="col-sm-6">
										<div class="form-inline">
											<div class="form-group">
												<label class="my-1 mr-2 search_item_lbl_width" for="midnight">深夜時間（合計）</label>
												<div class="input-group date datepicker_time" id="datepicker_5" data-target-input="nearest" style="margin-right:10px;">
													<input type="text" name="on_min" class="form-control datetimepicker-input" value="{{request('on_min', null)}}" data-target="#datetimepicker"/>
													<div class="input-group-append" data-target="#datepicker_5" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="far fa-clock"></i></div>
													</div>
												</div>
												～
												<div class="input-group date datepicker_time" id="datepicker_6" data-target-input="nearest" style="margin-left:10px;">
													<input type="text" name="on_max" class="form-control datetimepicker-input" value="{{request('on_max', null)}}" data-target="#datetimepicker"/>
													<div class="input-group-append" data-target="#datepicker_6" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="far fa-clock"></i></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- card group end -->

					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- search item end -->


	<!-- search button -->
	<div class="container-fluid" style="margin-bottom:30px;">
		<div class="row">
			<div class="col-sm-12 text-right">
				<button type="button" class="btn btn-info" onclick="search()">検索</button>
				<button type="button" class="btn btn-light" onclick="reset()">クリア</button>
				<script type="text/javascript">
					function  search() {
						$('#frmSearch').submit();
					}
					function reset() {
						window.location.href = "{{route('admin.work_dates')}}";
					}
				</script>
			</div>
		</div>
	</div>

	<!-- search result -->
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<i class="fas fa-list" style="margin-right:1rem;"></i>勤怠一覧
				<div class="float-right">
					<a class="btn btn-outline-primary btn-sm" href="{{route('admin.work_csv')}}" role="button" data-toggle="tooltip" data-placement="bottom" title="CSV出力"><i class="fa fa-download"></i> CSV出力</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive mb-3">
					<table class="table table-hover table-bordered mb-0">
						@php
							$uid = '000001';
						@endphp
						<thead class="thead-dark">
							<tr>
								<th class="text-center" scope="col" nowrap></th>
								<th class="text-center" scope="col" nowrap>社員番号</th>
								<th class="text-center" scope="col" nowrap>部門</th>
								<th class="text-center" scope="col" nowrap>氏名</th>
								<th class="text-center" scope="col" nowrap>対象年月</th>
								<th class="text-center" scope="col" nowrap>実働時間（合計）</th>
								<th class="text-center" scope="col" nowrap>残業時間（合計）</th>
								<th class="text-center" scope="col" nowrap>深夜残業（合計）</th>
								<th class="text-center" scope="col" nowrap>出勤日数</th>
								<th class="text-center" scope="col" nowrap>有休</th>
								<th class="text-center" scope="col" nowrap>振休</th>
								<th class="text-center" scope="col" nowrap>特休</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>山田太郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>鈴木太郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>青木太郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>遠藤太郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>設計部</td>
								<td class="text-center" nowrap>木原太郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>工務部</td>
								<td class="text-center" nowrap>佐藤次郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>工務部</td>
								<td class="text-center" nowrap>山田次郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>工務部</td>
								<td class="text-center" nowrap>村本次郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>工務部</td>
								<td class="text-center" nowrap>中村次郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>工務部</td>
								<td class="text-center" nowrap>小川次郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>営業部</td>
								<td class="text-center" nowrap>小川三郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>営業部</td>
								<td class="text-center" nowrap>藤堂三郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>営業部</td>
								<td class="text-center" nowrap>香川三郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>営業部</td>
								<td class="text-center" nowrap>松本三郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>営業部</td>
								<td class="text-center" nowrap>浜田三郎</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>総務部</td>
								<td class="text-center" nowrap>山田四朗</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>総務部</td>
								<td class="text-center" nowrap>青山四朗</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>総務部</td>
								<td class="text-center" nowrap>田中四朗</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>総務部</td>
								<td class="text-center" nowrap>川島四朗</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>
							<tr>
								<td class="text-center" nowrap><a href="{{route('admin.work_personal', $uid)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>999999</td>
								<td class="text-center" nowrap>総務部</td>
								<td class="text-center" nowrap>立花四朗</td>
								<td class="text-center" nowrap>2020年4月</td>
								<td class="text-center" nowrap>160.00</td>
								<td class="text-center" nowrap>20.00</td>
								<td class="text-center" nowrap>5.00</td>
								<td class="text-center" nowrap>20</td>
								<td class="text-center" nowrap>2.0</td>
								<td class="text-center" nowrap>1.5</td>
								<td class="text-center" nowrap>0.0</td>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-sm-8">
						<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
							<div class="btn-group mr-2" role="group" aria-label="First group">
								<button type="button" class="btn btn-secondary"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
								<button type="button" class="btn btn-secondary">1</button>
								<button type="button" class="btn btn-secondary">2</button>
								<button type="button" class="btn btn-secondary">3</button>
								<button type="button" class="btn btn-secondary">4</button>
								<button type="button" class="btn btn-secondary">5</button>
								<button type="button" class="btn btn-secondary"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
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