
<div class="wBorder property" id="land" style="display: none;">
    <h3 class="blue">مواصفات العقار</h3>
    <div class="form-group m-form__group row">

      <div class="col-sm-6">
        <div class="form-input">
          <label>{{ __('admin.front_yard') }}</label><span class="orange">*</span>
          <select name="front_yard" class="form-control m-input">
            <option value="شمالية" {{ ($meta_data['front_yard'] == 'شمالية') ? "selected" : "" }}>شمالية</option>
            <option value="شرقية" {{ ($meta_data['front_yard'] == 'شرقية') ? "selected" : "" }}>شرقية</option>
            <option value="غربية" {{ ($meta_data['front_yard'] == 'غربية') ? "selected" : "" }}>غربية</option>
            <option value="جنوبية" {{ ($meta_data['front_yard'] == 'جنوبية') ? "selected" : "" }}>جنوبية</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-input">
          <label>{{ __('admin.meter_price') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="meter_price" placeholder="{{ __('admin.meter_price') }}"  value="{{ $meta_data['meter_price'] }}">
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-input">
            <label>{{ __('admin.street_width') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
                name="street_width" placeholder="{{ __('admin.street_width') }}"  value="{{ $meta_data['street_width'] }}">
          </div>
      </div>
      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.attr_type') }}</label><span class="orange">*</span>
          <select name="attr_type" class="form-control m-input">
            <option value="commercial" {{ ($meta_data['commercial'] == '1') ? "selected" : "" }}>{{ __('admin.commercial') }}</option>
            <option value="housing" {{ ($meta_data['housing'] == '1') ? "selected" : "" }}>{{ __('admin.housing') }}</option>
          </select>
        </div>
      </div>
    </div>


</div>