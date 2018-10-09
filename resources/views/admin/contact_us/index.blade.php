@extends('admin.layouts.index_layout' , ['title' => __('admin.contact_us') ,'route' => 'complaints'])

@section('content')


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
                                <i class="la la-envelope"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{ __('admin.contact_us') }}  
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
                                    <th><b>{{ __('admin.name') }}</b></th>
                                    <th><b>{{ __('admin.sent_at') }}</b></th>
                                    <th><b>{{ __('admin.control') }}</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($complaints)
                                @foreach ($complaints as $complaint)
                                <tr>
                                    <th scope="row">{{ $complaint->title }}</th>
                                    <th scope="row">{{ $complaint->user->name }}</th>
                                    <th scope="row">{{ $complaint->created_at }}</th>
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a type="button" 
                                            href="{{url('admin/complaints')}}/{{ $complaint->id }}" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-eye m--font-info"></i>
                                        </a>

                                        <a type="button"  data-id = "{{ $complaint->id }}" 
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

        </div>


    </div>
    <!--end::Portlet-->
</div>
</div>

<div class="container">
    <div class="text-center">
       @if($complaints)
       {{ $complaints->links() }}
       @endif
   </div>
</div>







@endsection