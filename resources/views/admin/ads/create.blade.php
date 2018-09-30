@extends('admin.layouts.index_layout',['title' => __('admin.ads') ,'route' => 'ads' ])

@section('content')

@if( session('status') )
<div class="m-alert m-alert--icon m-alert--air alert alert-success alert-dismissible fade show" role="alert">
    <div class="m-alert__icon">
        <i class="la la-warning"></i>
    </div>
    <div class="m-alert__text">
        <strong>{{ session('status') }}!</strong>
    </div>
    <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
</div>
@endif

<!--begin::Portlet-->
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="fa fa-bullhorn"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    {{ __('admin.add') }} | {{ __('admin.ads') }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" 
    method="post" action="{{ config('app.admin_url') }}/ads" enctype="multipart/form-data">
    <div class="m-portlet__body">

        @if($errors->any())
        <div class="m-alert m-alert--icon alert alert-danger" role="alert" id="m_form_1_msg">
            <div class="m-alert__icon">
                <i class="la la-warning"></i>
            </div>
            <div class="m-alert__text">
                {{ __('admin.fix_errors') }}
            </div>
            <div class="m-alert__close">
                <button type="button" class="close" data-close="alert" aria-label="Close">
                </button>
            </div>
        </div>
        @endif


        {{ csrf_field() }}
        <div class="form-group m-form__group row">

            <div class="col-lg-6 {{ $errors->has('type') ? 'has-danger' : ''}}">
                <label>{{ __('admin.property_type') }}</label>
                <select name="type" class="form-control" id="property_type">
                    @foreach (property_types() as $key => $type)
                    <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
                <span class="m-form__help form-control-feedback">{{ $errors->first('type') }}</span>
            </div>

            <div class="col-lg-6 {{ $errors->has('price') ? 'has-danger' : ''}}">
                <label class="">price</label>
                <input type="text" class="form-control m-input" 
                placeholder="price" name="price" value="{{ old('price') }}">
                <span class="m-form__help form-control-feedback">{{ $errors->first('price') }}</span>
            </div>

        </div>

        <div class="form-group m-form__group row">
            <div class="col-lg-12 {{ $errors->has('address') ? 'has-danger' : ''}}">
                <label>{{ __('admin.address') }}</label>
                <div class="m-input-icon m-input-icon--right">
                    <input type="text" class="form-control m-input" 
                    name="address" placeholder="{{ __('admin.address') }}" value="{{ old('address') }}">
                    <span class="m-input-icon__icon m-input-icon__icon--right">
                        <span>
                            <i class="la la-map-marker"></i>
                        </span>
                    </span>
                </div>
                <span class="m-form__help form-control-feedback">{{ $errors->first('address') }}</span>
            </div>

            <div class="col-lg-12 {{ $errors->has('description') ? 'has-danger' : ''}}">
                <label>{{ __('admin.description') }}</label>
                <textarea name="description" 
                class="form-control" 
                placeholder="{{ __('admin.description') }}">{{ old('description') }}</textarea>
                <span class="m-form__help form-control-feedback">{{ $errors->first('description') }}</span>
            </div>

        </div>


        <div class="form-group m-form__group row">

            <div class="col-lg-12 {{ $errors->has('contract_image') ? 'has-danger' : ''}}">
                <label>{{ __('admin.contract_image') }}</label>
                <input type="file" class="form-control" name="contract_image">
                <span class="m-form__help form-control-feedback">{{ $errors->first('contract_image') }}</span>
            </div>

            <div class="col-lg-12 {{ $errors->has('images') ? 'has-danger' : ''}}">
                <label >{{ __('admin.property_images') }}</label>
                <input type="file" class="form-control m-input" name="images[]" multiple>
                <span class="m-form__help form-control-feedback">{{ $errors->first('images') }}</span>
            </div>

        </div>


        <div class="form-group m-form__group row">

            <div class="col-lg-6 {{ $errors->has('city') ? 'has-danger' : ''}}">
                <label>{{ __('admin.city') }}</label>
                <select name="city" class="form-control">
                    @foreach (cities() as $key => $city)
                    <option value="{{ $key }}">{{ $city }}</option>
                    @endforeach
                </select>
                <span class="m-form__help form-control-feedback">{{ $errors->first('city') }}</span>
            </div>

            <div class="col-lg-6 {{ $errors->has('area') ? 'has-danger' : ''}}">
                <label>{{ __('admin.area') }}</label>
                <select name="area" class="form-control">
                    @foreach (areas() as $key => $area)
                    <option value="{{ $key }}">{{ $area }}</option>
                    @endforeach
                </select>
                <span class="m-form__help form-control-feedback">{{ $errors->first('area') }}</span>
            </div>



            <div class="col-lg-12 {{ $errors->has('address') ? 'has-danger' : ''}}">
                <label>{{ __('admin.detailed_address') }}</label>
                <div class="m-input-icon m-input-icon--right">
                    <input type="text" class="form-control m-input" 
                    name="detailed_address" placeholder="{{ __('admin.detailed_address') }}" 
                    value="{{ old('detailed_address') }}">
                    <span class="m-input-icon__icon m-input-icon__icon--right">
                        <span>
                            <i class="la la-map-marker"></i>
                        </span>
                    </span>
                </div>
                <span class="m-form__help form-control-feedback">{{ $errors->first('detailed_address') }}</span>
            </div>

        </div>

        <div class="form-group m-form__group row">

            <div class="font-red-thunderbird">
                <i class="fa fa-exclamation-circle"></i>
            يمكنك تحريك العلامة يدوياً</div>

            <br>
            <div class="input-group">
                <input type="hidden" name="lat" id="latitude">
                <input type="hidden" name="lng" id="longitude">
             <input type="text" placeholder="ابحث في الخريطة"  class="form-control" id="search_box" />
             <span class="input-group-btn">
                <button class="btn blue" id="gmap_geocoding_btn">
                    <i class="fa fa-search"></i>
                </span>
            </div><br>

            <div id="map" class="gmaps form-control" style="height: 500px;"> </div>
        </div>
        
        <div class="form-group m-form__group row property" id="villa" style="display: none;">
            <div class="col-lg-12">
                <label>{{ __('admin.villa') }}</label>

                
           <div class="row">
                <div class="col-sm-2">
                    <label class="m-checkbox">
                        <input type="checkbox" name="front_yard" value="1">درج داخلي
                        <span></span>
                    </label>
                </div>
                 
                <div class="col-sm-5">
                    <label>room number</label>
                    <input type="number" name="room_number">
                </div>

                <div class="col-sm-5">
                    <label>hall number</label>
                    <input type="number" name="hall_number">
                </div>
            </div>

             </div>
        </div>


        <div class="form-group m-form__group row property" id="house" style="display: none;">
            <div class="col-lg-12">
                <label>{{ __('admin.house') }}</label>
              <div>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox" name="front_yard">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>
                
              </div>


            </div>
        </div>


        <div class="form-group m-form__group row">
            <div class="col-lg-12">
                <label>{{ __('admin.others') }}</label>

            <div>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

              </div>

              <div>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>

                <label class="m-checkbox col-sm-2">
                    <input type="checkbox">درج داخلي
                    <span></span>
                </label>
                
              </div>


            </div>
        </div>


    </div>

    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a type="reset" href="{{ config('app.admin_url') }}/ads" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>

<!--end::Form-->
</div>

<!--end::Portlet-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
     $('#property_type').on('change', function() {
            var attr = $('option:selected', this).val();
            $('.property').css('display','none');
            $('#'+attr).css('display','block');
        });
</script>

<script>
    

var map;
var marker;
var searchBox;


function initMap() {
   
    var riyadh = {lat: 24.621427, lng: 46.658936};
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 24.621427, lng: 46.658936},
        zoom: 8
  });

    marker = new google.maps.Marker({
        position: riyadh,
        map: map,
        draggable: true
  });


    var input = document.getElementById('search_box');
    var searchBox = new google.maps.places.SearchBox(input);
    google.maps.event.addListener(searchBox ,'places_changed' ,function(){

      var places = searchBox.getPlaces();
      var bounds = new google.maps.LatLngBounds();
      var i , place;
      for ( i=0 ; place=places[i] ; i++) {
        bounds.extend(place.geometry.location);
        marker.setPosition(place.geometry.location);
  }
  map.fitBounds(bounds);
  map.setZoom(8);

});
    google.maps.event.addListener(marker ,'position_changed' ,function(){

      var lat = marker.getPosition().lat();
      var lng = marker.getPosition().lng();

      $('#latitude').val(lat);
      $('#longitude').val(lng);

});
}
</script>
 <script 
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ6YIJqQieEgnZj4JcKI7nyj4ecbOIXAU&libraries=places&callback=initMap"
      async defer>
</script>


@endsection