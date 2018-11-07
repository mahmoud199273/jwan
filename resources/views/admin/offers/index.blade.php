@extends('admin.layouts.index_layout' , ['title' => __('admin.offers') ,'route' => 'offers'])

@section('content')

<div class="row">
    <form class="m-form" action="{{url('admin/offer/search')}}" method="get" id="search_form">
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
                                {{ __('admin.offers') }}  
                            </h3>
                        </div>
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
                                    <th><b>{{ __('admin.influencer') }}</b></th>
                                    <th><b>{{ __('admin.user') }}</b></th>
                                    <th><b>{{ __('admin.campaign') }}</b></th>
                                    <th><b>{{ __('admin.cost') }}</b></th>
                                    <th><b>{{ __('admin.status') }}</b></th>
                                    <th><b>{{ __('admin.control') }}</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($offers)
                                @foreach ($offers as $row)
                                <tr>
                                    <th scope="row">{{ optional($row->influncer)->name}}</th>
                                    <th scope="row">{{ optional($row->user)->name }}</th>
                                    <th scope="row">{{ $row->campaign->title }}</th>
                                    <th scope="row">{{ $row->cost }}</th>
                                    <th scope="row">
                                        @if ($row->status == 0)
                                            {{  __('admin.new_offer') }}
                                        @elseif ($row->status == 1)
                                            {{ __('admin.accepted') }}
                                        @elseif ($row->status == 2)
                                            {{ __('admin.refused') }}   
                                        @elseif ($row->status == 3)
                                            {{ __('admin.pay') }}
                                        @elseif ($row->status == 4)
                                            {{ __('admin.in_progress') }}
                                        @elseif ($row->status == 5)
                                            {{ __('admin.proof_submitted') }}
                                        @elseif ($row->status == 6)
                                            {{ __('admin.proof_accepted') }}
                                        @else
                                            {{ __('admin.done') }}
                                        @endif
                                    </th>
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a type="button" 
                                            href="{{url('admin/offers')}}/{{ $row->id }}" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-eye m--font-primary"></i>
                                        </a>
                                        <a type="button" 
                                            href="{{url('admin/offers')}}/{{ $row->id }}/edit" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-edit m--font-info"></i>
                                        </a>
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
             @if($offers)
            <div> 
                <span>
                    <span>{{ __('admin.showing') }}</span>
                    {{($offers->currentpage()-1)*$offers->perpage()+1}} 
                    <span>{{ __('admin.to') }}</span> 
                    {{$offers->currentpage()*$offers->perpage()}}
                </span> 
                <span>{{ __('admin.from') }}</span>
                <span class="badge badge-info">{{ $offers->total() }}</span>
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
       @if($offers)
       {{ $offers->links() }}
       @endif
   </div>
</div>
<br>
@if(isset($query ) or isset($message))
<div>
    <a href="{{url('admin/offers')}}" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif






@endsection