@extends('admin.master')
@section('content')
@section('title','Witness')
<script>

    jQuery(function (){

        $('#addMoreWitnesses').click(function(){

            $('#witnesses_details_rows').append('<div class="panel-body witnesses_row_element">' + $('.row_element').html() + '</div>');

        });
        $(document).on("click",".deleteWitnesses",function(){
            $(this).parents('.witnesses_row_element').remove();

            var deletedID = $(this).parents('.witnesses_row_element').find('.witness_cid').val();

            if (deletedID) {
                var prevDelId = $('#delete_witness_cid').val();
                if (prevDelId) {
                    $('#delete_witness_cid').val(prevDelId + ',' + deletedID);
                } else {
                    $('#delete_witness_cid').val(deletedID);
                }
            }

        });

        /*$(document).on("click",".deleteWitnesses",function(){
            $(this).parents('.witnesses_row_element').remove();
        });*/
    });

</script>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ol class="breadcrumb admin-header">
                        <li><a href="{{URL::to('admin_home')}}"><i class="fa fa-home"></i>
                                <span id="Label65">Dashboard</span>
                            </a>
                        </li>
                        <li><a href="{{URL::to('witness')}}"><i class="glyphicon glyphicon-arrow-right"></i>
                                <span id="Label65">View</span>
                            </a>
                        </li>
                        @if(@$editWitness)
                            <li class="active">Edit Witnesses</li>
                        @else
                            <li class="active">Add  Witnesses</li>
                        @endif
                    </ol>
                </div>
                <div class="box-header with-border">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true"></button>
                            <strong>{{ session()->get('success') }}</strong>
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true"></button>
                            <strong>{{ session()->get('error') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$editWitness)
                        {{ Form::model(@$editWitness, array('route' => array('witness.update', @$editWitness->id), 'method' => 'PUT','files' => 'true','id' => 'rabEmployeeForm')) }}
                        {!! Form::hidden('delete_witness_cid','', $attributes = array('class'=>'form-control  delete_witness_cid','id'=>'delete_witness_cid')) !!}
                    @else
                        {{ Form::open(array('route' => 'witness.store','files' => 'true','id' => 'rabEmployeeForm')) }}
                    @endif

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Basic Information</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput">Case No<span class="validateRq">*</span></label>
                                        {{ Form::select('case_id', $caseList, Input::old('case_id'), array('class' => 'form-control required')) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInput">Date<span class="validateRq">*</span></label>
                                        {{ Form::text('date',dateConvertDBtoForm(@$editWitness->date) , array('class' => 'form-control required dateField','placeholder' => 'Enter Date')) }}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Witness Copy</label>
                                        {!! Form::file('witness_attach', '', $attributes = array('class'=>'form-control investigation_attach','id'=>'investigation_attach')) !!}
                                    </div>
                                    @if(@$editWitness->witness_attach !='')
                                        <a href="{!! url('public/uploads/witnessFile/'.$editWitness->witness_attach) !!}" download class="btn btn-primary">Download</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Witnesses Information</span>
                            <button style="float: right;margin-top: -7px;" type="button" id="addMoreWitnesses" class="btn btn-success btn-md"><i class="fa fa-plus"></i> Add More</button>
                        </div>
                        @if(!isset($editWitness))
                        <div id="witnesses_details_rows">
                            <div class="panel-body witnesses_row_element">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="badge deleteWitnesses pull-right" style="background: red;cursor: pointer;">X</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::hidden('witnessDetails[witness_cid][]') !!}
                                        <div class="form-group">
                                            <label for="exampleInput">Witness Name<span class="validateRq">*</span></label>
                                            {!! Form::text('witnessDetails[witness_name][]', '', $attributes = array('class'=>'form-control required witness_name','id'=>'witnessName','placeholder'=>'Enter Witness Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                            {!! Form::number('witnessDetails[age][]', '', $attributes = array('class'=>'form-control required age','id'=>'age','placeholder'=>'Enter Age')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                            {{ Form::select('witnessDetails[gender][]', array('' => '---- Select Gender ----', 'male' => 'Male', 'female' => 'Female'), Input::old('gender'), array('class' => 'form-control required')) }}
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Father Name<span class="validateRq">*</span></label>
                                            {!! Form::text('witnessDetails[father_name][]', '', $attributes = array('class'=>'form-control required fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Mother Name<span class="validateRq">*</span></label>
                                            {!! Form::text('witnessDetails[mother_name][]', '', $attributes = array('class'=>'form-control required motherName','id'=>'motherName','placeholder'=>'Enter Mother Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                            {!! Form::number('witnessDetails[contact_no][]', '', $attributes = array('class'=>'form-control required contactNumber','id'=>'contactNumber','placeholder'=>'Enter Contact Number')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Profession</label>
                                            {!! Form::text('witnessDetails[profession][]', '', $attributes = array('class'=>'form-control professional','id'=>'professional','placeholder'=>'Enter Profession')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Permanent Address</label>
                                            {!! Form::textarea('witnessDetails[parmanent_address][]', '', $attributes = array('class'=>'form-control permanentAddress','id'=>'permanentAddress','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                            {!! Form::textarea('witnessDetails[present_address][]', '', $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div id="witnesses_details_rows">
                                @foreach($editWitnessDetails as $witnessData)
                                <div class="panel-body witnesses_row_element">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="badge deleteWitnesses pull-right" style="background: red;cursor: pointer;">X</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            {!! Form::hidden('witnessDetails[witness_cid][]',$witnessData->id,$attributes = array('class'=>'form-control witness_cid','id'=>'witness_cid')) !!}
                                            <div class="form-group">
                                                <label for="exampleInput">Witness Name<span class="validateRq">*</span></label>
                                                {!! Form::text('witnessDetails[witness_name][]', $witnessData->witness_name, $attributes = array('class'=>'form-control required witness_name','id'=>'witnessName','placeholder'=>'Enter Witness Name')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                                {!! Form::number('witnessDetails[age][]', $witnessData->age, $attributes = array('class'=>'form-control required age','id'=>'age','placeholder'=>'Enter Age')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                                {{ Form::select('witnessDetails[gender][]', array('' => '---- Select Gender ----', 'male' => 'Male', 'female' => 'Female'),$witnessData->gender, array('class' => 'form-control required')) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Father Name<span class="validateRq">*</span></label>
                                                {!! Form::text('witnessDetails[father_name][]', $witnessData->father_name, $attributes = array('class'=>'form-control required fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Mother Name<span class="validateRq">*</span></label>
                                                {!! Form::text('witnessDetails[mother_name][]', $witnessData->mother_name, $attributes = array('class'=>'form-control required motherName','id'=>'fatherName','placeholder'=>'Enter Mother Name')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                                {!! Form::number('witnessDetails[contact_no][]', $witnessData->contact_no, $attributes = array('class'=>'form-control required contactNumber','id'=>'contactNumber','placeholder'=>'Enter Contact Number')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Profession</label>
                                                {!! Form::text('witnessDetails[profession][]', $witnessData->profession, $attributes = array('class'=>'form-control professional','id'=>'professional','placeholder'=>'Enter Profession')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Permanent Address</label>
                                                {!! Form::textarea('witnessDetails[parmanent_address][]', $witnessData->parmanent_address, $attributes = array('class'=>'form-control permanentAddress','id'=>'permanentAddress','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                                {!! Form::textarea('witnessDetails[present_address][]', $witnessData->present_address, $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                    </div>

                    <div class="row">
                        <div class="box-footer">
                            <button type="submit" class="action-button" style="width: 100px">Save</button>
                        </div>
                    </div>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</section>

<!--  append section -->
<div class="row_element" style="display: none;">
    <div class="panel-body witnesses_row_element">
        <div class="row">
            <div class="col-md-12">
                <span class="badge deleteWitnesses pull-right" style="background: red;cursor: pointer;">X</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                {!! Form::hidden('witnessDetails[witness_cid][]') !!}
                <div class="form-group">
                    <label for="exampleInput">Witness Name<span class="validateRq">*</span></label>
                    {!! Form::text('witnessDetails[witness_name][]', '', $attributes = array('class'=>'form-control required name','id'=>'witnessName','placeholder'=>'Enter Witness Name')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                    {!! Form::number('witnessDetails[age][]', '', $attributes = array('class'=>'form-control required age','id'=>'age','placeholder'=>'Enter Age')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                    {{ Form::select('witnessDetails[gender][]', array('' => '---- Select Gender ----', 'male' => 'Male', 'female' => 'Female'), Input::old('gender'), array('class' => 'form-control required')) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Father's Name<span class="validateRq">*</span></label>
                    {!! Form::text('witnessDetails[father_name][]', '', $attributes = array('class'=>'form-control required fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Mother's Name<span class="validateRq">*</span></label>
                    {!! Form::text('witnessDetails[mother_name][]', '', $attributes = array('class'=>'form-control required motherName','id'=>'motherName','placeholder'=>'Enter Mother Name')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                    {!! Form::number('witnessDetails[contact_no][]', '', $attributes = array('class'=>'form-control required contactNumber','id'=>'contactNumber','placeholder'=>'Enter Contact Number')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Professional</label>
                    {!! Form::text('witnessDetails[profession][]', '', $attributes = array('class'=>'form-control professional','id'=>'professional','placeholder'=>'Enter Profession')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Permanent Address</label>
                    {!! Form::textarea('witnessDetails[parmanent_address][]', '', $attributes = array('class'=>'form-control permanentAddress','id'=>'permanentAddress','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Permanent Address</label>
                    {!! Form::textarea('witnessDetails[present_address][]', '', $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            </div>
            </div>
        </div>




@endsection
