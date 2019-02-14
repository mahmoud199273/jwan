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
            <input type="hidden" name="account_type" value="1" />
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
                    <input type="text" class="form-control m-input allownumericwithoutdecimal" 
                            placeholder="{{ __('admin.phone') }}" name="phone" value="{{ old('phone') }}">
                    {!! $errors->first('phone', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('countries_id') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.country') }}</label>
                 <div class="col-9">
                <select name="countries_id"  class="form-control m-input">
                    @if($countries)
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"> {{ $country->name_ar }}</option>
                        @endforeach
                    @endif
                </select>
                    {!! $errors->first('countries_id', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('nationality_id') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.natoinality') }}</label>
                 <div class="col-9">
                <select name="nationality_id"  class="form-control m-input">
                    @if($nationalities)
                        @foreach ($nationalities as $row)
                            <option value="{{ $row->id }}"> {{ $row->name_ar }}</option>
                        @endforeach
                    @endif
                </select>
                    {!! $errors->first('nationality_id', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

             {{--  <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.Type') }}</label>
                 <div class="col-9">
                <select name="type"  class="form-control m-input">
                   <option value="0"> {{ __('admin.Government') }} </option>
                   <option value="1"> {{ __('admin.Personal') }} </option>
                   <option value="2"> {{ __('admin.Private sector') }} </option>
                </select>
                    {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>  --}}

            <div class="form-group m-form__group row {{ $errors->has('account_manger') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.account_manger') }}</label>
                 <div class="col-9">
                <select name="account_manger"  class="form-control m-input">
                   <option value="0"> {{ __('admin.manager') }} </option>
                   <option value="1"> {{ __('admin.PersonalYou') }} </option>
                </select>
                    {!! $errors->first('account_manger', '<span class="form-control-feedback">:message</span>') !!}
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
                <label for="gender" class="col-2 col-form-label">{{ __('admin.accout_type') }}</label>
                 <div class="col-9">
                <select name="gender"  class="form-control m-input">
                   <option value="0"> {{ __('admin.accout_type0') }} </option>
                   <option value="1"> {{ __('admin.accout_type1') }} </option>
                   <option value="2"> {{ __('admin.accout_type2') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

             <div class="form-group m-form__group row {{ $errors->has('facebook') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Facebook url</label>
                <div class="col-9">
                    <input type="text" name="facebook" placeholder="facebook" class="form-control m-input" 
                           value="{{ old('facebook') }}">
                    {!! $errors->first('facebook', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            
            <div class="form-group m-form__group row {{ $errors->has('facebook_followers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Facebook Followers</label>
                <div class="col-9">
                    <input type="number" name="facebook_follwers" class="form-control m-input allownumericwithoutdecimal" 
                           value="{{ old('facebook_follwers') }}" placeholder="{{ __('admin.facebook_followers') }}">
                    {!! $errors->first('facebook_followers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            
            <div class="form-group m-form__group row {{ $errors->has('twitter') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Twitter url</label>
                <div class="col-9">
                    <input type="text" name="twitter" class="form-control m-input" 
                           value="{{ old('twitter') }}"  placeholder="twitter">
                    {!! $errors->first('twitter', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('twitter_followers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Twitter followers</label>
                <div class="col-9">
                    <input type="number" name="twitter_follwers" class="form-control m-input allownumericwithoutdecimal" 
                           value="{{ old('twitter_follwers') }}"  placeholder="{{ __('admin.twitter_followers') }}">
                    {!! $errors->first('twitter_followers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('instagram') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">instagram url</label>
                <div class="col-9">
                    <input type="text" name="instgrame" class="form-control m-input" 
                           value="{{ old('instgrame') }}"  placeholder="{{ __('admin.instagram') }}">
                    {!! $errors->first('instagram', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('instagram_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Instagram Followers</label>
                <div class="col-9">
                    <input type="number" name="instgrame_follwers" class="form-control m-input allownumericwithoutdecimal" 
                           value="{{ old('instgrame_follwers') }}" placeholder="{{ __('admin.instagram_follwers') }}">
                    {!! $errors->first('instagram_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('snapchat') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Snapchat url</label>
                <div class="col-9">
                    <input type="text" name="snapchat" class="form-control m-input" 
                           value="{{ old('snapchat') }}" placeholder="{{ __('snapchat') }}">
                    {!! $errors->first('snapchat', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('snapchat_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Snapchat Followers</label>
                <div class="col-9">
                    <input type="number" name="snapchat_follwers" class="form-control m-input allownumericwithoutdecimal" 
                           value="{{ old('snapchat_follwers') }}" placeholder="{{ __('admin.snapchat_follwers') }}">
                    {!! $errors->first('snapchat_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('class') ? 'has-danger' : ''}}">
                <label for="class" class="col-2 col-form-label">{{ __('admin.class') }}</label>
                 <div class="col-9">
                <select name="class"  class="form-control m-input" >
                   <option value="A" > A  </option>
                   <option value="B" > B  </option>
                   <option value="C" > C  </option>
                   <option value="D" > D  </option>
                </select>
                    {!! $errors->first('class', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            
            <div class="form-group m-form__group row">
                <label for="example-text-input" class="col-2 col-form-label"> {{ __('admin.commission') }} </label>
                <div class="col-9">
                    <input type="text" name="user_commission" 
                                class="form-control m-input allownumericwithoutdecimal" placeholder="{{ __('admin.commission') }}" >
                    <span style="font-size:16px;color:red"> ملحوظة : اذا تركت القيمة فارغة سيتم التعامل بمبلغ العمولة من الاعدادات </span>
                </div>
            </div>
            
            {{-- <div class="form-group m-form__group row {{ $errors->has('linkedin') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">linkedin</label>
                <div class="col-9">
                    <input type="text" name="linkedin" class="form-control m-input" 
                           value="{{ old('linkedin') }}" placeholder="{{ __('admin.instagram_follwers') }}">
                    {!! $errors->first('linkedin', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('linkedin_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">linkedin Followers</label>
                <div class="col-9">
                    <input type="number" name="linkedin_follwers" class="form-control m-input allownumericwithoutdecimal" 
                           value="{{ old('linkedin_follwers') }}" placeholder="{{ __('admin.instagram_follwers') }}">
                    {!! $errors->first('linkedin_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('youtube') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Youtube</label>
                <div class="col-9">
                    <input type="text" name="youtube" class="form-control m-input" 
                           value="{{ old('youtube') }}" placeholder="{{ __('admin.instagram_follwers') }}">
                    {!! $errors->first('youtube', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('youtube_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Youtube Followers</label>
                <div class="col-9">
                    <input type="number" name="youtube_follwers" class="form-control m-input allownumericwithoutdecimal" 
                           value="{{ old('youtube_follwers') }}" placeholder="{{ __('admin.instagram_follwers') }}">
                    {!! $errors->first('youtube_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div> --}}

            <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                    <div class="col-9">
                            <input type="hidden" name="image" id="file" class="form-control m-input" placeholder="{{ __('admin.image') }}">
                            {{--   upload image div   --}}
                            <div class="container">
                                    <div class="row" style="padding-top:10px;">
                                      <div class="col-xs-2">
                                        <button id="uploadBtn" class="btn btn-large btn-primary"> اختر ملف </button>
                                      </div>
                                      <div class="col-xs-10">
                                    <div id="progressOuter" class="progress progress-striped active" style="display:none;">
                                      <div id="progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                      </div>
                                    </div>
                                      </div>
                                    </div>
                                    <div class="row" style="padding-top:10px;">
                                      <div class="col-xs-10">
                                        <div id="msgBox">
                                        </div>
                                      </div>
                                    </div>
                                    <img src="" id="image_file" width="100" height="100" style="display:none;">
                                </div>
      
                                {{--   upload image div   --}}
                        {!! $errors->first('image', '<span class="form-control-feedback">:message</span>') !!}
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