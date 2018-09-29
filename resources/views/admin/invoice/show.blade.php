@extends('admin.layouts.app')

@section('title',trans("lang.$module_name")." - ".trans(end($breadcrumb)))

@section('content')

    @section('breadcrumb')
        @foreach ($breadcrumb as $bread)
        @if ($loop->last)
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                    <span class="m-nav__link-text">
                        @lang("$bread")
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
                        <div class="col-xl-12 order-2 order-xl-1">
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

                    </div>
                </div>

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <table class="m-datatable" id="html_table" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        @foreach ($show_columns_html as $key => $column)
                            <th style="{{ $column == 'id' ? "width:20px" : ''}}" title="{{ $key }}">{{ trans("lang.$column") }}</th>
                        @endforeach
                        <th>@lang('lang.details')</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_amount = 0;
                        $total_commission = 0;
                    @endphp
                    @foreach ($reservations as $row)
                        @php
                            $total_amount += $row->total_price_after_taxs;
                            $total_commission += $row->commission;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @foreach ($show_columns_select as $column)
                                <td style="{{ $column == 'id' ? "width:20px" : ''}}" title="{{ $row->$column }}">{{ $row->$column }}</td>
                            @endforeach
                            <td>
                                @include("hotel.reservation.action")
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>@lang('lang.total')</b></td>
                    <td><b>{{ $total_amount }}</b></td>
                    <td><b>{{ $total_commission }}</b></td>
                    <td></td>
                    <td></td>
                </tfoot>
            </table>
            <!--end: Datatable -->
        </div>
    </div>


@stop

@push('script')
    <!--begin::Page Resources -->
    {!! Html::script('backend/demo/default/custom/components/datatables/base/html-table.js') !!}
    <!--end::Page Resources -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('.open-modal').on('click', function(e){
                // e.preventDefault();
                $href = $(this).attr('href');
                $target = $(this).data('target');

                $.get($href, function(data) {
                    $($target).find('.modal-content').html(data);
                });

                // return false;
            })
        });
    </script>
@endpush


