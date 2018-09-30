    <!-- BEGIN: Header -->
    @php
    \Carbon\Carbon::setLocale('ar');
    @endphp
    <header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
    <div class="m-container m-container--fluid m-container--full-height">
    <div class="m-stack m-stack--ver m-stack--desktop">



    <!-- BEGIN: Brand -->
    <div class="m-stack__item m-brand  m-brand--skin-dark ">
    <div class="m-stack m-stack--ver m-stack--general">
    <div class="m-stack__item m-stack__item--middle m-stack__item--center m-brand__logo">
    <a href="{{ url('admin') }}" class="m-brand__logo-wrapper">
    <img alt="" src="{{ url('backend') }}/demo/demo3/media/img/logo/logo.png"/>
    </a>
    </div>
    <div class="m-stack__item m-stack__item--middle m-brand__tools">
    <!-- BEGIN: Responsive Aside Left Menu Toggler -->
    <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
    <span></span>
    </a>
    <!-- END -->
    <!-- BEGIN: Responsive Header Menu Toggler -->
    <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
    <span></span>
    </a>
    <!-- END -->
    <!-- BEGIN: Topbar Toggler -->
    <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
    <i class="flaticon-more"></i>
    </a>
    <!-- BEGIN: Topbar Toggler -->
    </div>
    </div>
    </div>
    <!-- END: Brand -->
    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
    <!-- BEGIN: Horizontal Menu -->
    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
    <i class="la la-close"></i>
    </button>

    <!-- END: Horizontal Menu -->                               <!-- BEGIN: Topbar -->
    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
    <div class="m-stack__item m-topbar__nav-wrapper">
    <ul class="m-topbar__nav m-nav m-nav--inline">
    {{--  <li class=" m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light    m-list-search m-list-search--skin-light" data-dropdown-toggle="click" data-dropdown-persistent="true" id="m_quicksearch" data-search-type="dropdown">
    <a href="#" class="m-nav__link m-dropdown__toggle">
    <span class="m-nav__link-icon">
    <i class="flaticon-search-1"></i>
    </span>
    </a>
    <div class="m-dropdown__wrapper">
    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
    <div class="m-dropdown__inner ">
    <div class="m-dropdown__header">
    <form  class="m-list-search__form">
    <div class="m-list-search__form-wrapper">
    <span class="m-list-search__form-input-wrapper">
    <input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="@lang('lang.Search')">
    </span>
    <span class="m-list-search__form-icon-close" id="m_quicksearch_close">
    <i class="la la-remove"></i>
    </span>
    </div>
    </form>
    </div>
    <div class="m-dropdown__body">
    <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-max-height="300" data-mobile-max-height="200">
    <div class="m-dropdown__content"></div>
    </div>
    </div>
    </div>
    </div>
    </li> --}}
    <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center  m-dropdown--mobile-full-width" data-dropdown-toggle="click" data-dropdown-persistent="true">
    <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
    <span class="m-nav__link-badge m-badge m-badge--accent">
    1

    </span>
    <span class="m-nav__link-icon">
    <i class="flaticon-alert-2"></i>
    </span>
    </a>
    <div class="m-dropdown__wrapper">
    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
    <div class="m-dropdown__inner">
    <div class="m-dropdown__header m--align-center" style="background: url({{ url('backend/app/media/img/misc/notification_bg.jpg') }}); background-size: cover;">
    <span class="m-dropdown__header-title">
    1 @lang('lang.new hotels')
    </span>
    </div>
    <div class="m-dropdown__body">
    <div class="m-dropdown__content">
    <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
    <li class="nav-item m-tabs__item">
    <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">
    @lang('lang.Hotels')
    </a>
    </li>
    </ul>

    <div class="tab-content">
    <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
    <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">


    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    </li>

    <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
    <a href="#" class="m-nav__link m-dropdown__toggle">
    <span class="m-topbar__userpic">
    {{--  <img style="border-radius: 0% !important" src="{{url(auth()->guard('admin')->user()->image)}}" alt=""/>  --}}
    </span>
    </a>
    <div class="m-dropdown__wrapper">
    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
    <div class="m-dropdown__inner">
    <div class="m-dropdown__header m--align-center" style="background: url({{ url('backend/app/media/img/misc/user_profile_bg.jpg') }}); background-size: cover;">
    <div class="m-card-user m-card-user--skin-dark">
    <div class="m-card-user__pic">
    {{--  <img src="{{url(auth()->guard('admin')->user()->image)}}" alt=""/>  --}}
    </div>
    <div class="m-card-user__details">
    <span class="m-card-user__name m--font-weight-500">
    {{--  {{ auth()->guard('admin')->user()->name }}  --}}
    </span>
    <a href="" class="m-card-user__email m--font-weight-300 m-link">
    {{--  {{ auth()->guard('admin')->user()->email }}  --}}
    </a>
    </div>
    </div>
    </div>
    <div class="m-dropdown__body">
    <div class="m-dropdown__content">
    <ul class="m-nav m-nav--skin-light">
    <li class="m-nav__section m--hide">
    <span class="m-nav__section-text">
    Section
    </span>
    </li>
    <li class="m-nav__item">
    <a href="{{ url(ADMIN_PATH.'/profile') }}" class="m-nav__link">
    <span class="m-nav__link-title">
    <span class="m-nav__link-wrap">
    <span class="m-nav__link-text">
    اعدادات الحساب
    </span>
    </span>
    </span>

    <i class="m-nav__link-icon flaticon-profile-1"></i>

    </a>
    </li>
    <li class="m-nav__separator m-nav__separator--fit"></li>
    <li class="m-nav__item">
    {{--  <a onclick="event.preventDefault();
    document.getElementById('logout-form').submit();" href="{{ route('admin.logout') }}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
    تسجيل الخروج
    </a>  --}}
    </li>
    {{--  <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    </form>  --}}
    </ul>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <!-- END: Topbar -->
    </div>
    </div>
    </div>
    </header>
    <!-- END: Header -->
