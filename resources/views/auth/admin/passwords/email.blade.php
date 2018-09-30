<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="{{url('backend')}}/assets/images/favicon_1.ico">

    <title>@lang('lang.Reset')</title>

    <link href="{{url('backend')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('backend')}}/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="{{url('backend')}}/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="{{url('backend')}}/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="{{url('backend')}}/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="{{url('backend')}}/assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{url('backend')}}/assets/js/modernizr.min.js"></script>

    </head>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">
                <div class="panel-heading">
                    <h3 class="text-center"> @lang('lang.Reset Password') </h3>
                </div>


                <div class="panel-body">
                     <form id="m_login_forget_password_submit" class="form-horizontal m-t-20" role="form" method="POST" action="{{ route('admin.password.email') }}">
                        {{ csrf_field() }}

                        @include('admin.layouts.errors')

                      <div class="form-group m-b-0">
                            <div class="input-group">
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('lang.email')" required="">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-pink w-sm waves-effect waves-light">
                                        @lang('lang.Reset')
                                    </button>
                                </span>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

      </div>




      <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="{{url('backend')}}/assets/js/jquery.min.js"></script>
    <script src="{{url('backend')}}/assets/js/bootstrap.min.js"></script>
    <script src="{{url('backend')}}/assets/js/detect.js"></script>
    <script src="{{url('backend')}}/assets/js/fastclick.js"></script>
    <script src="{{url('backend')}}/assets/js/jquery.slimscroll.js"></script>
    <script src="{{url('backend')}}/assets/js/jquery.blockUI.js"></script>
    <script src="{{url('backend')}}/assets/js/waves.js"></script>
    <script src="{{url('backend')}}/assets/js/wow.min.js"></script>
    <script src="{{url('backend')}}/assets/js/jquery.nicescroll.js"></script>
    <script src="{{url('backend')}}/assets/js/jquery.scrollTo.min.js"></script>


    <script src="{{url('backend')}}/assets/js/jquery.core.js"></script>
    <script src="{{url('backend')}}/assets/js/jquery.app.js"></script>

</body>
</html>


