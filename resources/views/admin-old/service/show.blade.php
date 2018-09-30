@extends('admin.layouts.app')

@section('title',trans("lang.$module_name")." - ".trans("lang.".end($breadcrumb)))

@section('content')

<!-- Page-Title -->
@section('breadcrumb')
    @foreach ($breadcrumb as $bread)
        <li><a href="#">{{ $bread }}</a></li>
    @endforeach
@stop
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> {!!Lang::get("lang.$bread")!!} </h3>
                </div>
                {!! Form:: open(array('route' => ADMIN_PATH."/$route/create", 'files'=>true,'class' => 'ajax-form-request')) !!}
                    @include ("admin.$path.form",['submitButton' => Lang::get('lang.create')])
                {!! Form::close() !!}         
            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->                                                
    </div>            
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

@stop