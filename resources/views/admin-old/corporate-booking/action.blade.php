<a data-toggle="modal" href='#modal-{{ $row->id }}' class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="@lang('lang.view')"><i class="la la-eye"></i></a>

<div class="modal fade" id="modal-{{ $row->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lang.Reservation')</h4>
            </div>
            <div class="modal-body">
                {!! Form::model($row) !!}

                    <div class="form-group row">
                            <div class="col-xs-12 col-md-6">
                                <label>@lang('lang.full_name')</label>
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>trans('lang.full_name'),'disabled']) !!}
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label>@lang('lang.email')</label>
                                {!! Form::text('email',null,['class'=>'form-control','placeholder'=>trans('lang.email'),'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 col-md-6">
                                <label>@lang('lang.phone')</label>
                                {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>trans('lang.phone'),'disabled']) !!}
                            </div>
                            <div class="col-xs-12 col-md-6">
                               <label>@lang('lang.country')</label>
                                {!! Form::text('country',$row->country_name,['class'=>'form-control','placeholder'=>trans('lang.country'),'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 col-md-12">
                                <label>@lang('lang.reservation_type')</label>
                                {!! Form::text('reservation_type',null,['class'=>'form-control','placeholder'=>trans('lang.reservation_type'),'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 col-md-6">
                                <label>@lang('lang.start_date')</label>
                                {!! Form::text('start_date',null,['class'=>'form-control','disabled']) !!}
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label>@lang('lang.end_date')</label>
                                {!! Form::text('end_date',null,['class'=>'form-control','disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('lang.message')</label>
                            {!! Form::textarea('message',null,['class'=>'form-control','disabled']) !!}
                        </div>


                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.Close')</button>
            </div>
        </div>
    </div>
</div>
