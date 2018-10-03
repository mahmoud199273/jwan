@extends('admin.layouts.index_layout',['title' => __('admin.prices') ])

@section('content')

@if( session('status') )
<div class="m-alert m-alert--icon m-alert--air alert alert-success alert-dismissible fade show" role="alert">
    <div class="m-alert__icon">
        <i class="la la-warning"></i>
    </div>
    <div class="m-alert__text">
        <strong>{{ session('status') }}!</strong>
    </div>
    <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
</div>
@endif

<!--begin::Portlet-->
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="fa fa-money-bill-alt"></i>
                </span>
                <h3 class="m-portlet__head-text">
                 {{ __('admin.edit') }} | {{ __('admin.prices') }}
             </h3>
         </div>
     </div>
 </div>

 <!--begin::Form-->
 <form class="m-form" action="{{ config('app.admin_url') }}/prices/{{ $price->id }}" method="post" enctype="multipart/form-data">

    {{ csrf_field() }}
            {{ method_field('PATCH') }}
    <div class="m-portlet__body">

        @if($errors->any())
        <div class="m-alert m-alert--icon alert alert-danger" role="alert" id="m_form_1_msg">
            <div class="m-alert__icon">
                <i class="la la-warning"></i>
            </div>
            <div class="m-alert__text">
                {{ __('admin.fix_errors') }}
            </div>
            <div class="m-alert__close">
                <button type="button" class="close" data-close="alert" aria-label="Close">
                </button>
            </div>
        </div>
        @endif


        <div class="form-group m-form__group row{{ $errors->has('type') ? 'has-danger' : ''}}">
            <label class="col-2 col-form-label">{{ __('admin.property_type') }}</label>
            <div class="col-9">

                <select name="type" class="form-control" id="property_type">
                    @foreach ($property_types as $type)
                    <option value="{{ $type->key }}" {{ ($type->key == $price->type) ? "selected" : "" }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <span class="m-form__help form-control-feedback">{{ $errors->first('type') }}</span>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('city') ? 'has-danger' : ''}}">
            <label class="col-2 col-form-label">{{ __('admin.city') }}</label>
            <div class="col-9">

                <select name="city_id" class="form-control" id="city_id">
                    @foreach ($cities as $city )
                    <option value="{{ $city->id }}" {{ ($city->id == $price->city_id) ? "selected" : "" }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <span class="m-form__help form-control-feedback">{{ $errors->first('city') }}</span>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('district_id') ? 'has-danger' : ''}}">
            <label class="col-2 col-form-label">{{ __('admin.district') }}</label>
            <div class="col-9">

                <select name="district_id" class="form-control" id="district_id">
                     @foreach ($districts as $district )
                    <option value="{{ $district->id }}" {{ ($district->id == $price->district_id) ? "selected" : "" }}>{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
            <span class="m-form__help form-control-feedback">{{ $errors->first('district_id') }}</span>
        </div>

            <div class="form-group m-form__group row">
            <label class="col-2 col-form-label">
                التاريخ
            </label>
            <div class="col-4">
                <input type='text' class="form-control" id="m_datepicker_1" 
                readonly placeholder="اختر التاريخ" name="date" value="{{ \Carbon\Carbon::parse($price->date)->format('d M Y - H:m') }}" />
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('first_half_price') ? 'has-danger' : ''}}">
            <label for="name" class="col-2 col-form-label">{{ __('admin.first_half') }}</label>
            <div class="col-9">
                <input type="text" name="first_half_price" class="form-control m-input" 
                placeholder="{{ __('admin.first_half') }}" value="{{ $price->first_half_price }}">
                {!! $errors->first('first_half_price', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

       

        <div class="form-group m-form__group row {{ $errors->has('second_half_price') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.second_half') }}</label>
            <div class="col-9">
                <input class="form-control m-input" placeholder="{{ __('admin.second_half') }}" name="second_half_price" value="{{ $price->second_half_price }}">
                {!! $errors->first('second_half_price', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>




    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-9">
                    <button type="submit" class="btn btn-brand">{{ __('admin.save') }}</button>
                    <a type="reset" href="{{ config('app.admin_url') }}/prices" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>

<!--end::Form-->
</div>

<!--end::Portlet-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

 <script type="text/javascript">
    $("#city_id").change(function(){
        var city_id = $(this).val();
        $.ajax({
            url: "{{ config('app.url') }}/ajax/districts/select/"+city_id,
            method: 'GET',
            success: function(data) {
              $("#district_id").html('');
              $("#district_id").html(data.options);
            }
        });
    });
</script>
@endsection