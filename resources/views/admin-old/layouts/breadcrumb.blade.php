<!-- BEGIN: Subheader -->
<div class="m-subheader" dir="rtl">
    <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    @php
                        $module_name = @$module_name ? @$module_name : 'Dashboard';
                    @endphp
                    {{ trans("lang.$module_name") }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('admin') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home dashboard-bread"></i> @lang('lang.Dashboard')
                        </a>
                                            </li>
                    @yield('breadcrumb','<li class="m-nav__item"><span class="m-nav__link-text">'.(@$module_name ? $module_name : 'Module').'</span></li>')
                </ul>
            </div>
    </div>
</div>
<!-- END: Subheader -->
{{--
<ol class="breadcrumb">
    <li> <a href="{{ url('') }}">@lang('lang.dashboard')</a> </li>

</ol>
 --}}
