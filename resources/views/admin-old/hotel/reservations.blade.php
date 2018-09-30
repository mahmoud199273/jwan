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

    <div class="clearfix"></div><br>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <i class="icon-user box-title"></i> [ {{ $row->name }} ] @lang('lang.Reservations')
                    </h3>
                </div>
            </div>

            @include('admin.hotel.additions')

        </div>
        <div class="m-portlet__body">
            
            <div class="row">

                <div class="col-xl-12">
                    <div class="m-portlet m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        <i class="icon-picture box-title"></i> @lang('lang.Reservations')
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget13">
                                <div class="center-block" style="text-align: center;">
                                    <h3> <i class="icon-ban box-title"></i> @lang('lang.Coming Soon ...') </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

            </div>


        
        </div>
    </div>


@stop

