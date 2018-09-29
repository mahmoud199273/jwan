{!! Form::open(['method' => 'DELETE', 'route' => ["$route.destroy",$row->id], 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('id', $row->id) !!}

        <a href="{{ route("$route.edit",$row->id) }}" class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" title="@lang('lang.Edit')"><i class="icon-pencil box-title"></i></a>

        {{--  <a href="{{ route("$route.show",$row->id) }}" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" title="@lang('lang.view')"><i class="icon-eye box-title"></i></a>  --}}


        {{-- <a class="btn btn-info btn-flat" href="{{ route("$route.edit",$row->id) }}"> <i class="fa fa-pencil"></i> @lang('lang.edit')</a> --}}
        <button class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" title="@lang('lang.Delete')" type="submit" onclick="return confirm('@lang('lang.confirm Delete operation?')');"> <i class="icon-trash box-title"></i> </button>
{!! Form::close() !!}
