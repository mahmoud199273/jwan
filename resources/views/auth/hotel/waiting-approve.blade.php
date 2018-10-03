<!DOCTYPE html>

<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>@lang('lang.your account pending now.')</title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->
        {!! Html::style("backend/demo/demo5/base/style.bundle.css") !!}
        @if (config('app.locale') == 'ar')
            {!! Html::style('backend/demo/demo5/base/style.ar.css') !!}
        @endif
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
                                        <img src="{{ url('img/logo.png') }}" height="100px">
                                    </a>
                                </div>
                                <div class="m-login__title">
                                    <h3>
                                        @lang('lang.your account pending now.')
                                    </h3>
                                </div>
                                <div class="m-login__desc">
                                    @lang('lang.Please wait till you get activated we will mail you.')
                                </div>
                                <div class="m-login__form-action">
                                    <a  href="{{ url('') }}" class="btn btn-outline-focus m-btn--pill">
                                        @lang('lang.home')
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="m-login__border">
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <!--begin::Base Scripts -->
    </body>
    <!-- end::Body -->
</html>
