<!DOCTYPE html>

<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            Reset password
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
        {!! Html::style("backend/demo/default/base/style.bundle.css") !!}
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ url('backend//demo/default/media/img/logo/favicon.ico') }}" />
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-login m-login--signin  m-login--5" id="m_login" style="background-image: url({{ url('backend/app/media/img//bg/bg-3.jpg') }});">
                <div class="m-login__wrapper-1 m-portlet-full-height">
                    <div class="m-login__wrapper-1-1">
                        <div class="m-login__contanier">
                            <div class="m-login__content">
                                <div class="m-login__logo">
                                    <a href="{{ url('') }}">
                                        <img src="{{ url('backend/app/media/img//logos/logo-2.png') }}">
                                    </a>
                                </div>
                                <div class="m-login__title">
                                    <h3>
                                        JOIN OUR GREAT METRO COMMUNITY GET FREE ACCOUNT
                                    </h3>
                                </div>
                                <div class="m-login__desc">
                                    Amazing Stuff is Lorem Here.Grownng Team
                                </div>
                                {{-- <div class="m-login__form-action">
                                    <button type="button" id="m_login_signup" class="btn btn-outline-focus m-btn--pill">
                                        Get An Account
                                    </button>
                                </div> --}}
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
                                    @lang('lang.Reset Password')
                                </h3>
                            </div>
                                <form data-redirect="{{ url('admin') }}" role="form" method="POST" action="{{ route('admin.password.request') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group m-form__group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <input class="form-control m-input" value="{{ old('email') }}" type="text" placeholder="@lang('lang.email')" name="email" autocomplete="off">
                                    <div id="email-error" class="form-control-feedback">{{ $errors->first('email') }}</div>
                                </div>
                                <div class="form-group m-form__group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <input class="form-control m-input" name="password" type="Password" placeholder="@lang('lang.password')">
                                    <div id="email-error" class="form-control-feedback">{{ $errors->first('password') }}</div>
                                </div>
                                <div class="form-group m-form__group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                    <input class="form-control m-input" name="password_confirmation" type="Password" placeholder="@lang('lang.password_confirmation')">
                                    <div id="email-error" class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
                                </div>

                                <div class="row m-login__form-sub">
                                    <div class="col m--align-right">
                                        <a href="{{ url('admin/login') }}" class="m-link">
                                            @lang('lang.signin')
                                        </a>
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                        @lang('lang.Reset')
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <!--begin::Base Scripts -->
        {!! Html::script('backend/vendors/base/vendors.bundle.js') !!}
        {!! Html::script('backend/demo/default/base/scripts.bundle.js') !!}
        <!--end::Base Scripts -->
        <!--begin::Page Snippets -->
        {!! Html::script('backend/snippets/pages/user/login.js') !!}
        <!--end::Page Snippets -->
    </body>
    <!-- end::Body -->
</html>
