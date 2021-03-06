@extends('admin.layouts.index_layout',['title' => __('admin.influencers') ])

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
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                   {{ __('admin.add') }} | {{ __('admin.influencers') }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/influencers')}}" method="post" enctype="multipart/form-data">
       
            {{ csrf_field() }}
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

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.name') }}" value="{{ old('name') }}">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('phone') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.phone') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.phone') }}" name="phone" value="{{ old('phone') }}">
                    {!! $errors->first('phone', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

             <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.Type') }}</label>
                 <div class="col-9">
                <select name="type"  class="form-control m-input">
                   <option value="0"> {{ __('admin.Government') }} </option>
                   <option value="1"> {{ __('admin.Private sector') }} </option>
                   <option value="2"> {{ __('admin.Personal') }} </option>
                </select>
                    {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.email') }}</label>
                <div class="col-9">
                    <input type="email" class="form-control m-input" 
                            placeholder="{{ __('admin.email') }}" name="email" value="{{ old('email') }}">
                    {!! $errors->first('email', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('password') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.password') }}</label>
                <div class="col-9">
                    <input type="password" name="password" 
                                class="form-control m-input" placeholder="{{ __('admin.password') }}" >
                    {!! $errors->first('password', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('notes') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.notes') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.notes') }}" name="notes">{{ old('notes') }}</textarea>
                    {!! $errors->first('notes', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                <div class="col-9">
                    <input type="file" name="image" class="form-control m-input" placeholder="{{ __('admin.image') }}">
                    {!! $errors->first('image', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            
            <div class="form-group m-form__group row {{ $errors->has('is_active') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input">
                   <option value="1"> {{ __('admin.active') }} </option>
                   <option value="0"> {{ __('admin.in-active') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            

            
            <div class="form-group m-form__group row {{ $errors->has('gender') ? 'has-danger' : ''}}">
                <label for="gender" class="col-2 col-form-label">{{ __('admin.gender') }}</label>
                 <div class="col-9">
                <select name="gender"  class="form-control m-input">
                   <option value="0"> {{ __('admin.male') }} </option>
                   <option value="1"> {{ __('admin.female') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
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
                        <a type="reset" href="{{url('admin/influencers')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection