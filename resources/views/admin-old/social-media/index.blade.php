@extends('admin.layouts.app')

@section('title',trans("lang.$module_name")." - ".trans("lang.".end($breadcrumb)))

@section('content')

    @section('breadcrumb')
        @foreach ($breadcrumb as $bread)
        @if ($loop->last)
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                    <span class="m-nav__link-text">
                        @lang("lang.$bread")
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
                        @lang("lang.$module_name")
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="@lang('lang.Search')" id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="{{ url("admin/$route/create") }}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="fa fa-plus"></i>
                                <span>@lang('lang.Create') </span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <table class="m-datatable" id="html_table" width="100%">
                <thead>
                    <tr>
                        @foreach ($columns as $key => $column)
                            <th >{{ trans("lang.$column") }}</th>
                        @endforeach
                        <th> @lang('lang.icon') </th>
                        <th> @lang('lang.status') </th>
                        <th>@lang('lang.controllers')</th>
                    </tr>
                </thead>
                <tbody>
                   @include("$base_view.$path.loop")
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>


@stop

@push('script')
    <!--begin::Page Resources -->
    {!! Html::script('backend/demo/default/custom/components/datatables/base/html-table.js') !!}
    <!--end::Page Resources -->
@endpush

