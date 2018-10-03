@extends('admin.layouts.index_layout' , ['title' => __('admin.banks') ,'route' => 'banks'])

@section('content')

<div class="row">
    <form class="m-form" action="{{ config('app.admin_url') }}/bank/search" method="get" id="search_form">
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
    <span><b>"{{ $query}}"</b></span>
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
                                <i class="la la-bank"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{ __('admin.banks') }}  
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                        <a href="{{ config('app.admin_url') }}/banks/create" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                                        <th><b>{{ __('admin.name') }}</b></th>
                                        <th><b>{{ __('admin.account_name') }}</b></th>
                                        <th><b>{{ __('admin.account_number') }}</b></th>
                                        <th><b>{{ __('admin.iban_account_number') }}</b></th>
                                        <th><b>{{ __('admin.image') }}</b></th>
                                        <th><b>{{ __('admin.control') }}</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($banks)
                                    @foreach ($banks as $bank)
                                    <tr>
                                        <th scope="row">{{ $bank->name }}</th>
                                        <td>{{ $bank->account_name }}</td>
                                        <td>{{ $bank->account_number }}</td>
                                        <td>{{ $bank->iban_account_number }}</td>
                                        <td class="text-center">
                                            <img src="{{ config('app.url') }}/{{ $bank->image }}" height="50" width="150" class="img img-cirlce">
                                        </td>

                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <a type="button" 
                                                href="{{ config('app.admin_url') }}/banks/{{ $bank->id }}/edit" 
                                                class="m-btn m-btn m-btn--square btn btn-secondary">
                                                <i class="fa fa-edit m--font-info"></i>
                                            </a>

                                            <a type="button"  data-id = "{{ $bank->id }}" 
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
            @if($banks)
            <div> 
                <span>
                    <span>{{ __('admin.showing') }}</span>
                    {{($banks->currentpage()-1)*$banks->perpage()+1}} 
                    <span>{{ __('admin.to') }}</span> 
                    {{$banks->currentpage()*$banks->perpage()}}
                </span> 
                <span>{{ __('admin.from') }}</span>
                <span class="badge badge-info">{{ $banks->total() }}</span>
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
     @if($banks)
     {{ $banks->links() }}
     @endif
 </div>
</div>
<br>
@if(isset($query ) or isset($message))
<div>
    <a href="{{ config('app.admin_url') }}/banks" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif







@endsection