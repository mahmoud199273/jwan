
<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu"
        class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown "
        data-menu-vertical="true"
         data-menu-dropdown="true" data-menu-scrollable="true" data-menu-dropdown-timeout="500"
        >
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            

            <li class="m-menu__item" aria-haspopup="true" >
                <a  href="{{ url(ADMIN_PATH.'/user') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-user"></i>
                    <span class="m-menu__link-text">
                        @lang('lang.users')
                    </span>
                </a>
            </li>


            
            <li class="m-menu__item" aria-haspopup="true" >
                <a  href="{{ url(ADMIN_PATH.'/category') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-map-location"></i>
                    <span class="m-menu__link-text">
                        @lang('lang.categories')
                    </span>
                </a>
            </li>


            <li class="m-menu__item" aria-haspopup="true" >
                <a  href="{{ url(ADMIN_PATH.'/natoinality') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-map-location"></i>
                    <span class="m-menu__link-text">
                        @lang('lang.natoinality')
                    </span>
                </a>
            </li>


            <li class="m-menu__item" aria-haspopup="true" >
                <a  href="{{ url(ADMIN_PATH.'/country') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-map-location"></i>
                    <span class="m-menu__link-text">
                        @lang('lang.countries')
                    </span>
                </a>
            </li>


            <li class="m-menu__item" aria-haspopup="true" >
                <a  href="{{ url(ADMIN_PATH.'/area') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-map-location"></i>
                    <span class="m-menu__link-text">
                        @lang('lang.Areas')
                    </span>
                </a>
            </li>


            {{--  <li class="m-menu__item" aria-haspopup="true" >
                <a  href="{{ url(ADMIN_PATH.'/contact-us') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-envelope"></i>
                    <span class="m-menu__link-text">
                        @lang('lang.Contact Us')
                    </span>
                </a>
            </li>

             <li class="m-menu__item" aria-haspopup="true" >
                <a  href="{{ url(ADMIN_PATH.'/settings') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-cogwheel-2"></i>
                    <span class="m-menu__link-text">
                        @lang('lang.Site Settings')
                    </span>
                </a>
            </li>  --}}





        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->


