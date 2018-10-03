@extends('admin.layouts.index_layout' , ['title' => __('admin.prices') ,'route' => 'prices'])

@section('content')


<div class="row">
    <form class="m-form" action="{{ config('app.admin_url') }}/price/search" method="get" id="search_form">
        <div class="form-group m-form__group row ">
            <label for="q" class="col-1 col-form-label"></label>
            <div class="col-6">
                <input type="text" name="q" class="form-control m-input" 
                placeholder="{{ __('admin.search_word') }}">
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" id="confirm_search">
                    <span>
                        <i class="la la-search"></i>
                        <span>{{ __('admin.search') }}</span>
                    </span>
                </a>
            </div>
        </div>
    </form>
</div>
<br>

@if(isset($query))
<div class="row" style="padding-right: 35px;">
    <span>{{ __('admin.searched_for') }}</span>
    <span><b>"{{ request('q') }}"</b></span>
</div>
@endif

<br>

<div class="row">
    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-progress">

                    <!-- here can place a progress bar-->
                </div>
                <div class="m-portlet__head-wrapper">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-money-bill-alt"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{ __('admin.prices') }}  
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                        <a href="{{ config('app.admin_url') }}/prices/create" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                            <span>
                                <i class="la la-plus"></i>
                                <span>{{ __('admin.add') }}</span>
                            </span>
                        </a>

                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><b>{{ __('admin.city') }}</b></th>
                                    <th><b>{{ __('admin.property_type') }}</b></th>
                                    <th><b>{{ __('admin.date') }}</b></th>
                                    <th><b>{{ __('admin.first_half') }}</b></th>
                                    <th><b>{{ __('admin.second_half') }}</b></th>
                                    <th><b>{{ __('admin.control') }}</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($prices)
                                @foreach ($prices as $price)
                                <tr>
                                    <th scope="row">{{ $price->get_city->name }}</th>
                                    <th scope="row">{{  strtr($price->type,property_types())}}</th>
                                    <th scope="row">{{ $price->date }}</th>
                                    <th scope="row">{{ $price->first_half_price }}</th>
                                    <th scope="row">{{ $price->second_half_price }}</th>
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group"> 
                                            <a type="button" 
                                            href="{{ config('app.admin_url') }}/prices/{{ $price->id }}/edit" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-edit m--font-info"></i>
                                        </a>

                                        <a type="button"  data-id = "{{ $price->id }}" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary _remove">
                                            <i class="flaticon-delete-1 m--font-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            <!--end::Section-->
             @if($prices)
            <div> 
                <span>
                    <span>{{ __('admin.showing') }}</span>
                    {{($prices->currentpage()-1)*$prices->perpage()+1}} 
                    <span>{{ __('admin.to') }}</span> 
                    {{$prices->currentpage()*$prices->perpage()}}
                </span> 
                <span>{{ __('admin.from') }}</span>
                <span class="badge badge-info">{{ $prices->total() }}</span>
                <span>{{ __('admin.items') }}</span>
            </div>
            @endif

        </div>


    </div>
    <!--end::Portlet-->
</div>
</div>

<div class="container">
    <div class="text-center">
       @if($prices)
       {{ $prices->links() }}
       @endif
   </div>
</div>
<br>
@if(isset($query ) or isset($message))
<div>
    <a href="{{ config('app.admin_url') }}/prices" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif







@endsection