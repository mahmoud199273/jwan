<div class="m-portlet__body">

	<div class="form-group m-form__group row{{ $errors->has('name') ? ' has-error' : '' }}">
	    {!! Form::label('name', __('lang.name')) !!}
	    {!! Form::text('name', null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('name') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('email') ? ' has-error' : '' }}">
	    {!! Form::label('email', __('lang.email')) !!}
	    {!! Form::email('email', null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('email') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('phone') ? ' has-error' : '' }}">
	    {!! Form::label('phone', __('lang.phone')) !!}
	    {!! Form::text('phone', null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('phone') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('image') ? ' has-error' : '' }}">
	    {!! Form::label('image', __('lang.image')) !!}
	    {!! Form::file('image', ['class' => 'form-control m-input m-input--air m-input--pill']) !!}
	    <small class="text-danger">{{ $errors->first('image') }}</small>
	</div>


	<div class="form-group m-form__group row{{ $errors->has('notes') ? ' has-error' : '' }}">
	    {!! Form::label('notes', __('lang.notes')) !!}
	    {!! Form::textarea('notes', null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('notes') }}</small>
	</div>

	

	<div class="row m-form__group">
		
		<div class="col-md-6 form-group {{ $errors->has('countries_id') ? ' has-error' : '' }}">
		    {!! Form::label('countries_id', __('lang.country')) !!}
		    {!! Form::select('countries_id', $countries, null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
		</div>

		<div class="col-md-6 form-group {{ $errors->has('areas_id') ? ' has-error' : '' }}">
		    {!! Form::label('areas_id', __('lang.area')) !!}
		    {!! Form::select('areas_id', $areas, null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
		</div>

		<div class="col-md-6 form-group {{ $errors->has('categories_id') ? ' has-error' : '' }}">
		    {!! Form::label('categories_id', __('lang.categories')) !!}
		    {!! Form::select('categories_id', $categories, null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
		</div>


		<div class="col-md-6 form-group {{ $errors->has('nationality_id') ? ' has-error' : '' }}">
		    {!! Form::label('nationality_id', __('lang.nationality')) !!}
		    {!! Form::select('nationality_id', $nationality, null, ['class' => 'form-control m-input m-input--air m-input--pill', 'required' => 'required']) !!}
		</div>

		

	</div>


	<div class="form-group m-form__group row{{ $errors->has('gender') ? ' has-error' : '' }} ">
	    {!! Form::label('gender', __('lang.gender')) !!}
	    {!! Form::select('gender', $gender, null, ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('gender') }}</small>
	</div>


	<div class="form-group m-form__group row{{ $errors->has('type') ? ' has-error' : '' }} ">
	    {!! Form::label('type', __('lang.Type')) !!}
	    {!! Form::select('type', $type, null, ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('type') }}</small>
	</div>


	<div class="form-group m-form__group row{{ $errors->has('account_manger') ? ' has-error' : '' }} ">
	    {!! Form::label('account_manger', __('lang.Account manager')) !!}
	    {!! Form::select('account_manger', $account_manger, null, ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('account_manger') }}</small>
	</div>



	<div class="form-group m-form__group row{{ $errors->has('activation') ? ' has-error' : '' }} ">
	    {!! Form::label('activation', __('lang.activation')) !!}
	    {!! Form::select('is_active', $activation, null, ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('is_active') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('password') ? ' has-error' : '' }}">
		    {!! Form::label('password', __('lang.password')) !!}
		    {!! Form::password('password', ['class' => 'form-control m-input m-input--air m-input--pill']) !!}
		    <small class="text-danger">{{ $errors->first('password') }}</small>
		</div>

	{!! Form::hidden('type', 1); !!}

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



