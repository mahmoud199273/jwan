
<div class="wBorder property" id="rest" style="display: none;">

    <h3 class="blue">مواصفات العقار</h3>
    <div class="form-group m-form__group row">

      <div class="col-sm-6">
         <div class="form-input">
            <label>{{ __('admin.hall_numbers') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
              name="hall_numbers" placeholder="{{ __('admin.hall_numbers') }}" value="{{ $meta_data['hall_numbers'] }}">
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
            <label>{{ __('admin.bathrooms_number') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
              name="bathrooms_number" placeholder="{{ __('admin.bathrooms_number') }}" value="{{ $meta_data['bathrooms_number'] }}">
          </div>
      </div>

      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.kitchen') }}</label><span class="orange">*</span>
          <select name="kitchen" class="form-control m-input">
            <option value="1" {{ ($meta_data['kitchen'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['kitchen'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.football_ground') }}</label><span class="orange">*</span>
          <select name="football_ground" class="form-control m-input">
            <option value="1" {{ ($meta_data['football_ground'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['football_ground'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.pool') }}</label><span class="orange">*</span>
          <select name="pool" class="form-control m-input">
            <option value="1" {{ ($meta_data['pool'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['pool'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>


      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.volleyball_ground') }}</label><span class="orange">*</span>
          <select name="volleyball_ground" class="form-control m-input">
            <option value="1" {{ ($meta_data['volleyball_ground'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['volleyball_ground'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.kids_area') }}</label><span class="orange">*</span>
          <select name="kids_area" class="form-control m-input">
            <option value="1" {{ ($meta_data['kids_area'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['kids_area'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>



      <div class="col-sm-6">
        <div class="itemDrop">
          <label>{{ __('admin.family_area') }}</label><span class="orange">*</span>
          <select name="family_area" class="form-control m-input">
            <option value="1" {{ ($meta_data['family_area'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['family_area'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>


  </div>
</div>