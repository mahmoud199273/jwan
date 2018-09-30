@extends('admin.layouts.app')

@section('title',trans("lang.Profile"))

@section('content')

@section('breadcrumb')
        <li class="m-nav__separator">
            -
        </li>
        <li class="m-nav__item">
            <a href="{{ url("admin/profile") }}" class="m-nav__link">
                <span class="m-nav__link-text">
                    @lang("lang.profile")
                </span>
            </a>
        </li>
@stop

@push('head')
	<style type="text/css">

	</style>
@endpush

	<div class="m-content">
		<div class="row">
			<div class="col-xl-3 col-lg-4">
				<div class="m-portlet m-portlet--full-height  ">
					<div class="m-portlet__body">
						<div class="m-card-profile">
							<div class="m-card-profile__title m--hide">
								@lang('lang.profile')
							</div>
							<div class="m-card-profile__pic">
								<div class="m-card-profile__pic-wrapper">
									<img  style="border-radius: 0% !important" src="{{ url($user->image) }}" alt=""/>
								</div>
							</div>
							<div class="m-card-profile__details">
								<span class="m-card-profile__name">
									{{ $user->name }}
								</span>
								<a href="" class="m-card-profile__email m-link">
									{{ $user->email }}
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8">
				<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
					<div class="m-portlet__head">
						<div class="m-portlet__head-tools">
							<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
								<li class="nav-item m-tabs__item">
									<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
										<i class="flaticon-share m--hide"></i>
										@lang('lang.profile')
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="tab-content">
						<div class="tab-pane active" id="m_user_profile_tab_1">
							{!! Form::model($user,['method'=>'POST', 'files'=>true,'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
								<div class="m-portlet__body">
									<div class="form-group m-form__group row">
										<div class="col-10 ml-auto">
											<h3 class="m-form__section">
												1. معلومات الشخصيه
											</h3>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="example-text-input" class="col-2 col-form-label">
											@lang('lang.name')
										</label>
										<div class="col-7">
											{!! Form::text('name',null,['class'=>"form-control m-input"]) !!}
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="example-text-input" class="col-2 col-form-label">
											@lang('lang.email')
										</label>
										<div class="col-7">
											{!! Form::email('email',null,['class'=>"form-control m-input"]) !!}
										</div>
									</div>

									<div class="form-group m-form__group row">
										<label for="example-text-input" class="col-2 col-form-label">
											@lang('lang.image')
										</label>
										<div class="col-7">
											{!! Form::file('image',['class'=>"form-control m-input"]) !!}
										</div>
									</div>


									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
									<div class="form-group m-form__group row">
										<div class="col-10 ml-auto">
											<h3 class="m-form__section">
												2. @lang('lang.password')
											</h3>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="example-text-input" class="col-2 col-form-label">
											@lang('lang.password')
										</label>
										<div class="col-7">
		                                    {!! Form::password('password', ['class' => 'form-control m-input']) !!}
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="example-text-input" class="col-2 col-form-label">
											@lang('lang.password_confirmation')
										</label>
										<div class="col-7">
		                                    {!! Form::password('password_confirmation', ['class' => 'form-control m-input']) !!}
										</div>
									</div>


								</div>
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions">
										<div class="row">
											<div class="col-2"></div>
											<div class="col-7">
												<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
													@lang('lang.save')
												</button>
												&nbsp;&nbsp;
												<button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
													@lang('lang.cancel')
												</button>
											</div>
										</div>
									</div>
								</div>
							{!! Form::close() !!}
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

@stop

