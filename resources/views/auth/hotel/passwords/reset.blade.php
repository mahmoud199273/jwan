@extends('frontend.layouts.app')
@section('content')

       <div class="container">
           @include('frontend.partials.breadcrumb', ['lists' => [
                [
                    'name'=>trans('lang.Reset Password'),
                ],
            ]])
        </div>
        <div class="container">
        </div>
        <div class="container">
            <div class="gap"></div>
            <div class="row">
                <div class="col-xs-12 col-md-7">
                   <h3 class="text-color">
                       نحن هنا لمساعدتك !
                   </h3>
                   <h5> هل لديك أي استفسار ؟ يمكنك ارساله لنا</h5>
                    <p>
                        سرير.كوم موقع الكتروني متخصص في حجوزات فنادق مكة المكرمة والمدينة المنورة للحجاج والمعتمرين
                        والزائرين .
                    </p>
                    {!! Form::open(['class'=>'mt30', 'route'=>'hotel.password.request']) !!}
                    {!! Form::hidden('token', $token) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>@lang('lang.email')</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('lang.email')" required="">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>@lang('lang.password')</label>
                                    {!! Form::password('password',['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label>@lang('lang.password_confirmation')</label>
                                    {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-primary"> @lang('lang.Reset')</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-xs-12 col-md-4">
                    <aside class="sidebar-right">
                        <ul class="address-list list">
                            <li>
                                <h5>@lang('lang.email')</h5><a href="#">{{ $website_setting->email }}</a>
                            </li>
                            <li>
                                <h5>@lang('lang.phone')</h5><a href="#">{{ $website_setting->phone }}</a>
                            </li>
                            <li>
                                <h5>  @lang('lang.address')</h5>
                                <address class="text-color"> {{ $website_setting->col('address') }}</address>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
        <div class="gap"></div>
@endsection

