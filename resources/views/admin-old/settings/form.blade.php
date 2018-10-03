<div class="m-portlet__body">

	<hr> <h4 class="section-title"> <i class="m-menu__link-icon flaticon-coins"></i> @lang('lang.Taxs & Commission')  </h4> <hr>

	<div class="row">
		<div class="form-group m-form__group {{ $errors->has('texs_percentge') ? ' has-error' : '' }} col-6" style=" padding-top: 0;">
		    {!! Form::label('texs_percentge', __('lang.texs_percentge')) !!}
		    {!! Form::number('texs_percentge', null, ['class' => 'form-control','max'=>100,'min'=>0]) !!}
		    <small class="text-danger">{{ $errors->first('texs_percentge') }}</small>
		</div>
		<div class="form-group m-form__group {{ $errors->has('commission_percentage') ? ' has-error' : '' }} col-6">
		    {!! Form::label('commission_percentage', __('lang.commmission percentage')) !!}
		    {!! Form::number('commission_percentage', null, ['class' => 'form-control','max'=>100,'min'=>0]) !!}
		    <small class="text-danger">{{ $errors->first('commission_percentage') }}</small>
		</div>
	</div>



	<hr> <h4 class="section-title"> <i class="m-menu__link-icon flaticon-support"></i> @lang('lang.Contact Info') </h4> <hr>

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('email', __('lang.email')) !!}
		    {!! Form::text('email', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('email') }}</small>
		</div>

		<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('phone', __('lang.phone')) !!}
		    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('phone') }}</small>
		</div>
	</div>

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('address_ar') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('address_ar', __('lang.address_ar')) !!}
		    {!! Form::textarea('address_ar', null, ['class' => 'form-control', 'rows' => 3]) !!}
		    <small class="text-danger">{{ $errors->first('address_ar') }}</small>
		</div>

		<div class="form-group {{ $errors->has('address_en') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('address_en', __('lang.address_en')) !!}
		    {!! Form::textarea('address_en', null, ['class' => 'form-control', 'rows' => 3]) !!}
		    <small class="text-danger">{{ $errors->first('address_en') }}</small>
		</div>
	</div>

	<div class="row m-form__group">
		<div class="form-group {{ $errors->has('about_footer') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('about_footer', __('lang.about_footer')) !!}
		    {!! Form::textarea('about_footer', null, ['class' => 'form-control', 'rows' => 3]) !!}
		    <small class="text-danger">{{ $errors->first('about_footer') }}</small>
		</div>

		<div class="form-group {{ $errors->has('map_frame') ? ' has-error' : '' }} col-md-6">
		    {!! Form::label('map_frame', __('lang.map_frame')) !!}
		    {!! Form::textarea('map_frame', null, ['class' => 'form-control', 'rows' => 3]) !!}
		    <small class="text-danger">{{ $errors->first('map_frame') }}</small>
		</div>
	</div>

	<hr> <h4 class="section-title"> <i class="m-menu__link-icon flaticon-exclamation-1"></i> @lang('lang.Apps urls') </h4> <hr>

	<div class="form-group m-form__group row{{ $errors->has('play_store_url') ? ' has-error' : '' }}">
	    {!! Form::label('play_store_url', __('lang.play_store_url')) !!}
	    {!! Form::text('play_store_url', null, ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('play_store_url') }}</small>
	</div>

	<div class="form-group m-form__group row{{ $errors->has('app_store_url') ? ' has-error' : '' }}">
	    {!! Form::label('app_store_url', __('lang.app_store_url')) !!}
	    {!! Form::text('app_store_url', null, ['class' => 'form-control']) !!}
	    <small class="text-danger">{{ $errors->first('app_store_url') }}</small>
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



