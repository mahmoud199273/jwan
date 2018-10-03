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
                    {{ __('admin.edit') }} | {{ __('admin.ads') }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" 
    method="post" action="{{ config('app.admin_url') }}/ads/{{ $ad['id'] }}" enctype="multipart/form-data"  id="create_ad" name="create_ad">
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
        {{ method_field('PATCH') }}
        <div class="form-group m-form__group row">

            <div class="col-lg-6 {{ $errors->has('type') ? 'has-danger' : ''}}">
                <label>{{ __('admin.property_type') }}</label>
                <select name="property_type" id="property_type" class="form-control">
                    @if ($property_types)
                    @foreach ($property_types as $property)
                    <option value="{{ $property->key }}" 
                        data-key="{{  $property->key }}" {{ ($property->key == $ad['type_in_english'])? "selected" : "" }}>
                        {{ $property->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('type') }}</span>
                </div>

                <div class="col-lg-6 {{ $errors->has('price') ? 'has-danger' : ''}}">
                    <label class="">price</label>
                    <input type="text" class="form-control m-input" 
                    placeholder="price" name="price" value="{{ $ad['price'] }}">
                    <span class="m-form__help form-control-feedback">{{ $errors->first('price') }}</span>
                </div>

            </div>


            <div class="form-group m-form__group row">

                <div class="col-lg-6 {{ $errors->has('contract_type') ? 'has-danger' : ''}}">
                    <label>نوع  العقد</label>
                    <select name="contract_type" id="contract_type" class="form-control">
                        <option id="sale" value="sale" {{ ($ad['contract_type_en'] == 'sale')? "selected" : "" }}>بيع</option>
                        <option id="rent" value="rent" {{ ($ad['contract_type_en'] == 'rent')? "selected" : "" }}>ايجار</option>
                    </select>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('contract_type') }}</span>
                </div>

                <div class="col-lg-6 {{ $errors->has('rent_period') ? 'has-danger' : ''}}">
                    <label class="">مده الايجار</label>
                    <select name="rent_period" id="rent_period" class="form-control">
                        <option value="0"  selected disabled>اختر المدة</option>
                        <option value="3" {{ ($ad['rent_period'] == 3 ) ? "selected" : "" }}>3 شهور</option>
                        <option value="6" {{ ($ad['rent_period'] == 6 ) ? "selected" : "" }}>6 شهور</option>
                        <option value="9" {{ ($ad['rent_period'] == 9 ) ? "selected" : "" }}>9 شهور</option>
                        <option value="12" {{ ($ad['rent_period'] == 12 ) ? "selected" : "" }}>12شهر</option>
                    </select>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('rent_period') }}</span>
                </div>

            </div>




            <div class="form-group m-form__group row">
                <div class="col-lg-6 {{ $errors->has('contact_phone') ? 'has-danger' : ''}}">
                    <label>{{ __('admin.phone') }}</label>
                    <div class="m-input-icon m-input-icon--right">
                        <input type="text" class="form-control m-input" 
                        name="contact_phone" placeholder="{{ __('admin.phone') }}" value="{{ $ad['contact_phone'] }}">
                    </div>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('contact_phone') }}</span>
                </div>

                <div class="col-lg-6 {{ $errors->has('contact_time') ? 'has-danger' : ''}}">
                    <label>اوقات الاتصال</label>
                    <div class="m-input-icon m-input-icon--right">
                        <input type="text" class="form-control m-input" 
                        name="contact_time" placeholder="اوقات الاتصال" value="{{ $ad['contact_time'] }}">
                    </div>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('contact_time') }}</span>
                </div>
            </div>



            <div class="form-group m-form__group row">
                <div class="col-lg-6 {{ $errors->has('address') ? 'has-danger' : ''}}">
                    <label>{{ __('admin.address') }}</label>
                    <div class="m-input-icon m-input-icon--right">
                        <input type="text" class="form-control m-input" 
                        name="title" placeholder="{{ __('admin.address') }}" value="{{ $ad['title'] }}">

                    </div>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('address') }}</span>
                </div>

                <div class="col-lg-6 {{ $errors->has('size') ? 'has-danger' : ''}}">
                    <label>{{ __('admin.size') }}</label>
                    <div class="m-input-icon m-input-icon--right">
                        <input type="text" class="form-control m-input" 
                        name="size" placeholder="{{ __('admin.size') }}" value="{{ $ad['size'] }}">
                    </div>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('address') }}</span>
                </div>

                <div class="col-lg-12 {{ $errors->has('description') ? 'has-danger' : ''}}">
                    <label>{{ __('admin.description') }}</label>
                    <textarea name="description" 
                    class="form-control" 
                    placeholder="{{ __('admin.description') }}">{{ $ad['description'] }}</textarea>
                    <span class="m-form__help form-control-feedback">{{ $errors->first('description') }}</span>
                </div>

            </div>


            <div class="form-group m-form__group row">

                <div class="col-lg-12 {{ $errors->has('contract_image') ? 'has-danger' : ''}}">
                    <label>{{ __('admin.contract_image') }}</label>
                    <img src="{{ config('app.url') }}/{{ $ad['contract_image'] }}" class="form-control m-input" width="500" height="400">
                </div>
                <div class="col-lg-12 {{ $errors->has('contract_image') ? 'has-danger' : ''}}">
                    <label>تغير الصورة</label>
                    <input type="file" class="form-control" name="contract_image" accept="image/*"> 
                    <span class="m-form__help form-control-feedback">{{ $errors->first('contract_image') }}</span>
                </div>
            </div>


            <div class="form-group m-form__group row">
               <label>{{ __('admin.property_images') }}</label>
               @if($ad['images'])
               @foreach($ad['images'] as $image)
               <div class="col-lg-3 {{ $errors->has('contract_image') ? 'has-danger' : ''}}">
                <img src="{{ $image->image }}" class="form-control m-input" width="150" height="150">
                <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove_ad_image" data-id="{{ $image->id }}">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
            @endforeach
            @endif
        </div>

        <div class="form-group m-form__group row">

            <div class="col-lg-12 {{ $errors->has('images') ? 'has-danger' : ''}}">
                <ul >
                    <li><a >اضف صور العقار<i class="fas fa-image border"></i></a></li>
                </ul>
                <div class="">
                    <div class="" id="images">
                        <div class="col-xs-12 imgArray">
                            <input class="form-control uploadify" type="file" 
                                accept="image/*" multiple="multiple" name="images" id="ad_image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group m-form__group row">

            <div class="col-lg-6 {{ $errors->has('city') ? 'has-danger' : ''}}">
                <label>{{ __('admin.city') }}</label>
                <select name="city" class="form-control" id="city_id">
                    @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ ($city->id == $ad['city_id'])? "selected" : ""  }} >{{ $city->name }}</option>
                    @endforeach
                </select>
                <span class="m-form__help form-control-feedback">{{ $errors->first('city') }}</span>
            </div>

            <div class="col-lg-6 {{ $errors->has('area') ? 'has-danger' : ''}}">
                <label>{{ __('admin.area') }}</label>
                <select name="area" class="form-control" id="district_id">
                    @foreach ($districts as $area)
                    <option value="{{ $area->id }}" {{ ($area->id ==  $ad['city_id'])? "selected" : "" }}>{{ $area->name }}</option>
                    @endforeach
                </select>
                <span class="m-form__help form-control-feedback">{{ $errors->first('area') }}</span>
            </div>



            <div class="col-lg-12 {{ $errors->has('detailed_address') ? 'has-danger' : ''}}">
                <label>{{ __('admin.detailed_address') }}</label>
                <div class="m-input-icon m-input-icon--right">
                    <input type="text" class="form-control m-input" 
                    name="detailed_address" placeholder="{{ __('admin.detailed_address') }}" 
                    value="{{ $ad['address'] }}">
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
                <input type="hidden" name="lat" id="latitude" value="{{ $ad['lat'] }}">
                <input type="hidden" name="lng" id="longitude" value="{{ $ad['lng'] }}">
                <input type="text" placeholder="ابحث في الخريطة"  class="form-control" id="search_box" />
                <span class="input-group-btn">
                    <button class="btn blue" id="gmap_geocoding_btn">
                        <i class="fa fa-search"></i>
                    </span>
                </div><br>

                <div id="map" class="gmaps form-control" style="height: 500px;"> </div>
            </div>


            <div id="property_attributes">

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

<div id="hidden_attributes" style="display: none">
  @include('admin.property_types.villa'     , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.apartment' , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.land'      , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.rest'      , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.house'     , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.warehouse' , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.tent'      , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.room'      , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.building'  , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.farm'      , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.office'    , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.shop'      , [ 'meta_data' => $ad['meta_data'] ])
  @include('admin.property_types.other'     , [ 'meta_data' => $ad['meta_data'] ])
</div>

<!--end::Portlet-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $(function(){
        var attr = $('option:selected', this).attr('data-key');
        $('#'+attr).css('display','block');

        $('#hidden_attributes #'+attr).clone().appendTo("#property_attributes");

    });
    $('#property_type').on('change', function() {
        var attr = $('option:selected', this).attr('data-key');
        $('.property').css('display','none');
        $('#'+attr).css('display','block');
        $('#property_attributes .property').remove();
        $('#hidden_attributes #'+attr).clone().appendTo("#property_attributes");
    });

  

    $('.remove_ad_image').on('click' ,function(e) {
        e.preventDefault();
        img_id = $(this).attr('data-id');
         swal({
          title: 'هل تريد الاستمرار؟',
          confirmButtonText:  'نعم',
          cancelButtonText:  'لا',
          showCancelButton: true,
          showCloseButton: true,
          target: document.getElementById('rtl-container')
        }).then((result) => {
          if (result.value) {
                   $.ajax({
                        url: '{{ config('app.admin_url') }}/remove/image/'+ img_id,
                        type: 'POST',
                        data: {'_token': $('meta[name="csrf-token"]').attr('content') },
                        success: function( msg ) {
                            if ( msg.status === 'success' ) {
                              swal('تم الحذف','تم الحذف بنجاح','success');
                              window.location.reload();
                             }
                    },
                    error : function(){
                        swal("تم الالغاء", "حدث خطأ ما", "error");
                        window.location.reload();
                    },
                  });
          }else {
                    swal("تم الالغاء", "", "error");
                }
        });
    });
    
</script>

<script>


    var map;
    var marker;
    var searchBox;


    function initMap() {

        var riyadh = {lat: {{ $ad['lat'] }}, lng: {{ $ad['lng'] }} };
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: {{ $ad['lat'] }}, lng: {{ $ad['lng'] }} },
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

 <script type="text/javascript">
    $("#city_id").change(function(){
        var city_id = $(this).val();
        $.ajax({
            url: "{{ config('app.url') }}/ajax/districts/select/"+city_id,
            method: 'GET',
            success: function(data) {
              $("#district_id").html('');
              $("#district_id").html(data.options);
            }
        });
    });
</script>


@endsection