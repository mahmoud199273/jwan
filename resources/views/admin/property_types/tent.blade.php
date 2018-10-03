<div class="wBorder property" id="tent" style="display: none;">

    <h3 class="blue">مواصفات العقار</h3>
    
     <div class="form-group m-form__group row">
      <div class="col-sm-6">
        <div class="form-input">
          <label>{{ __('admin.section') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" name="section" 
            placeholder="{{ __('admin.section') }}" id="section" value="{{ $meta_data['section'] }}">
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-input">
            <label>{{ __('admin.location') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
              name="location" placeholder="{{ __('admin.location') }}" id="location" value="{{ $meta_data['location'] }}">
          </div>
      </div>
    </div>


</div>