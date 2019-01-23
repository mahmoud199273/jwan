@extends('admin.layouts.index_layout',['title' => __('admin.campaign') ])

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
            <div class="m-portlet__head-name">
                <span class="m-portlet__head-icon m--hide">
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    {{ $campaign->title }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="#" method="post" enctype="multipart/form-data">
       
        <div class="m-portlet__body">

   

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.name') }}" value="{{ $campaign->user->name }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
   

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.email') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.email') }}" value="{{ $campaign->user->email }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.phone') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.phone') }}" value="{{ $campaign->user->phone }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.title') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.title') }}" value="{{ $campaign->title }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('maximum_rate') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.maximum_rate') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.maximum_rate') }}" value="{{ $campaign->maximum_rate }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.description') }}  </label>
                <div class="col-9">
                    <textarea class="form-control m-input" disabled="">{{ $campaign->description }}</textarea>
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.scenario') }}  </label>
                <div class="col-9">
                    <textarea class="form-control m-input" disabled="">{{ $campaign->scenario }}</textarea>
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.countries') }}  </label>
                <div class="col-9">
                   <select name="campaign_countries" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" data-action-onchange="true" disabled>
                       @foreach ($countries as $item)
                       <option value="{{$item->id}}" {{ $campaign_countries->contains($item->id)? "selected" : "" }} > {{$item->name_ar}} 
                        </option>
                       @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.categories') }}  </label>
                <div class="col-9">
                   <select name="campaign_categories" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" data-action-onchange="true" disabled>
                       @foreach ($categories as $item)
                       <option value="{{$item->id}}" {{ $campaign_categories->contains($item->id)? "selected" : "" }} > {{$item->name_ar}} 
                        </option>
                       @endforeach
                    </select>
                </div>
            </div>

            
            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.areas') }}  </label>
                <div class="col-9">
                   <select name="campaign_areas" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" data-action-onchange="true" disabled>
                       @foreach ($areas as $item)
                       <option value="{{$item->id}}" {{ $campaign_areas->contains($item->id)? "selected" : "" }} > {{$item->name_ar}} 
                        </option>
                       @endforeach
                    </select>
                </div>
            </div>


            
            <div class="form-group m-form__group row {{ $errors->has('facebook') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.facebook') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->facebook == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->facebook == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('twitter') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.twitter') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->twitter == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->twitter == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('snapchat') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.snapchat') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->snapchat == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->snapchat == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('youtube') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.youtube') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->youtube == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->youtube == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('instgrame') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.instgrame') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->instgrame == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->instgrame == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('male') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.male') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->male == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->male == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            
            <div class="form-group m-form__group row {{ $errors->has('female') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.female') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->female == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->female == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            
            <div class="form-group m-form__group row {{ $errors->has('general') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.general') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="1" {{ $campaign->general == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->general == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('status') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input" disabled="">
                   <option value="0" {{ $campaign->status == 0? "selected" : "" }} > {{  __('admin.new_campaign') }}</option>
                   <option value="1" {{ $campaign->status == 1? "selected" : "" }} > {{  __('admin.campaign_approved') }}</option>
                   <option value="2" {{ $campaign->status == 2? "selected" : "" }} > {{  __('admin.campaign_rejected') }}</option>
                   <option value="3" {{ $campaign->status == 3? "selected" : "" }} > {{  __('admin.campaign_finished') }}</option>
                   <option value="4" {{ $campaign->status == 4? "selected" : "" }} > {{  __('admin.campaign_canceled') }}</option>
                   <option value="5" {{ $campaign->status == 5? "selected" : "" }} > {{  __('admin.campaign_closed') }}</option>
                   
                </select>
                    {!! $errors->first('status', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            <h5 class="text-center">معلومات العروض</h5>

            <div class="tab-pane active" id="pending" role="tabpanel">

                @foreach($offers as $offer)
                

                        <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                    <div class="col-md-6">
                       <!--  <img src="{{url('')}}{{ str_replace('public/', '', $offer->influncer->image) }}" 
                            alt="{{ $offer->influncer->name }}" width="150" height="150" max-width="150" max-height="150" class="form-control"> -->

                            <img src="{{url('')}}{{ str_replace('public/', '', $offer->influncer->image)  }}" id="image_file" width="100" height="100" >

                            <span>
                                                         {{$offer->influncer->name}}:&nbsp; {{$offer->description }}
                                                         </span>
                                                        
                    </div>

                     <div class="col-md-2">
<!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                         عرض المحادثة
                        </button>
                        @foreach($chats as $chat)
                        @if($chat)
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">تفاصيل المحادثة</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <ul>
                                    <li> <!-- {{Crypt::decrypt($chat->content)}} --></li>


                                </ul> 
                               
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                        @endforeach
                                                        
                    </div>


                     </div>

                    </hr>


                @endforeach

            </div>
           
   


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/campaigns')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->
<script type="text/javascript">

$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})


</script>




@endsection