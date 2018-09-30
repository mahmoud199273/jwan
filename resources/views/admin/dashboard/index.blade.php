@extends('admin.layouts.index_layout',['title' => __('admin.dashboard')])


@section('content')

<div class="row">
	<div class="col-lg-12">

			<!--begin:: Widgets/Quick Stats-->
			<div class="row m-row--full-height">
				<div class="col-sm-12 col-md-12 col-lg-6">
					<div class="m-portlet m-portlet--half-height m-portlet--border-bottom-brand ">
						<div class="m-portlet__body">
							<div class="m-widget26">
								<div class="m-widget26__number">
									{{ $users }}
									<h3> <small>عدد المستخدمين</small> <i class="flaticon-avatar"></i></h3>
								</div>
								<div class="m-widget26__chart" style="height:90px; width: 220px;">
									<canvas id="m_chart_quick_stats_1"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="m--space-30"></div>
					<div class="m-portlet m-portlet--half-height m-portlet--border-bottom-danger ">
						<div class="m-portlet__body">
							<div class="m-widget26">
								<div class="m-widget26__number">
									{{ $offices }}
									<h3>  <small>عدد المكاتب </small> <i class="fa fa-home"></i></h3>
								</div>
								<div class="m-widget26__chart" style="height:90px; width: 220px;">
									<canvas id="m_chart_quick_stats_2"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6">
					<div class="m-portlet m-portlet--half-height m-portlet--border-bottom-success ">
						<div class="m-portlet__body">
							<div class="m-widget26">
								<div class="m-widget26__number">
									{{ $subscriptions }}
									<h3> <small>عدد الاشتراكات</small> <i class="fa fa-money-check-alt"></i></h3>
								</div>
								<div class="m-widget26__chart" style="height:90px; width: 220px;">
									<canvas id="m_chart_quick_stats_3"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="m--space-30"></div>
					<div class="m-portlet m-portlet--half-height m-portlet--border-bottom-accent ">
						<div class="m-portlet__body">
							<div class="m-widget26">
								<div class="m-widget26__number">
									{{ $ads }}
									<h3><small>عدد الاعلانات العادية</small> <i class="fa fa-bullhorn"></i></h3>
								</div>

								<div class="m-widget26__number">
									{{ $featured_ads }}
									<h3><small>عدد الاعلانات  المميزة</small> <i class="fa fa-money-bill-wave"></i></h3>
								</div>
								<div class="m-widget26__chart" style="height:90px; width: 220px;">
									<canvas id="m_chart_quick_stats_4"></canvas>
								</div>
							</div>
						</div>
					</div>

				</div>
				
			</div>

			
			<!--end:: Widgets/Quick Stats-->
	</div>
</div>



@endsection