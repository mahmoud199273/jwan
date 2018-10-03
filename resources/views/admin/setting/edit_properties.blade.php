@extends('admin.layouts.index_layout' , ['title' => __('admin.property_type') ,'route' => 'properties'])

@section('content')

<div class="row">
</div>
<br>



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
                                <i class="fa fa-images"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                انواع العقارات 
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
                                        <th><b>{{ __('admin.name') }}</b></th>
                                        <th><b>{{ __('admin.image') }}</b></th>
                                        <th><b>تعديل الصورة</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($properties)
                                    @foreach ($properties as $property_type)
                                    <tr>
                                        <th scope="row">{{ $property_type->name }}</th>
                                        <td class="text-center">
                                            <img src="{{ config('app.url') }}/{{ $property_type->icon }}" height="50" width="150" class="img img-cirlce">
                                        </td>

                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <a type="button" 
                                                href="{{ config('app.admin_url') }}/property/images/{{ $property_type->id }}" 
                                                class="m-btn m-btn m-btn--square btn btn-secondary">
                                                <i class="fa fa-edit m--font-info"></i>
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








@endsection