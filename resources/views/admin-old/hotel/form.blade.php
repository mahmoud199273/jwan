<div class="m-portlet__body">

	<div class="form-group m-form__group row{{ $errors->has('name') ? ' has-error' : '' }}">
	    {!! Form::label('name', __('lang.name')) !!}
	    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('name') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('email') ? ' has-error' : '' }}">
	    {!! Form::label('email', __('lang.email')) !!}
	    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('email') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('phone') ? ' has-error' : '' }}">
	    {!! Form::label('phone', __('lang.phone')) !!}
	    {!! Form::text('phone', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('phone') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('image') ? ' has-error' : '' }}">
	    {!! Form::label('image', __('lang.image')) !!}
	    {!! Form::file('image', ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('image') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('address') ? ' has-error' : '' }}">
	    {!! Form::label('address', __('lang.address')) !!}
	    {!! Form::text('address', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('address') }}</small>
	</div>




		<div class="col-md-12 form-group {{ $errors->has('city_id') ? ' has-error' : '' }}">
		    {!! Form::label('city_id', __('lang.city')) !!}
		    {!! Form::select('city_id', $cities, null, ['class' => 'form-control', 'required' => 'required']) !!}
		</div>
	<div class="form-group m-form__group row{{ $errors->has('password') ? ' has-error' : '' }}">
		    {!! Form::label('password', __('lang.password')) !!}
		    {!! Form::password('password', ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('password') }}</small>
		</div>

	{!! Form::hidden('type', 2); !!}

@if (isset($row))
		<hr>
		<h3 class="col-md-6">@lang('lang.Activation Status')</h3>
		<div class="col-md-6">
			<a href="{{ url("admin/hotel/update-status/$row->id?activation=0") }}" class="btn pull-left btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill {{ $row->activation == 0 ? 'm-btn--air' : '' }}">
	            <i class="fa fa-times"></i>
	        </a>

	        <a href="{{ url("admin/hotel/update-status/$row->id?activation=1") }}" class="btn pull-right btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill {{ $row->activation == 1 ? 'm-btn--air' : '' }}">
	            <i class="fa fa-check"></i>
	        </a>
	        <div class="clearfix"></div>
		</div>
	<hr>
@endif

</div>


<div class="m-portlet__foot m-portlet__foot--fit">
	<div class="m-form__actions m-form__actions">
		<div class="row">
			<div class="col-lg-7 ml-lg-auto">
				<button type="submit" class="btn btn-brand"> {{ $submitButton }} </button>
				<button type="reset" class="btn btn-secondary">
					@lang('lang.cancel')
				</button>
			</div>
		</div>
	</div>
</div>



