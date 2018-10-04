@extends('admin.layouts.index')


@section('title',trans('lang.dashboard'))



@section('content')
	<div class="clearfix"></div>

    <div class="m-portlet ">
		<div class="m-portlet__body  m-portlet__body--no-padding">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-md-12 col-lg-6 col-xl-6">
					<!--begin::Total Profit-->
					<div class="m-widget24">
					    <div class="m-widget24__item">
					        <h4 class="m-widget24__title">
					        </h4><br>
					        <span class="m-widget24__desc" style="margin-right: 20px">
					            @lang('lang.#users')
					        </span>
					        <span class="m-widget24__stats m--font-brand">
					            {{ $users }}
					        </span>
					        <div class="m--space-10"></div>
							<div class="progress m-progress--sm">
								<div class="progress-bar m--bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<span class="m-widget24__change">
							</span>
					    </div>
					</div>
					<!--end::Total Profit-->
				</div>

				<div class="col-md-12 col-lg-6 col-xl-6">
					<!--begin::Total Profit-->
					<div class="m-widget24">
					    <div class="m-widget24__item">
					        <h4 class="m-widget24__title">
					        </h4><br>
					        <span class="m-widget24__desc" style="margin-right: 20px">
					            @lang('lang.#hotels')
					        </span>
					        <span class="m-widget24__stats m--font-brand">
					        </span>
					        <div class="m--space-10"></div>
							<div class="progress m-progress--sm">
								<div class="progress-bar m--bg-warning" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<span class="m-widget24__change">
							</span>
					    </div>
					</div>
					<!--end::Total Profit-->
				</div>

			</div>
		</div>
	</div>
	<hr> <h4 class="text-right"> @lang('lang.reservations') <i class="la la-list fa-3x"></i></h4> <hr>

	<div class="m-portlet ">
		<div class="m-portlet__body  m-portlet__body--no-padding">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-md-12 col-lg-6 col-xl-3">
					<!--begin::Total Profit-->
					<div class="m-widget24">

					    <div class="m-widget24__item">
					        <h4 class="m-widget24__title">
					        </h4><br>
					        <span class="m-widget24__desc" style="margin-right: 20px">
					            عدد الحجوزات
					        </span>
					        <span class="m-widget24__stats m--font-brand">
					        </span>
					        <div class="m--space-10"></div>
							<div class="progress m-progress--sm">
								<div class="progress-bar m--bg-accent" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<span class="m-widget24__change">
							</span>
					    </div>
					    <div class="m-widget24__item">
					        <h4 class="m-widget24__title">
					        </h4><br>
					        <span class="m-widget24__desc" style="margin-right: 20px">
					            اجمالي تكلفه الحجوزات
					        </span>
					        <span class="m-widget24__stats m--font-brand">
					        </span>
					        <div class="m--space-10"></div>
							<div class="progress m-progress--sm">
								<div class="progress-bar m--bg-accent" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<span class="m-widget24__change">
							</span>
					    </div>
					</div>




					<!--end::Total Profit-->
				</div>


			</div>
		</div>
	</div>



@stop
