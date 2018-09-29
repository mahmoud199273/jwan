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

    <div class="clearfix"></div>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        
                        @lang("lang.Edit $module_name")
                    </h3>
                </div>
            </div>
        </div>
            {!! Form:: model($row,['method'=>'PATCH','route' => ["$route.update",$row->id], 'files'=>true,'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
                @include ("$base_view.$path.form",['submitButton' => Lang::get('lang.update')])
            {!! Form::close() !!}
    </div>


@stop
