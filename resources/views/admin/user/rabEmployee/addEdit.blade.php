<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','RAB Employee')
<script>

    jQuery(function (){
        $("#rabEmployeeForm").validate();
    });

    function employeeImage(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgSutdent').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

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
                        <li><a href="{{URL::to('rabEmployee')}}"><i></i>
                                <span id="Label65">Click For RAB Eemployee List</span>
                            </a>
                        </li>
                        @if(@$editRabEmployee)
                            <li class="active">Edit RAB Employee</li>
                        @else
                            <li class="active">Add  RAB Employee</li>
                        @endif
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$editRabEmployee)
                        {{ Form::model(@$editRabEmployee, array('route' => array('rabEmployee.update', @$editRabEmployee->id), 'method' => 'PUT','files' => 'true','id' => 'rabEmployeeForm')) }}
                    @else
                        {{ Form::open(array('route' => 'rabEmployee.store','files' => 'true','id' => 'rabEmployeeForm')) }}
                    @endif
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Employee No') }}<span class="required_field">*</span>
                                    {{ Form::text('employee_no', Input::old('employee_no'), array('class' => 'form-control required','placeholder' => 'Enter Employee No')) }}
                                    @if($errors->has('employee_no'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('employee_no') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Employee Name') }}<span class="required_field">*</span>
                                    {{ Form::text('employee_name', Input::old('employee_name'), array('class' => 'form-control required','placeholder' => 'Enter Employee Name')) }}
                                    @if($errors->has('employee_name'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('employee_name') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Gender') }}<span class="required_field">*</span>
                                    {{ Form::select('gender', array('' => '---- Select Gender ----', 'male' => 'Male', 'female' => 'Female'), Input::old('gender'), array('class' => 'form-control required')) }}
                                    @if($errors->has('gender'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('gender') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Contact No') }}<span class="required_field">*</span>
                                    {{ Form::text('contact_no', Input::old('contact_no'), array('class' => 'form-control required','placeholder' => 'Enter Conatct No')) }}
                                    @if($errors->has('contact_no'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('contact_no') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Designation') }}<span class="required_field">*</span>
                                    {{ Form::select('fk_designation_id', $designationList, Input::old('fk_designation_id'), array('class' => 'form-control required')) }}
                                    @if($errors->has('gender'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('gender') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Battalion') }}<span class="required_field">*</span>
                                    {{ Form::select('fk_battalion_id', $battalionList, Input::old('fk_battalion_id'), array('class' => 'form-control required')) }}
                                    @if($errors->has('contact_no'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('contact_no') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Profile Photo') }}
                                    {{ Form::file('employee_image',  array('class' => 'form-control')) }}
                                    @if($errors->has('employee_image'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('employee_image') }}</strong>
                                                 </span>
                                        <span id="imgSutdent"></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if(@$editRabEmployee)
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
