<div class="modal fade custom-modal custom-modal-lg" id="hotel_login_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#">
                <img src="{{ url('frontend/images/logo-lg.png') }}" alt="" class="logo-modal">
            </a>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#login_hotel_tab" aria-controls="login_hotel_tab" role="tab" data-toggle="tab">تسجيل الدخول</a></li>
                    <li role="presentation" class=""><a href="#hotel_tab_register" aria-controls="hotel_tab_register" role="tab" data-toggle="tab">اضف فندقك الخاص</a></li>
                </ul>
                <!-- Tab panes   -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active  pr30 pl30 pt30 pb30" id="login_hotel_tab">
                        <h4>دخول <span class="text-color">أصحاب الفنادق</span>   </h4>
                        <p class="mb15 font-16 bold">                        سجل الدخول لتقوم بإدارة الفندق الخاص بك , ومتابعة الحجوزات والزبائن لتقديم افضل الخدمات والعروض بالاضافة لامكانية التحكم باسعار الغرف وتحديد الخدمات المراد توفيرها للزبائن أو يمكنك انشاء حساب خاص لفندقك الأن .</p>
                        {!! Form::open(['route'=>'hotel.login']) !!}
                            <div class="form-group">
                                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>trans('lang.email')]) !!}
                                <span></span>
                            </div>
                            <div class="form-group">
                                {!! Form::password('password',['class'=>'form-control','placeholder'=>trans('lang.password')]) !!}
                                <span></span>
                            </div>
                            <div class="flex-between mb10">
                                <div class="form-group input-box">
                                    <label class="check-label">
                                        <input name="remember" type="checkbox">
                                        <span class="fa fa-check"></span>
                                    </label>
                                    <span>@lang('lang.rememberme') ؟ </span>
                                </div>
                                <!-- inprogress -->
                                <a href="#" data-toggle="modal" data-target="#forget_password_modal_hotel" data-dismiss="modal">@lang('lang.iforgetmypassword') </a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-blue btn-block">
                                    @lang('lang.login')
                                </button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div role="tabpanel" class="tab-pane  pr30 pl30 pt30 pb30" id="hotel_tab_register">
                        <h4>اضف <span class="text-color">فندقك الخاص</span> </h4>
                        <p class="mb15"> قم بإضافة فندقك الخاص وتابع الحجوزات والزبائن وقدم  أفضل الخدمات والعروض لدينا .</p>
                        {!! Form::open(['route'=>'hotel.register']) !!}
                            {{-- <h5 class="text-color">معلومات شخصيه</h5> --}}

                             {{-- <div class="form-group">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>trans('lang.name')]) !!}
                                <span></span>
                            </div> --}}
                            <div class="form-group">
                                {!! Form::text('hotel_name',null,['class'=>'form-control','placeholder'=>trans('lang.hotel_name')]) !!}
                                <span></span>
                            </div>


                             <div class="form-group">
                                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>trans('lang.email')]) !!}
                                <span></span>
                            </div>

                            <div class="form-group">
                                {!! Form::input('tel','phone',null,['class'=>'form-control','placeholder'=>trans('lang.phone')]) !!}
                                <span></span>
                            </div>

                            <div class="form-group">
                                {!! Form::password('password',['class'=>'form-control','placeholder'=>trans('lang.password')]) !!}
                                <span></span>
                            </div>
                            @inject('cities_list', 'App\Models\City')
                            <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                {!! Form::label('city_id', trans('lang.city')) !!}
                                {!! Form::select('city_id', $cities_list->active()->pluck('name_ar', 'id'), null, ['id' => 'city_id', 'class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('city_id') }}</small>
                            </div>
                            {{-- <div class="form-group">
                                {!! Form::text('address',null,['class'=>'form-control','placeholder'=>trans('lang.address')]) !!}
                                <span></span>
                            </div> --}}


                            <div class="form-group">
                                <button type="submit" class="btn btn-blue btn-block">
                                    @lang('lang.signup')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <p class="copy_right_modal">جميع الحقوق محفوظة لسرير .كوم © 2018</p>
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal"><i class="fa fa-times"></i></button>
        </div>
    </div>
</div>

@push('script')
    @if (request('action') == 'login_hotel')
        <script>
            $(document).ready(function() {
                $("#hotel_login_modal").modal('show');
            });
        </script>
    @endif

    @if (request('action') == 'register_hotel')
        <script>
            $(document).ready(function() {
                $("#hotel_login_modal").modal('show');
                $('a[href="#hotel_tab_register"]').tab('show');
            });
        </script>
    @endif
@endpush
