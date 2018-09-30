<div class="m-portlet__body">

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('name', __('lang.name')) !!}
		    {!! Form::text('name', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('name') }}</small>
		</div>

		<div class="form-group {{ $errors->has('url') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('url', __('lang.url')) !!}
		    {!! Form::text('url', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('url') }}</small>
		</div>
	</div>

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('icon') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('icon', __('lang.icon')) !!}
		    {!! Form::text('icon', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('icon') }}</small>
		</div>

		<div class="form-group {{ $errors->has('activation') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('activation', __('lang.activation')) !!}
	   		{!! Form::select('activation', $activation, null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('activation') }}</small>
		</div>
	</div>

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



