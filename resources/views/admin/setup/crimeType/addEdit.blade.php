<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','Crime Type')
<script>
    jQuery(function (){
        $("#crimeTypeForm").validate();
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
                        <li><a href="{{URL::to('crimeType')}}"><i></i>
                                <span id="Label65">Click For Crime Type List</span>
                            </a>
                        </li>
                        @if(@$editCrimeType)
                            <li class="active">Edit Crime Type</li>
                        @else
                            <li class="active">Add  Crime Type</li>
                        @endif
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$editCrimeType)
                        {{ Form::model(@$editCrimeType, array('route' => array('crimeType.update', @$editCrimeType->id), 'method' => 'PUT','id' => 'crimeTypeForm')) }}
                    @else
                        {{ Form::open(array('route' => 'crimeType.store','id' => 'crimeTypeForm')) }}
                    @endif
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Crime Type') }}<span class="required_field">*</span>
                                    {{ Form::text('crime_type_name', Input::old('crime_type_name'), array('class' => 'form-control required','placeholder' => 'Enter Crime Type')) }}
                                    @if($errors->has('crime_type_name'))
                                        <span class="validation_msg">
                                                     <strong>{{ $errors->first('crime_type_name') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if(@$editCrimeType)
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
