<div class="m-portlet__body">

<div class="container">
		<div class="row">
		<div class="form-group  {{ $errors->has('name_ar') ? ' has-error' : '' }} col-6">
		    {!! Form::label('name_ar', __('lang.name_ar')) !!}
		    {!! Form::text('name_ar', null, ['class' => 'form-control', 'required' => 'required']) !!}
		    <small class="text-danger">{{ $errors->first('name_ar') }}</small>
		</div>
		<div class="form-group  {{ $errors->has('name_en') ? ' has-error' : '' }} col-6">
		    {!! Form::label('name_en', __('lang.name_en')) !!}
		    {!! Form::text('name_en', null, ['class' => 'form-control', 'required' => 'required']) !!}
		    <small class="text-danger">{{ $errors->first('name_en') }}</small>
		</div>
			<div class="form-group  {{ $errors->has('image') ? ' has-error' : '' }} col-6">
		    {!! Form::label('image', __('lang.image')) !!}
		    {!! Form::file('image', ['class' => 'form-control', 'required' => 'required']) !!}
		    <small class="text-danger">{{ $errors->first('image') }}</small>
		</div>
		<div class="form-group {{ $errors->has('activation') ? ' has-error' : '' }} col-6">
	        {!! Form::label('activation', __('lang.activation')) !!}
	        {!! Form::select('activation', [1 => __('lang.active'), 0=>__('lang.inactive')],null , ['class' => 'form-control', 'required' => 'required']) !!}
	        <small class="text-danger">{{ $errors->first('activation') }}</small>
	    </div>
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



