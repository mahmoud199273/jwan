@extends('admin.layouts.index_layout' , ['title' => __('admin.ads') ,'route' => 'ads'])

@section('content')


<div class="row">
    <form class="m-form" action="{{ config('app.admin_url') }}/ad/search" method="get" id="search_form">
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
                                <i class="fa fa-bullhorn"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{ __('admin.ads') }}  
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

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
                                    <th><b>{{ __('admin.title') }}</b></th>
                                    <th><b>{{ __('admin.price') }}</b></th>
                                    <th><b>{{ __('admin.status') }}</b></th>
                                    <th><b>{{ __('admin.control') }}</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($ads)
                                @foreach ($ads as $ad)
                                <tr>
                                    <th scope="row">{{ $ad->title }}</th>
                                    <td>{{ $ad->price }}</td>
                                    <td class="text-center">{!! ($ad->is_active)? "<i class='fa fa-check m--font-success'></i>" : 
                                    "<i class='fa fa-times m--font-danger'></i>" !!}</td>
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a type="button" href="{{ config('app.admin_url') }}/ads/{{ $ad->id }}" class="m-btn m-btn m-btn--square btn btn-secondary">
                                                <i class="fa fa-eye m--font-primary"></i>
                                            </a>
                                            @if($ad->is_active)
                                            <a type="button" data-id = "{{ $ad->id }}"
                                                class="m-btn m-btn m-btn--square btn btn-secondary _ban">
                                                <i class="fa fa-times m--font-danger"></i>
                                            </a>
                                            @else
                                            <a type="button"  data-id = "{{ $ad->id }}" 
                                                class="m-btn m-btn m-btn--square btn btn-secondary _activate">
                                                <i class="fa fa-check m--font-success"></i>
                                            </a>
                                            @endif
                                            <a type="button" 
                                            href="{{ config('app.admin_url') }}/ads/{{ $ad->id }}/edit" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-edit m--font-info"></i>
                                        </a>

                                        <a type="button"  data-id = "{{ $ad->id }}" 
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

            @if($ads)
            <div> 
                <span>
                    <span>{{ __('admin.showing') }}</span>
                    {{($ads->currentpage()-1)*$ads->perpage()+1}} 
                    <span>{{ __('admin.to') }}</span> 
                    {{$ads->currentpage()*$ads->perpage()}}
                </span> 
                <span>{{ __('admin.from') }}</span>
                <span class="badge badge-info">{{ $ads->total() }}</span>
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
       @if($ads)
       {{ $ads->links() }}
       @endif
   </div>
</div>
<br>
@if(isset($query ) or isset($message))
<div>
    <a href="{{ config('app.admin_url') }}/ads" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif







@endsection