<!DOCTYPE html>

<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            @lang('lang.signin')
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->
        {!! Html::style("backend/vendors/base/vendors.bundle.css") !!}
        {!! Html::style("backend/demo/demo5/base/style.bundle.css") !!}
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ url('backend/demo/demo5/media/img/logo/favicon.ico') }}" />
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        @include('hotel.layouts.errors')
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-login m-login--signin  m-login--5" id="m_login" style="background-image: url({{ url('backend/app/media/img//bg/bg-3.jpg') }});">
                <div class="m-login__wrapper-1 m-portlet-full-height">
                    <div class="m-login__wrapper-1-1">
                        <div class="m-login__contanier">
                            <div class="m-login__content">
                                <div class="m-login__logo">
                                    <a href="{{ url('') }}">
                                        <img src="{{ url('img/logo.png') }}">
                                    </a>
                                </div>
                                <div class="m-login__title">
                                    <h3>
                                        @lang('lang.Add your own hotel')
                                    </h3>
                                </div>
                                <div class="m-login__desc">
                                    @lang('lang.Add your own hotel, follow up on bookings and customers to provide the best services and offers in case.')
                                </div>
                                <div class="m-login__form-action">
                                    <button type="button" id="m_login_signup" class="btn btn-outline-focus m-btn--pill">
                                        @lang('lang.Add your own hotel now')
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="m-login__border">
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="m-login__wrapper-2 m-portlet-full-height">
                    <div class="m-login__contanier">
                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    @lang('lang.signin')
                                </h3>
                            </div>
                                <form class="m-login__form m-form" role="form" data-redirect="{{ url(HOTEL_DASHBOARD) }}" method="POST" action="{{ route('hotel.login') }}">
                                    {{ csrf_field() }}
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="@lang('lang.email')" name="email" autocomplete="off">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="Password" placeholder="@lang('lang.password')" name="password">
                                </div>
                                <div class="row m-login__form-sub">
                                    <div class="col m--align-left">
                                        <label class="m-checkbox m-checkbox--focus">
                                            <input type="checkbox" name="remember">
                                            @lang('lang.rememberme')
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col m--align-right">
                                        <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                            @lang('lang.iforgetmypassword') ?
                                        </a>
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                        @lang('lang.signin')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="m-login__signup">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    @lang('lang.signup')
                                </h3>
                                <div class="m-login__desc">
                                    @lang('lang.Add your own hotel, and follow up on reservations and customers to provide the best services and offers in case you have an account you can sign in') <a type="button" href="javascript:void(0)" class="_login_form m-link">@lang('lang.signin')</a>
                                </div>
                            </div>
                            <form class="m-login__form m-form" action="{{ route('hotel.register') }}" method="post">
                                {!! csrf_field() !!}

                                <div class="row">
                                    <div class="form-group m-form__group col-md-12" >
                                        <input class="form-control m-input" type="text" placeholder="@lang('lang.name')" name="name">
                                    </div>
                                    <div class="form-group m-form__group col-md-6">
                                        <input class="form-control m-input" type="text" placeholder="@lang('lang.email')" name="email" autocomplete="off">
                                    </div>
                                    <div class="form-group m-form__group col-md-6">
                                        <input class="form-control m-input" type="password" placeholder="@lang('lang.Password')" name="password">
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="form-group m-form__group col-md-12" >
                                        <input class="form-control m-input" type="text" placeholder="@lang('lang.hotel_name')" name="hotel_name">
                                    </div>
                                    <div class="form-group m-form__group col-md-6">
                                        <input class="form-control m-input" type="text" placeholder="@lang('lang.phone')" name="phone" autocomplete="off">
                                    </div>
                                    <div class="form-group m-form__group col-md-6">
                                        <input class="form-control m-input" type="text" placeholder="@lang('lang.address')" name="address">
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                        @lang('lang.signup')
                                    </button>
                                    <button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">
                                        @lang('lang.cancel')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="m-login__forget-password">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    @lang('lang.iforgetmypassword') ?
                                </h3>
                                <div class="m-login__desc">
                                    @lang('lang.enteryouremailtosendpasswordresetlinktoyouremail'):
                                </div>
                            </div>
                            <form id="m_login_forget_password_submit" class="m-login__form m-form" role="form" method="POST" action="{{ route('hotel.password.email') }}">
                                {{ csrf_field() }}
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                                </div>
                                <div class="m-login__form-action">
                                    <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                        @lang('lang.Reset')
                                    </button>
                                    <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom ">
                                        @lang('lang.cancel')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <!--begin::Base Scripts -->
        {!! Html::script('backend/vendors/base/vendors.bundle.js') !!}
        {!! Html::script('backend/demo/demo5/base/scripts.bundle.js') !!}
        <!--end::Base Scripts -->
        <!--begin::Page Snippets -->
        {!! Html::script('backend/snippets/pages/user/login.js') !!}
        <!--end::Page Snippets -->
    </body>
    <!-- end::Body -->
</html>
