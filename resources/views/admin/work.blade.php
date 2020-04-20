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
					<form method="get" action="{{ route('admin.search_work_dates') }}" id="frmSearch">
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
												<input type="text" class="form-control" id="shainNo" name="emp_num" aria-describedby="emailHelp" placeholder="" value="{{request('code', null)}}">
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
													@if (isset($comboBoxChoice) && count($comboBoxChoice) > 0)
														@foreach ($comboBoxChoice as $postCd)
															<option value="{{ $postCd->post_cd }}">{{ $postCd->post_name }}</option>
														@endforeach
													@endif
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
													<input type="text"  name="from_month" class="form-control datetimepicker-input" value="{{request('from_month', date('Y/m'))}}" data-target="#datetimepicker"/>
													<div class="input-group-append" data-target="#datepicker_1" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
													</div>
												</div>
												～
												<div class="input-group date datepickerMM" id="datepicker_2" data-target-input="nearest" style="margin-left:10px;">
													<input type="text"  name="to_month" class="form-control datetimepicker-input" value="{{request('to_month', date('Y/m'))}}" data-target="#datetimepicker"/>
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
				<a href="{{ route('admin.work_dates') }}">
					<button type="button" class="btn btn-light" onclick="return confirm('検索条件をクリアします。よろしいですか？')">クリア</button>
				</a>
				<script type="text/javascript">
					function  search() {
						$('#frmSearch').submit();
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
					<a class="btn btn-outline-primary btn-sm" onclick="return confirm('現在表示されている勤怠一覧を出力します。よろしいですか？')" href="{{ route('admin.work_csv') }}" role="button" data-toggle="tooltip" data-placement="bottom" title="CSV出力"><i class="fa fa-download"></i> CSV出力</a>
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
						@if (isset($timeList) && count($timeList) > 0)
							@foreach ($timeList as $val)
							<tr>
								<td class="text-center" nowrap><a href="{{ route('admin.work_personal', $val->operator_cd)}}" class="alert-link"><i class="fas fa-external-link-alt"></i></a></td>
								<td class="text-center" nowrap>{{ $val->emp_no }}</td>
								<td class="text-center" nowrap>{{ $val->post_name }}</td>
								<td class="text-center" nowrap>{{ $val->operator_name }}</td>
								<td class="text-center" nowrap>{{ \Carbon\Carbon::parse($val->target_ym)->format('Y年m月') }}</td>
								<td class="text-center" nowrap>{{ $val->sum_working_time }}</td>
								<td class="text-center" nowrap>{{ $val->sum_over_time }}</td>
								<td class="text-center" nowrap>{{ $val->late_over_time }}</td>
								<td class="text-center" nowrap>{{ $val->att_date }}</td>
								<td class="text-center" nowrap>{{ $val->paid_vacation_cnt }}</td>
								<td class="text-center" nowrap>{{ $val->exchange_day_cnt }}</td>
								<td class="text-center" nowrap>{{ $val->special_leave_cnt }}</td>
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
			<div class="card-footer">
				<div class="row">
					<div class="col-sm-8">
						<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
							<form action="{{ route('admin.work_dates') }}" method="get">
							<div class="btn-group mr-2" role="group" aria-label="First group">
									<button type="submit" name="page" value="{{ $page > 1 ? $page - 1 : 1 }}" class="btn btn-secondary"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
									<button type="submit" name="page" value="1" class="btn btn-secondary">1</button>
									<button type="submit" name="page" value="2" class="btn btn-secondary">2</button>
									<button type="submit" name="page" value="3" class="btn btn-secondary">3</button>
									<button type="submit" name="page" value="4" class="btn btn-secondary">4</button>
									<button type="submit" name="page" value="5" class="btn btn-secondary">5</button>
									<button type="submit" name="page" value="{{ $page + 1 }}" class="btn btn-secondary"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
								</div>
							</form>
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