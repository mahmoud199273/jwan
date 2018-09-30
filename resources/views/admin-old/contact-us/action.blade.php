<a data-toggle="modal" href='#modal-{{ $row->id }}' class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="@lang('lang.view')"><i class="la la-eye"></i></a>

<div class="modal fade" id="modal-{{ $row->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lang.message')</h4>
            </div>
            <div class="modal-body">
                {{ $row->message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.Close')</button>
            </div>
        </div>
    </div>
</div>
