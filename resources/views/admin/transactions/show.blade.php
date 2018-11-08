@extends('admin.layouts.index_layout',['title' => __('admin.transactions') ])

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
                   {{ $row->name }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{ config('app.admin_url') }}/transactions/{{ $row->id }}" method="post" enctype="multipart/form-data">
       
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

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.name') }}" name="name" disabled>{{ $row->name }}</textarea>
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('amount') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.amount') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.amount') }}" name="amount" disabled>{{ $row->amount }}</textarea>
                    {!! $errors->first('amount', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            

            <div class="form-group m-form__group row {{ $errors->has('direction') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.direction') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.direction') }}" name="direction" disabled>{{ $row->direction }}</textarea>
                    {!! $errors->first('direction', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('title') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.title') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.title') }}" name="title" disabled>{{ $row->title }}</textarea>
                    {!! $errors->first('title', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('cost') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.cost') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.cost') }}" name="cost" disabled>{{ $row->cost }}</textarea>
                    {!! $errors->first('cost', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('status') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.status') }}" name="status" disabled>{{ $row->status }}</textarea>
                    {!! $errors->first('status', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('transaction_bank_name') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_bank_name') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_bank_name') }}" name="transaction_bank_name" disabled>{{ $row->transaction_bank_name }}</textarea>
                    {!! $errors->first('transaction_bank_name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('transaction_account_name') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_account_name') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_account_name') }}" name="privacy_title" disabled>{{ $row->transaction_account_name }}</textarea>
                    {!! $errors->first('transaction_account_name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('transaction_account_number') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_account_number') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_account_number') }}" name="privacy_title_ar" disabled>{{ $row->transaction_account_number }}</textarea>
                    {!! $errors->first('transaction_account_number', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('transaction_account_IBAN') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_account_IBAN') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_account_IBAN') }}" name="transaction_account_IBAN" disabled>{{ $row->transaction_account_IBAN }}</textarea>
                    {!! $errors->first('transaction_account_IBAN', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('transaction_number') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_number') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_number') }}" name="transaction_number" disabled>{{ $row->transaction_number }}</textarea>
                    {!! $errors->first('transaction_number', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('transaction_date') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_date') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_date') }}" name="influncer_privacy_title" disabled>{{ $row->transaction_date }}</textarea>
                    {!! $errors->first('transaction_date', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('transaction_amount') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_amount') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_amount') }}" name="transaction_amount" disabled>{{ $row->transaction_amount }}</textarea>
                    {!! $errors->first('transaction_amount', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.type') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.type') }}" name="type" disabled>{{ $row->type }}</textarea>
                    {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

  
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/transactions')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->


@endsection