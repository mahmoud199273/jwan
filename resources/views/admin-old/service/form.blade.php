<div class="m-portlet__body">

	<div class="form-group m-form__group row{{ $errors->has('title') ? ' has-error' : '' }}">
	    {!! Form::label('title', 'title') !!}
	    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('title') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('body') ? ' has-error' : '' }}">
	    {!! Form::label('body', 'Body') !!}
	    {!! Form::textarea('body', null, ['class' => 'form-control', 'required' => 'required']) !!}
	    <small class="text-danger">{{ $errors->first('body') }}</small>
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



