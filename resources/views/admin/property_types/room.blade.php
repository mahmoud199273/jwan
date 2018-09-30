
<div class="wBorder property" id="room" style="display: none;">
    <h3 class="blue">مواصفات العقار</h3>
 


    <div class="form-group m-form__group row">
      <div class="col-sm-6">
       <div class="itemDrop">
          <label>{{ __('admin.furnished') }}</label><span class="orange">*</span>
          <select name="furnished" class="form-control m-input">
            <option value="1" {{ ($meta_data['furnished'] == '1') ? "selected" : "" }}>نعم</option>
            <option value="0" {{ ($meta_data['furnished'] == '0') ? "selected" : "" }}>لا</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-input">
            <label>{{ __('admin.property_age') }}</label><span class="orange">*</span>
            <input type="text" class="form-control m-input" 
              name="property_age" placeholder="{{ __('admin.property_age') }}" value="{{ $meta_data['property_age'] }}">
          </div>
      </div>
    </div>


 


</div>