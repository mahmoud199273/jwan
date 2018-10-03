
<div class="wBorder property" id="other" style="display: none;">
    <h3 class="blue">اخرى</h3>
    


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
          <label>{{ __('admin.room_numbers') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="room_numbers" placeholder="{{ __('admin.room_numbers') }}" value="{{ $meta_data['room_numbers'] }}">
        </div>
      </div>

      <div class="col-sm-6">

        <div class="form-input">
          <label>{{ __('admin.hall_numbers') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="hall_numbers" placeholder="{{ __('admin.hall_numbers') }}" value="{{ $meta_data['hall_numbers'] }}">
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-input">
          <label>{{ __('admin.street_width') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="street_width" placeholder="{{ __('admin.street_width') }}" value="{{ $meta_data['street_width'] }}">
        </div>
      </div>
 
      <div class="col-sm-6">
        <div class="form-input">
          <label>{{ __('admin.bathrooms_number') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="bathrooms_number" placeholder="{{ __('admin.bathrooms_number') }}" value="{{ $meta_data['bathrooms_number'] }}">
        </div>
      </div>
      <div class="col-sm-6">

        <div class="form-input">
          <label>{{ __('admin.floor_number') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="floor_number" placeholder="{{ __('admin.floor_number') }}" value="{{ $meta_data['floor_number'] }}">
        </div>
        
      </div>

      <div class="col-sm-6">
        <div class="form-input">
          <label>{{ __('admin.property_age') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="property_age" placeholder="{{ __('admin.property_age') }}" value="{{ $meta_data['property_age'] }}">
        </div>
      </div>

  <div class="input-group">
      <div class="col-sm-3 col-xs-6">
        <label>
          <input type="checkbox" name="elevator" value="1" class="form-control m-input" {{ ($meta_data['elevator'] == '1') ? "checked" : "" }}/><span>{{ __('admin.elevator') }}</span>
        </label>
      </div>
      <div class="col-sm-3 col-xs-6">
        <label>
          <input type="checkbox" name="car_entrence" value="1" class="form-control m-input" {{ ($meta_data['car_entrence'] == '1') ? "checked" : "" }}/><span>{{ __('admin.car_entrence')  }}</span>
        </label>
      </div>

      <div class="col-sm-3 col-xs-6">
        <label>
          <input type="checkbox" name="kitchen" value="1" class="form-control m-input" {{ ($meta_data['kitchen'] == '1') ? "checked" : "" }}/><span>{{ __('admin.kitchen')  }}</span>
        </label>
      </div>

      <div class="col-sm-3 col-xs-6">
        <label>
          <input type="checkbox" name="furnished" value="1" class="form-control m-input" {{ ($meta_data['furnished'] == '1') ? "checked" : "" }}/><span>{{ __('admin.furnished')  }}</span>
        </label>
      </div>

    </div>
    </div>

</div>