<div class="m-portlet__body">

	<div class="form-group m-form__group {{ $errors->has('url') ? ' has-error' : '' }} col-md-12">
	    {!! Form::label('url', __('lang.url')) !!}
	    {!! Form::text('url', null, ['class' => 'form-control', 'id' => 'page_url','readonly']) !!}
	    <small class="text-danger">{{ $errors->first('url') }}</small>
	</div>

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('name_ar') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('name_ar', __('lang.name_ar')) !!}
		    {!! Form::text('name_ar', null, ['class' => 'form-control','readonly']) !!}
		    <small class="text-danger">{{ $errors->first('name_ar') }}</small>
		</div>

		<div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('name_en', __('lang.name_en')) !!}
		    {!! Form::text('name_en', null, ['class' => 'form-control','readonly']) !!}
		    <small class="text-danger">{{ $errors->first('name_en') }}</small>
		</div>
	</div>

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('content_ar') ? ' has-error' : '' }} col-md-12">
		    {!! Form::label('content_ar', __('lang.content_ar')) !!}
		    {!! Form::textarea('content_ar', null, ['class' => 'form-control summernote']) !!}
		    <small class="text-danger">{{ $errors->first('content_ar') }}</small>
		</div>

		<div class="form-group {{ $errors->has('content_en') ? ' has-error' : '' }} col-md-12">
		    {!! Form::label('content_en', __('lang.content_en')) !!}
		    {!! Form::textarea('content_en', null, ['class' => 'form-control summernote']) !!}
		    <small class="text-danger">{{ $errors->first('content_en') }}</small>
		</div>
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



