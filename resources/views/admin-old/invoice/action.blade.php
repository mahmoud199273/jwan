        {!! Form::open(['method' => 'DELETE', 'route' => ["$route.destroy",$row->id], 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('id', $row->id) !!}
        <a class="portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="@lang('lang.view')" href="{{ url(ADMIN_PATH."/invoice/$row->id") }}"> <i class="fa fa-eye"></i> </a>
        <button class="portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="@lang('lang.delete')" type="submit" onclick="return confirm('@lang('lang.confirm Delete operation?')');"> <i class="fa fa-trash"></i> </button>
{!! Form::close() !!}

