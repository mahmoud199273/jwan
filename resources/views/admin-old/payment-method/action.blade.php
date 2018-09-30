{!! Form::open(['method' => 'DELETE', 'route' => ["$route.destroy",$row->id], 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('id', $row->id) !!}

        <a href="{{ route("$route.edit",$row->id) }}" class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" title="@lang('lang.view')"><i class="icon-pencil box-title"></i></a>

        <button class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" title="@lang('lang.Delete')" type="submit" onclick="return confirm('@lang('lang.confirm Delete operation?')');"> <i class="icon-trash box-title"></i> </button>
{!! Form::close() !!}
