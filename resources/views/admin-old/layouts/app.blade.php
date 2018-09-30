<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- <meta name="author" content="Mark Rady"> -->
    <!-- App Title -->
    <title>@yield('title','Dashboard')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        {{-- <link href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet" type="text/css" /> --}}
        <script>
          WebFont.load({
            google: {"families":["Montserrat:300,400,500,600,700","Roboto:300,400,500,600,700","droidarabickufi:400,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->
        <!--begin::Page Vendors -->
        {!! Html::style('backend/vendors/custom/fullcalendar/fullcalendar.bundle.css') !!}
        <!--end::Page Vendors -->
        {!! Html::style('backend/vendors/base/vendors.bundle.css') !!}
        {!! Html::style('backend/demo/demo3/base/style.bundle.css') !!}
        {!! Html::style('backend/demo/demo3/base/custom.style.css') !!}
        {!! Html::style('backend/demo/demo3/base/style.ar.css') !!}
        {!! Html::style('backend/demo/demo3/base/simple-line-icons.min.css') !!}
        {!! Html::style('frontend/css/icomoon.css') !!}
        {{-- {!! Html::style('https://use.fontawesome.com/releases/v5.0.6/css/all.css') !!} --}}
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ url('backend') }}/demo/demo3/media/img/logo/favicon.ico" />

    @stack('head')
</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >

  <!-- Image previewer model -->

      <div id="imgPreviewModal" class="modal fade" role="dialog" style="z-index: 9999">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
            <div class="modal-body">
              <img src="" class="center-block" id="imagepreview" style=" max-width: 100%;">
            </div>
          </div>
        </div>
      </div>

      <!-- Image previewer model -->

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">


        <!-- Top Bar Start -->
        @include('admin.layouts.header')
         <!-- Top Bar End -->
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
           @include('admin.layouts.menu')

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
                @include('admin.layouts.errors')
                @include('admin.layouts.breadcrumb')
            <div class="m-content">
                @yield('content')
            </div>
        </div> <!-- /.m-grid__item m-grid__item--fluid m-wrapper -->
    </div> <!-- end page -->
    <!-- END wrapper -->
   @include('admin.layouts.footer')

      <!--begin::Base Scripts -->
      {!! Html::script('backend/vendors/base/vendors.bundle.js') !!}
      {!! Html::script('backend/demo/demo3/base/scripts.bundle.js') !!}
      {!! Html::script('backend/demo/demo3/base/select2.js') !!}
      {!! Html::script('backend/demo/demo3/base/summernote.js') !!}
      
     

        <!--end::Base Scripts -->

        <!--begin::Page Vendors -->
          {!! Html::script('backend/vendors/custom/fullcalendar/fullcalendar.bundle.js') !!}
        <!--end::Page Vendors -->

        

        <script>
            $(function() {
               var pgurl = window.location.href;

               $(".m-menu__nav li a").each(function(){
                    if($(this).attr("href") == pgurl || $(this).attr("href") == '' ){
                      $(this).parent().addClass("m-menu__item--active");
                    }
               })
            });
        </script>

        <script>
          $(document).ready(function() {
              $('.img_preview').click(function(event) {
                 $('#imagepreview').attr('src', $(this).attr('src'));
                 $('#imgPreviewModal').modal('show');
              });
          });
        </script>
        <script>
          // change and uppercase or space with [-] in page url input
          
          $(document).ready(function() {
            $('#page_url').bind('keyup keypress blur', function() {
                var myStr = $(this).val()
                myStr=myStr.toLowerCase();
                myStr=myStr.replace(/(^\s+|[^a-zA-Z0-9 ]+|\s+$)/g,"-");
                myStr = myStr.toLowerCase().replace(/ /g, '-');
                $(this).val(myStr); 
              });
          });
        </script>

        

        <script>
    $(document).ready(function() {
    $('.m-datatable__table').DataTable( {
        "language": {
            "lengthMenu": "عرض القائمه اعنده لكل صفحه",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        }
    } );
} );
</script>

@stack('script')

</body>
</html>
