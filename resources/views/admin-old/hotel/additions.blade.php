<div class="m-portlet__head-tools" style="margin-top: 15px">
    <ul class="m-portlet__nav">
        {{-- <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
            <a class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand reservation-button">
            @lang('lang.Reservations')
            </a>
            <div class="m-dropdown__wrapper">
                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 35.5px;"></span>
                <div class="m-dropdown__inner">
                    <div class="m-dropdown__body">
                        <div class="m-dropdown__content">
                            <ul class="m-nav">
                                <li class="m-nav__item">
                                    <a href="{{ url(ADMIN_PATH.'/hotel/reservations/'.$row->id) }}" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-share"></i>
                                    <span class="m-nav__link-text">@lang('lang.new orders')</span>
                                    <span class="m-badge m-badge--info m-badge--wide">16</span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="{{ url(ADMIN_PATH.'/hotel/reservations/'.$row->id) }}" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-share"></i>
                                    <span class="m-nav__link-text">@lang('lang.approved requests')</span>
                                    <span class="m-badge m-badge--success m-badge--wide">10</span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="{{ url(ADMIN_PATH.'/hotel/reservations/'.$row->id) }}" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-share"></i>
                                    <span class="m-nav__link-text">@lang('lang.waiting oders')</span>
                                    <span class="m-badge m-badge--warning m-badge--wide">15</span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="{{ url(ADMIN_PATH.'/hotel/reservations/'.$row->id) }}" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-share"></i>
                                    <span class="m-nav__link-text">@lang('lang.Cancelled Reservations')</span>
                                    <span class="m-badge m-badge--danger m-badge--wide">12</span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="{{ url(ADMIN_PATH.'/hotel/reservations/'.$row->id) }}" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-share"></i>
                                    <span class="m-nav__link-text">@lang('lang.Finished Reservations')</span>
                                    <span class="m-badge m-badge--accent m-badge--wide">13</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li> --}}
        <li class="m-portlet__nav-item">
            <a  href="{{ url(ADMIN_PATH.'/hotel/rooms/'.$row->id) }}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                <span>
                    <i class="icon-home"></i>
                    <span>@lang('lang.Rooms')</span>
                </span>
            </a>
        </li>
        {{-- <li class="m-portlet__nav-item">
            <a href="#" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                <span>
                    <i class="icon-info"></i>
                    <span>@lang('lang.Hotel info')</span>
                </span>
            </a>
        </li> --}}
        <li class="m-portlet__nav-item">
            <a href="{{ url(ADMIN_PATH.'/hotel/photos/'.$row->id) }}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                <span>
                    <i class="icon-picture"></i>
                    <span>@lang('lang.Hotel photos')</span>
                </span>
            </a>
        </li>
    </ul>
</div>
