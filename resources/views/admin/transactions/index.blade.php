@extends('admin.layouts.index_layout' , ['title' => __('admin.transactions') ,'route' => 'transactions'])

@section('content')

<div class="row">
    <form class="m-form" action="{{ config('app.admin_url') }}/transaction/search" method="get" id="search_form">
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
                                <i class="fa fa-map"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{ __('admin.transactions') }}  
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                        <a href="{{url('admin/transactions/create')}}" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                                    <th><b>{{ __('admin.user_name') }}</b></th>

                                    <th><b>{{ __('admin.amount') }}</b></th>

                                    <th><b>{{ __('admin.direction') }}</b></th>

                                    <th><b>{{ __('admin.campaign_title') }}</b></th>

                                    <th><b>{{ __('admin.cost') }}</b></th>

                                    <th><b>{{ __('admin.status') }}</b></th>

                                    <th><b>{{ __('admin.transaction_bank_name') }}</b></th>

                                    <th><b>{{ __('admin.transaction_account_name') }}</b></th>

                                    <th><b>{{ __('admin.transaction_account_number') }}</b></th>

                                    <th><b>{{ __('admin.transaction_account_IBAN') }}</b></th>

                                    <th><b>{{ __('admin.transaction_number') }}</b></th>

                                    <th><b>{{ __('admin.transaction_date') }}</b></th>

                                    <th><b>{{ __('admin.transaction_amount') }}</b></th>

                                    <th><b>{{ __('admin.type')}}</b></th>

                                    <th><b>{{ __('admin.control') }}</b></th>

                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($list)
                                @foreach ($list as $row)
                                <tr>
                                    <th scope="row">{{ $row->name }}</th>
                                    <th scope="row">{{ $row->amount }}</th>
                                    <th scope="row">
                                        @if ($row->direction == 0)
                                            {{  __('admin.transaction_in') }}
                                        
                                        @else
                                            {{ __('admin.transaction_out') }}
                                        @endif

                                        

                                    </th>

                                    <th scope="row">{{ $row->title }}</th>
                                    <th scope="row">{{ $row->cost }}</th>
                                    <th scope="row">
                                        @if ($row->status == 0)
                                            {{  __('admin.transaction_pending') }}
                                        @elseif ($row->status == 1)
                                            {{ __('admin.transaction_approved') }}
                                        @elseif ($row->status == 2)
                                            {{ __('admin.transaction_rejected') }}   
                                        @elseif ($row->status == 3)
                                            {{ __('admin.transaction_finished') }}
                                        @elseif ($row->status == 4)
                                            {{ __('admin.transaction_canceled') }}
                                        
                                        @else
                                            {{ __('admin.transaction_closed') }}
                                        @endif


                                    </th>

                                    <th scope="row">{{ $row->transaction_bank_name }}</th>
                                    <th scope="row">{{ $row->transaction_account_name }}</th>
                                    <th scope="row">{{ $row->transaction_account_number }}</th>

                                    <th scope="row">{{ $row->transaction_account_IBAN }}</th>
                                    <th scope="row">{{ $row->transaction_number }}</th>

                                    <th scope="row">{{ $row->transaction_date }}</th>

                                    <th scope="row">{{ $row->transaction_amount }}</th>

                                    <th scope="row">
                                         @if ($row->type == 0)
                                            {{  __('admin.transaction_transfer') }}
                                        @elseif ($row->type == 1)
                                            {{ __('admin.transaction_approved') }}
                                        
                                        
                                        @else
                                            {{ __('admin.transaction_finished') }}
                                        @endif




                                    </th>

                                    
                                    
                                    <td>
                                        
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a type="button" 
                                            href="{{url('admin/transactions')}}/{{ $row->id }}" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-eye m--font-primary"></i>
                                        </a>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            {{--<a type="button" 
                                            href="{{url('admin/transactions')}}/{{ $row->id }}/edit" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-edit m--font-info"></i>
                                        </a>--}}
                                        @if($row->status==0)
                                            <a type="button" href="javascript:;" data-id = "{{ $row->id }}"
                                                class="m-btn m-btn m-btn--square btn btn-secondary _statusApprove">
                                                <i class="fa fa-times m--font-danger"></i>
                                            </a>
                                            @endif

                                        <a type="button"  data-id = "{{ $row->id }}" 
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
    <a href="{{url('admin/transactions')}}" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif






@endsection