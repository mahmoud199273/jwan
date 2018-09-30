{!! Form::open(['method' => 'DELETE', 'route' => ["$route.destroy",$row->id], 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('id', $row->id) !!}
        <a href="{{ route("$route.edit",$row->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="@lang('lang.view')"><i class="la la-edit"></i></a>

        {{-- <a class="btn btn-info btn-flat" href="{{ route("$route.edit",$row->id) }}"> <i class="fa fa-pencil"></i> @lang('lang.edit')</a> --}}
        <button class="portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="@lang('lang.Delete')" type="submit" onclick="return confirm('@lang('lang.confirm Delete operation?')');"> <i class="fa fa-trash"></i> </button>
{!! Form::close() !!}
