<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">	
	<!-- BEGIN: Aside Menu -->
	<div 
	id="m_ver_menu" 
	class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown " 
	data-menu-vertical="true"
	m-menu-dropdown="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500"  
	>		
	<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
		<li class="m-menu__item" aria-haspopup="true" >
			<a  href="{{url('admin/admin')}}" class="m-menu__link ">
				<span class="m-menu__item-here"></span>
				<i class="m-menu__link-icon flaticon-line-graph"></i>
				<span class="m-menu__link-text">{{ __('admin.dashboard') }}</span>
			</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/profile')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-nav__link-icon flaticon-profile-1"></i>
					<span class="m-menu__link-text">{{ __('admin.profile') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
			<a  href="{{url('admin/users')}}" class="m-menu__link ">
				<span class="m-menu__item-here"></span>
				<i class="m-menu__link-icon flaticon-avatar"></i>
				<span class="m-menu__link-text">{{ __('admin.users') }}</span>
			</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
			<a  href="{{url('admin/influencers')}}" class="m-menu__link ">
				<span class="m-menu__item-here"></span>
				<i class="m-menu__link-icon flaticon-avatar"></i>
				<span class="m-menu__link-text">{{ __('admin.influencers') }}</span>
			</a>
		</li>


		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/country')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map"></i>
					<span class="m-menu__link-text">{{ __('admin.countries') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/area')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map"></i>
					<span class="m-menu__link-text">{{ __('admin.areas') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/natoinality')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map"></i>
					<span class="m-menu__link-text">{{ __('admin.natoinalities') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/category')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map"></i>
					<span class="m-menu__link-text">{{ __('admin.categories') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/complaints')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map"></i>
					<span class="m-menu__link-text">{{ __('admin.contact_us') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/campaigns')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map"></i>
					<span class="m-menu__link-text">{{ __('admin.campaigns') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{url('admin/bank')}}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map"></i>
					<span class="m-menu__link-text">{{ __('admin.bank_accounts') }}</span>
				</a>
		</li>

		<li class="m-menu__item" aria-haspopup="true" >
			<a  href="{{url('admin/pages')}}" class="m-menu__link ">
				<span class="m-menu__item-here"></span>
				<i class="m-menu__link-icon fa fa-map"></i>
				<span class="m-menu__link-text">{{ __('admin.pages') }}</span>
			</a>
		</li>

		{{--  <li class="m-menu__item {{ isActiveTap('districts') }}" aria-haspopup="true" >
				<a  href="{{ config('app.admin_url') }}/districts" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon fa fa-map-marker"></i>
					<span class="m-menu__link-text">{{ __('admin.districts') }}</span>
				</a>
			</li>  --}}
		
		
	</ul>
	</div>
	<!-- END: Aside Menu -->
</div>