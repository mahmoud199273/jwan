<div class="row bg-row2">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <h4 id="kkk">@lang('lang.signin', ['variable' => 'replacement']) / @lang('lang.create account')</h4>

            @include('admin.errors')
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="thumbnai-page3 main-sec2">

                    <p>@lang('lang.create account') </p>

                   <form enctype="multipart/form-data"  role="form" method="POST" action="{{ route('register') }}">
                         {{ csrf_field() }}
                        <div class="form-group">
                                    {!! Form::select('type',[0=>trans('lang.client'),1=>trans('lang.office'),2=>trans('lang.owner')],null,['class'=>'form-control']) !!}
                        </div>
                         

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                {!! Form::text('owner_name',null,['class'=>'form-control','placeholder'=>trans('lang.owner_name')]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span>
                                </div>
                                {!! Form::text('mobile',null,['class'=>'form-control','placeholder'=>trans('lang.mobile')]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </div>
                                <input name="email" type="text" class="form-control"
                                       placeholder=" @lang('lang.email')">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                <input name="password" type="password" class="form-control" placeholder=" @lang('lang.password')">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <label> @lang('lang.image')</label>
                                <input name="image" type="file" class="form-control">
                            </div>
                        </div>

                         <div class="form-group">
                            {!! Form::text('company_name',null,['class'=>'form-control','placeholder'=>trans('lang.company_name')]) !!}
                        </div>

                           <div class="form-group">
                                <label for="commercial_record">@lang('lang.commercial_record')</label>
                                <input id="commercial_record" class="form-control" name="commercial_record" type="number" >
                            </div>
                            <div class="form-group">
                                <label for="number_of_emplyees">@lang('lang.number_of_emplyees')</label>
                                <input id="number_of_emplyees" class="form-control" name="number_of_emplyees" type="number" >


                            <div class="form-group">
                                {!! Form::label('description', trans('lang.description')) !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control','rows'=>3,'max'=>255]) !!}
                            </div>

                            <div class="form-group{{ $errors->has('map') ? ' has-error' : '' }}">
                                {!! Form::label('map', trans('lang.map')) !!}
                                {!! Form::input('url','map', null, ['class' => 'form-control']) !!}
                                <small class="text-danger">@lang('lang.google map url')</small>
                            </div>



                        <button type="submit" class="btn btn-danger">
                            <span class="glyphicon glyphicon-ok"></span> @lang('lang.create account')
                        </button>
                    </form>

</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="thumbnai-page3 main-sec2">
                    <p>@lang('lang.signin', ['variable' => 'replacement']) </p>
                    <form  role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </div>
                                     {!! Form::email('email',null,['class'=>'form-control','','placeholder'=>trans('lang.email')]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                 <input name="password" class="form-control" type="password" required="" placeholder="@lang('lang.password')">
                            </div>
                        </div>


                        <button type="submit" class="btn btn-info">
                            <span class="glyphicon glyphicon-log-in"></span> {{ trans('lang.login') }}
                        </button>
                    </form>


                </div>
            </div>

        </div>

    </div>

    <div class="col-md-1"></div>

</div>


    