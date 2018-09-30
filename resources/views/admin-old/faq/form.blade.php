<div class="m-portlet__body">

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('question_ar') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('question_ar', __('lang.question_ar')) !!}
		    {!! Form::text('question_ar', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('question_ar') }}</small>
		</div>

		<div class="form-group {{ $errors->has('question_en') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('question_en', __('lang.question_en')) !!}
		    {!! Form::text('question_en', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('question_en') }}</small>
		</div>
	</div>

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('answer_ar') ? ' has-error' : '' }} col-md-12">
		    {!! Form::label('answer_ar', __('lang.answer_ar')) !!}
		    {!! Form::textarea('answer_ar', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('answer_ar') }}</small>
		</div>

		<div class="form-group {{ $errors->has('answer_en') ? ' has-error' : '' }} col-md-12">
		    {!! Form::label('answer_en', __('lang.answer_en')) !!}
		    {!! Form::textarea('answer_en', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('answer_en') }}</small>
		</div>
	</div>
		<div class="row m-form__group">
		<div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }} col-md-12">
		    {!! Form::label('category_id', __('lang.category')) !!}
		    {!! Form::select('category_id',$categories_list, null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('category_id') }}</small>
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



