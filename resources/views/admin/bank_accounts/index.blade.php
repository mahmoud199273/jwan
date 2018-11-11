@extends('admin.layouts.index_layout' , ['title' => __('admin.bank_accounts') ,'route' => 'bankaccounts'])

@section('content')

<div class="row">
    <form class="m-form" action="{{ config('app.admin_url') }}/bankaccount/search" method="get" id="search_form">
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
                                {{ __('admin.bank_accounts') }}  
                            </h3>
                        </div>
                    </div>
                    <!-- <div class="m-portlet__head-tools">

                        <a href="{{ config('app.admin_url') }}/bankaccounts/create" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                            <span>
                                <i class="la la-plus"></i>
                                <span>{{ __('admin.add') }}</span>
                            </span>
                        </a>

                    </div> -->
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
                                        <th><b>{{ __('admin.user_name') }}</b></th>
                                        
                                        <th><b>{{ __('admin.bank_name') }}</b></th>
                                        
                                        <th><b>{{ __('admin.account_name') }}</b></th>

                                        <th><b>{{ __('admin.IBAN') }}</b></th>

                                        <th><b>{{ __('admin.note') }}</b></th>

                                        <th><b>{{ __('admin.account_number') }}</b></th>


                                        <th><b>{{ __('admin.control') }}</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($list)
                                    @foreach ($list as $account)
                                    <tr>
                                        <th scope="row">{{ $account->name }}</th>
                                       
                                        <td>{{ $account->name_ar }}</td>

                                        <td>{{ $account->account_name }}</td>

                                        <td>{{ $account->IBAN }}</td>

                                        <td>{{ $account->note }}</td>

                                        <td>{{ $account->account_number }}</td>
                                        
                                        

                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                {{--<a type="button" 
                                                href="{{ config('app.admin_url') }}/bankaccounts/{{ $account->id }}/edit" 
                                                class="m-btn m-btn m-btn--square btn btn-secondary">
                                                <i class="fa fa-edit m--font-info"></i>
                                            </a>--}}

                                             <a type="button" 
                                            href="{{url('admin/bankaccounts')}}/{{ $account->id }}" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-eye m--font-primary"></i>
                                        </a>

                                            <a type="button"  data-id = "{{ $account->id }}" 
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
            @if($list)
            <div> 
                <span>
                    <span>{{ __('admin.showing') }}</span>
                    {{($list->currentpage()-1)*$list->perpage()+1}} 
                    <span>{{ __('admin.to') }}</span> 
                    {{$list->currentpage()*$list->perpage()}}
                </span> 
                <span>{{ __('admin.from') }}</span>
                <span class="badge badge-info">{{ $list->total() }}</span>
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
     @if($list) 
     {{ $list->links() }}
     @endif
 </div>
</div>
<br>
@if(isset($query ) or isset($message))
<div>
    <a href="{{ config('app.admin_url') }}/bankaccounts" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif







@endsection