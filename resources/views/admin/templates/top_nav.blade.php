<!-- BEGIN: Topbar -->
<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">

	@php 
		$admin = Auth::guard('admin')->user();
	@endphp

 
	<div class="m-stack__item m-topbar__nav-wrapper">
		<ul class="m-topbar__nav m-nav m-nav--inline">	
			<li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1" aria-expanded="true">
				<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
					<span class="m-nav__link-badge m-badge m-badge--accent">
						{{$not_num = $inactive_influncers + $inactive_campaigns + $inactive_transactions + $userSocial}}
						

					</span>
					<span class="m-nav__link-icon"><i class="flaticon-alert-2"></i></span>
				</a>
				<div class="m-dropdown__wrapper" style="z-index: 101;margin-right: -300px;">
					<span class="m-dropdown__arrow m-dropdown__arrow--center" style="left: 60px; right: auto;"></span>
					<div class="m-dropdown__inner">
						<div class="m-dropdown__header m--align-center" style="background: url('{{asset('admin/assets/app/media/img/misc/notification_bg.jpg')}}'); background-size: cover;">
							<span class="m-dropdown__header-title">{{$not_num = $inactive_influncers + $inactive_campaigns + $inactive_transactions +$userSocial}} New</span>
							<span class="m-dropdown__header-subtitle">User Notifications</span>
						</div>
						<div class="m-dropdown__body">				
							<div class="m-dropdown__content">
							<div class="m-list-timeline m-list-timeline--skin-light">
									<div class="m-list-timeline__items">

									@if($inactive_influncers > 0)
									
									  <div class="m-list-timeline__item">
														<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
														<a href="{{url('admin/influencers')}}" class="m-list-timeline__text">لديك {{$inactive_influncers}} من المؤثرين الجدد </a>
														<span class="m-list-timeline__time"></span>
									  </div>
									  
									  @endif


									  @if($inactive_campaigns > 0)
									  <div class="m-list-timeline__item">
														<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
														<a href="{{url('admin/campaigns')}}" class="m-list-timeline__text">لديك {{$inactive_campaigns}} من الحملات الجديدة </a>
														<!-- <span class="m-list-timeline__time">Just now</span> -->
									  </div>
									  @endif



									  @if($inactive_transactions > 0)
									  <div class="m-list-timeline__item">
														<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
														<a href="{{url('admin/transaction/users')}}" class="m-list-timeline__text">لديك {{$inactive_transactions}}  من التحويلات البنكية للعملاء </a>
														<!-- <span class="m-list-timeline__time">Just now</span> -->
									  </div>
									  @endif

									   @if($userSocial > 0)
									  <div class="m-list-timeline__item">
														<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
														<a href="{{url('admin/influencers')}}" class="m-list-timeline__text">لديك {{$userSocial}}  من المؤثرين قاموا بتعديل جمهور المتابعين </a>
														<!-- <span class="m-list-timeline__time">Just now</span> -->
									  </div>
									  @endif


									</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</li>

			<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
				<a href="#" class="m-nav__link m-dropdown__toggle">
					<span class="m-topbar__userpic">
						<img src="{{asset('/admin/assets/app/media/img/users/user3.png')}}" alt=""/>
					</span>					
				</a>
				<div class="m-dropdown__wrapper">
					<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
					<div class="m-dropdown__inner">
					
						<div class="m-dropdown__header m--align-center" style="background: url({{ config('app.url') }}/public/admin/assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
							<div class="m-card-user m-card-user--skin-dark">
								<div class="m-card-user__pic">
									<img src="{{asset('/admin/assets/app/media/img/users/user3.png')}}" alt=""/>
								</div>
								<div class="m-card-user__details">
									<span class="m-card-user__name m--font-weight-500">
										 {{ $admin->name }} 
									</span>
									<a href="" class="m-card-user__email m--font-weight-300 m-link">
										 {{ $admin->email }} 
									</a>
								</div>
							</div>
						</div>
						<div class="m-dropdown__body">
							<div class="m-dropdown__content">
								<ul class="m-nav m-nav--skin-light">
									<li class="m-nav__section m--hide">
										<span class="m-nav__section-text">Section</span>
									</li>
									<li class="m-nav__item">
										<a href="{{ config('app.admin_url') }}/profile" class="m-nav__link">
											<i class="m-nav__link-icon flaticon-profile-1"></i>
											<span class="m-nav__link-title">  
												<span class="m-nav__link-wrap">      
													<span class="m-nav__link-text">{{ __('admin.profile') }}</span>       
												</span>
											</span>
										</a>
									</li>
									
									<li class="m-nav__separator m-nav__separator--fit">
									</li>
									<li class="m-nav__item">
										<a href="{{ config('app.admin_url') }}/logout" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">{{ __('admin.logout') }}</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</li>
			
		</ul>
	</div>
</div>