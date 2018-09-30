
<div class="wBorder property" id="villa" style="display: none;">
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
          <label>{{ __('admin.room_numbers') }}</label><span class="orange">*</span>
          <input type="text" class="form-control m-input" name="room_numbers" 
            placeholder="{{ __('admin.room_numbers') }}" id="room_numbers" value="{{ $meta_data['room_numbers'] }}">
        </div>
      </div>

   
      <div class="col-sm-6">

          <div class="form-input">
            <label>{{ __('admin.hall_numbers') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
                name="hall_numbers" placeholder="{{ __('admin.hall_numbers') }}" id="hall_numbers" value="{{ $meta_data['hall_numbers'] }}">
          </div>
      </div>

      <div class="col-sm-6">
        <div class="form-input">
            <label>{{ __('admin.street_width') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
              name="street_width" placeholder="{{ __('admin.street_width') }}" id="street_width" value="{{ $meta_data['street_width'] }}">
          </div>
      </div>
 
      <div class="col-sm-6">
        <div class="form-input">
            <label>{{ __('admin.property_age') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
              name="property_age" placeholder="{{ __('admin.property_age') }}" id="property_age" value="{{ $meta_data['property_age'] }}">
          </div>
      </div>
      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.have_stairs') }}</label><span class="orange">*</span>
          <select name="have_stairs" class="form-control m-input">
            <option value="1" {{ ($meta_data['have_stairs'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['have_stairs'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>


      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.driver_room') }}</label><span class="orange">*</span>
          <select name="driver_room" class="form-control m-input">
            <option value="1" {{ ($meta_data['driver_room'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['driver_room'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.maid_room') }}</label><span class="orange">*</span>
          <select name="maid_room" class="form-control m-input">
            <option value="1" {{ ($meta_data['maid_room'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['maid_room'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>


      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.appendix') }}</label><span class="orange">*</span>
          <select name="appendix" class="form-control m-input">
            <option value="1" {{ ($meta_data['appendix'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['appendix'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.yard') }}</label><span class="orange">*</span>
          <select name="yard" class="form-control m-input">
            <option value="1" {{ ($meta_data['yard'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['yard'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>

   

      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.car_entrence') }}</label><span class="orange">*</span>
          <select name="car_entrence" class="form-control m-input">
            <option value="1" {{ ($meta_data['car_entrence'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['car_entrence'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>

    </div>


</div>