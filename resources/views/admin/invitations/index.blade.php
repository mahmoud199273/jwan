@extends('admin.layouts.index_layout' , ['title' => __('admin.invitations') ,'route' => 'invitations'])

@section('content')
<div class="row">
    <form class="m-form" action="{{url('admin/invitations/search')}}" method="get" id="search_form">
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
                                <i class="flaticon-avatar"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{ __('admin.invitations') }}  
                            </h3>
                        </div>
                    </div>
<!--                     <div class="m-portlet__head-tools">

                        <a href="{{url('admin/users/create')}}" class="btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                                    <th><b>{{ __('admin.email') }}</b></th>
                                    <th><b>{{ __('admin.phone') }}</b></th>
                                    <!-- <th><b>{{ __('admin.status') }}</b></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @if($invitations)
                                @foreach ($invitations as $invite)
                                <tr>
                                    <td>{{ $invite->email }}</td>
                                    <td>{{ $invite->phone }}</td>
<!--                                     <td class="text-center">{!! ($invite->status)? "<i class='fa fa-check m--font-success'></i>" : 
                                    "<i class='fa fa-times m--font-danger'></i>" !!}</td> -->
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            <!--end::Section-->
            @if($invitations)
            <div> 
                <span>
                    <span>{{ __('admin.showing') }}</span>
                    {{($invitations->currentpage()-1)*$invitations->perpage()+1}} 
                    <span>{{ __('admin.to') }}</span> 
                    {{$invitations->currentpage()*$invitations->perpage()}}
                </span> 
                <span>{{ __('admin.from') }}</span>
                <span class="badge badge-info">{{ $invitations->total() }}</span>
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
       @if($invitations)
       {{ $invitations->links() }}
       @endif
   </div>
</div>
<br>
@if(isset($query ) or isset($message))
<div>
    <a href="{{url('admin/invitations')}}" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif







@endsection