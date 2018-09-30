
<div class="wBorder property" id="building" style="display: none;">
    <h3 class="blue">مواصفات العقار</h3>
 


    <div class="form-group m-form__group row">
      <div class="col-sm-6">
        <div class="form-input">
            <label>{{ __('admin.floors_number') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
              name="floors_number" placeholder="{{ __('admin.floors_number') }}" value="{{ $meta_data['floors_number'] }}">
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
          <label>{{ __('admin.street_width') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" 
            name="street_width" placeholder="{{ __('admin.street_width') }}" value="{{ $meta_data['street_width'] }}">
        </div>
      </div>

    </div>

</div>