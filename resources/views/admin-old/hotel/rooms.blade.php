@extends('admin.layouts.app')

@section('title',trans("lang.$module_name")." - ".end($breadcrumb))

@section('content')

    @section('breadcrumb')
        @foreach ($breadcrumb as $bread)
        @if ($loop->last)
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                    <span class="m-nav__link-text">
                        {{ $bread }}
                    </span>
            </li>

            @else
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{ url("$base_view/$route") }}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            @lang("lang.$bread")
                        </span>
                    </a>
                </li>
            @endif
        @endforeach
    @stop

    <div class="clearfix"></div><br>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <i class="icon-user box-title"></i> [ {{ $row->name }} ] @lang('lang.rooms')
                    </h3>
                </div>
            </div>
            
            @include('admin.hotel.additions')

        </div>
        <div class="m-portlet__body">
            
            <div class="row">
                
                @forelse($row->rooms as $room)
                    <div class="col-xl-6">
                        <div class="m-portlet m-portlet--full-height ">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            <i class="icon-home box-title"></i> {{ $room->name }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="m-widget13">
                                    <div class="row">
                                        <div class="m-widget13__item col-xl-6">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.type')  </span>
                                            <span class="m-widget13__text m-widget13__text-bolder"> {{ $room->room_type }} </span>
                                        </div>
                                        <div class="m-widget13__item col-xl-6">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.rooms')  </span>
                                            <span class="m-widget13__text m-widget13__text-bolder"> 
                                                {{ $room->number_rooms_in_hotel }} 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="m-widget13__item col-xl-6">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.smoking')  </span>
                                            <span class="m-widget13__text m-widget13__text-bolder">
                                                <span class="m-switch m-switch--icon m-switch--success">
                                                    <label>
                                                        @if($room->is_smooking)
                                                            <input type="checkbox" checked="checked" disabled>
                                                        @else
                                                            <input type="checkbox" disabled>
                                                        @endif
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="m-widget13__item col-xl-6">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.room area')  </span>
                                            <span class="m-widget13__text m-widget13__text-bolder"> {{ $room->area }} </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="m-widget13__item col-xl-12">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.Number of sleeping rooms')  </span>
                                            <span class="m-widget13__text m-widget13__text-bolder"> {{ $room->number_sleeping_rooms }} </span>
                                        </div>
                                        <div class="m-widget13__item col-xl-12">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.Number of living rooms')  </span>
                                            <span class="m-widget13__text m-widget13__text-bolder"> {{ $room->number_living_rooms }} </span>
                                        </div>
                                        <div class="m-widget13__item col-xl-12">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.Number of bath room') </span>
                                            <span class="m-widget13__text m-widget13__text-bolder"> {{ $room->number_bathroom }} </span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="m-widget13__item col-xl-12">
                                            <span class="m-widget13__desc m--align-right"> @lang('lang.Room rate per night')  </span>
                                            <span class="m-widget13__text m-widget13__text-bolder">  {{ $room->price }} </span>
                                        </div>
                                    </div>

                                    
                                   {{--  <div class="m-widget13__action m--align-right">
                                        <button type="button" class="m-widget__detalis  btn m-btn--pill  btn-accent">Detalis</button>
                                        <button type="button" class="btn m-btn--pill    btn-secondary">Update</button>                                           
                                    </div> --}}
                                </div>       
                            </div>
                        </div>
                    </div>
                @empty
                    <h3> <i class="icon-ban box-title"></i> @lang('lang.no rooms for this hotel') </h3>
                @endforelse
                

            </div>


        
        </div>
    </div>


@stop

