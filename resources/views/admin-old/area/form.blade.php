<div class="m-portlet__body">

	<div class="form-group m-form__group row{{ $errors->has('name_ar') ? ' has-error' : '' }}">
	    {!! Form::label('name_ar', __('lang.name_ar')) !!}
	    {!! Form::text('name_ar', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('name_ar') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('name') ? ' has-error' : '' }}">
	    {!! Form::label('name_en', __('lang.name_en')) !!}
	    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('name') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('countries_id') ? ' has-error' : '' }} ">
	    {!! Form::label('countries_id', __('lang.Country')) !!}
	    {!! Form::select('countries_id', $countries, null, ['class' => 'form-control m-select2', 'id' => 'm_select2_1']) !!}
	    <small class="text-danger">{{ $errors->first('countries_id') }}</small>
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



