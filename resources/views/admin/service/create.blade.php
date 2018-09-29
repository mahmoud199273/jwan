@extends('admin.layouts.app')

@section('title',trans("lang.$module_name")." - ".trans("lang.".end($breadcrumb)))

@section('content')

    @section('breadcrumb')
        @foreach ($breadcrumb as $bread)
        @if ($loop->last)
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                    <span class="m-nav__link-text">
                        @lang("lang.$bread")
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
                        @lang("lang.$module_name")
                    </h3>
                </div>
            </div>
        </div>
            {!! Form:: open(['method'=>'POST','route' => "$route.store", 'files'=>true,'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
                <div class="m-portlet__body">

                        <div class="row m-form__group">
                            <div class="form-group {{ $errors->has('name_ar') ? ' has-error' : '' }} col-md-6">
                                {!! Form::label('name_ar', trans('lang.name_ar')) !!}
                                {!! Form::text('name_ar', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('name_ar') }}</small>
                            </div>
                            <div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }} col-md-6">
                                {!! Form::label('name_en', trans('lang.name_en')) !!}
                                {!! Form::text('name_en', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('name_en') }}</small>
                            </div>
                        </div>
                        {!! Form::hidden('activation', 1) !!}
                        {{-- <div class="form-group {{ $errors->has('activation') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('activation', trans('lang.activation')) !!}
                            {!! Form::select('activation', [1=>trans('lang.active'), 0=>trans('lang.inactive')],null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('activation') }}</small>
                        </div> --}}
                        {{-- <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('type', trans('lang.type')) !!}
                            {!! Form::select('type', ['one-select'=>trans('lang.one-select'), 'multi-select'=>trans('lang.multi-select')],null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('type') }}</small>
                        </div> --}}


                    <hr>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>@lang('lang.option_name_ar')</th>
                                <th>@lang('lang.option_name_en')</th>
                                <th>@lang('lang.image')</th>
                                <th>@lang('lang.remove')</th>
                            </tr>
                        </thead>
                        <tbody class="multi-input-option">
                            <tr class="target-row-option ">
                                <td>{!! Form::text('option_ar[]', null, ['class'=>'form-control', 'required' => 'required']) !!}</td>
                                <td>{!! Form::text('option_en[]', null, ['class'=>'form-control', 'required' => 'required']) !!}</td>
                                <td>{!! Form::text('image[]',null, ['class'=>'form-control']) !!}</td>
                                <td>
                                    <button data-toggle="duplicate-input" data-toggleclass="btn-danger btn-default" data-duplicate=".target-row-option" data-target=".multi-input-option" data-toggledata="<i class='fa fa-minus'> </i>" type="button" class="btn btn-default">
                                            <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>


                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-7 ml-lg-auto">
                                <button type="submit" class="btn btn-brand"> @lang('lang.create') </button>
                                <button type="reset" class="btn btn-secondary">
                                    @lang('lang.cancel')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
    </div>


@stop

@push('script')


    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('click','[data-toggle="duplicate-input"]',function(e){
                $item = $(this).data('duplicate');
                $item = $($item).last().clone();

                $item.find('input').val('');
                $item.find('textarea').val('');

                $target = $(this).data('target'); //get target

                console.log($item.find('[data-toggle="duplicate-input"]')
                    .children())
                $item.find('[data-toggle="duplicate-input"]')
                    .children().first()
                    .replaceWith($(this).data('toggledata'));

                $item.find('[data-toggle="duplicate-input"]')
                    .toggleClass($(this).data('toggleclass'))
                    .attr('data-toggle','remove-input');

                $($target).append($item);
            });

            $(document).on('click','[data-toggle="remove-input"]',function(e){
                $item = $(this).data('duplicate');
                $(this).closest($item).remove();

            });

        });


    </script>


@endpush
