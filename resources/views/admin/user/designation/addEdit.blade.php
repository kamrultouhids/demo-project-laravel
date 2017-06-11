<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','Designation')
<script>
    jQuery(function (){
        $("#designationForm").validate();
    });
</script>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ol class="breadcrumb admin-header">
                        <li><a href=""><i class="fa fa-home"></i>
                                <span id="Label65">Dashboard</span>
                            </a>
                        </li>
                        <li><a href="{{URL::to('designation')}}"><i></i>
                                <span id="Label65">Click For Designation List</span>
                            </a>
                        </li>
                        @if(@$editDesignation)
                            <li class="active">Edit Designation</li>
                        @else
                            <li class="active">Add  Designation</li>
                        @endif
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$editDesignation)
                        {{ Form::model(@$editDesignation, array('route' => array('designation.update', @$editDesignation->id), 'method' => 'PUT','id' => 'designationForm')) }}
                    @else
                        {{ Form::open(array('route' => 'designation.store','id' => 'designationForm')) }}
                    @endif
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Designation') }}<span class="required_field">*</span>
                                    {{ Form::text('designation_name', Input::old('designation_name'), array('class' => 'form-control required','placeholder' => 'Enter Designation')) }}
                                    @if($errors->has('designation_name'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('designation_name') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if(@$editDesignation)
                                <button type="submit" class="action-button" style="width: 100px;margin-left: -9px;">Update</button>
                            @else
                                <button type="submit" class="action-button" style="width: 100px;margin-left: -9px;">Save</button>
                            @endif
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
