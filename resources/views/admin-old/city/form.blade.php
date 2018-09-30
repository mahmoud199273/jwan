<div class="m-portlet__body">

	<div class="form-group m-form__group row{{ $errors->has('name_ar') ? ' has-error' : '' }}">
	    {!! Form::label('name_ar', __('lang.name_ar')) !!}
	    {!! Form::text('name_ar', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('name_ar') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('name_en') ? ' has-error' : '' }}">
	    {!! Form::label('name_en', __('lang.name_en')) !!}
	    {!! Form::text('name_en', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('name_en') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('country_id') ? ' has-error' : '' }} ">
	    {!! Form::label('country_id', __('lang.country_id')) !!}
	    {!! Form::select('country_id', $countries, null, ['class' => 'form-control m-select2', 'id' => 'm_select2_1']) !!}
	    <small class="text-danger">{{ $errors->first('country_id') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('image') ? ' has-error' : '' }}">
	    {!! Form::label('image', __('lang.image')) !!}
	    {!! Form::file('image', ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('image') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('activation') ? ' has-error' : '' }} ">
	    {!! Form::label('activation', __('lang.activation')) !!}
	    {!! Form::select('activation', $activation, null, ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('activation') }}</small>
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



