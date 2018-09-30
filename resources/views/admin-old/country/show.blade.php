@extends('admin.layouts.app')

@section('title',trans("lang.$module_name")." - ".end($breadcrumb))

@section('content')

    @section('breadcrumb')
        @foreach ($breadcrumb as $bread)
        @if ($loop->last)
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                    <span class="m-nav__link-text">
                        {{ $bread }}
                    </span>
            </li>

            @else
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{ url("$base_view/$route") }}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            @lang("lang.$bread")
                        </span>
                    </a>
                </li>
            @endif
        @endforeach
    @stop

    <div class="clearfix"></div>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <i class="icon-user box-title"></i> [ {{ $bread }} ] @lang('lang.info')
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            
            <div class="row">

                <div class="col-xl-6">
                    <div class="m-portlet m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        <i class="icon-info box-title"></i> @lang('lang.user info')
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget13">
                                <div class="center-block" style="text-align: center;">
                                    <img class="user-image" src="{{ asset($row->image) }}" alt="">
                                </div>
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">
                                        @lang('lang.name')
                                    </span>
                                    <span class="m-widget13__text m-widget13__text-bolder">
                                        {{ $row->name }}
                                    </span>
                                </div>
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">
                                        @lang('lang.email')
                                    </span>
                                    <span class="m-widget13__text m-widget13__text-bolder">
                                       {{ $row->email }}
                                    </span>
                                </div>
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">
                                        @lang('lang.phone')
                                    </span>
                                    <span class="m-widget13__text m-widget13__number-bolder m--font-brand">
                                        {{ $row->phone }}
                                    </span>
                                </div>
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">
                                        @lang('lang.city')
                                    </span>
                                    <span class="m-widget13__text m-widget13__number-bolder m--font-brand">
                                        {{ $row->city->getAttr('name') }}
                                    </span>
                                </div>
                                <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">
                                        @lang('lang.license_image')
                                    </span>
                                    <span class="m-widget13__text">
                                        <a href="{{ asset($row->license_image) }}" download>
                                            <img src="{{ asset('backend/app/media/img/files/jpg.svg') }}" height="35px" alt="">
                                        </a>
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--space m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        <i class="icon-graph box-title"></i> @lang('lang.Reservations statistics')
                                        <span class="m-portlet__head-desc">
                                            Total Sales By Products
                                        </span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget25">
                                <span class="m-widget25__price m--font-brand">
                                    237,650 @lang('lang.sar')
                                </span>
                                <br>
                                <span class="m-widget25__desc">
                                    @lang('lang.Total Revenue This Month')
                                </span>
                                <div class="m-widget25--progress">
                                    <div class="m-widget25__progress">
                                        <span class="m-widget25__progress-number">
                                            63 <span style="font-size: 11px">@lang('lang.order')</span>
                                        </span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-danger" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="m-widget25__progress-sub">
                                            @lang('lang.new orders')
                                        </span>
                                    </div>
                                    <div class="m-widget25__progress">
                                        <span class="m-widget25__progress-number">
                                            39 <span style="font-size: 11px">@lang('lang.order')</span>
                                        </span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-accent" role="progressbar" style="width: 39%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="m-widget25__progress-sub">
                                            @lang('lang.waiting oders')
                                        </span>
                                    </div>
                                    <div class="m-widget25__progress" >
                                        <span class="m-widget25__progress-number">
                                            54 <span style="font-size: 11px">@lang('lang.order')</span>
                                        </span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-warning" role="progressbar" style="width: 54%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="m-widget25__progress-sub">
                                            @lang('lang.approved requests')
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        
        </div>
    </div>


@stop

