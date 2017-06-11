@extends('admin.master')
@section('content')
@section('title','RAB Litigant')
<script>

    jQuery(function (){

        $("#caseForm").validate();

        $('#addMoreConvict').click(function(){
            $('#Convict_details_rows').append('<div class="panel-body row_element">' + $('.row_element1').html() + '</div>');
        });

        $(document).on("click",".deleteConvict",function(){

            $(this).parents('.row_element').remove();
            var deletedID = $(this).parents('.row_element').find('.convict_cid').val();

            if (deletedID) {
                var prevDelId = $('#delete_convict_cid').val();
                if (prevDelId) {
                    $('#delete_convict_cid').val(prevDelId + ',' + deletedID);
                } else {
                    $('#delete_convict_cid').val(deletedID);
                }
            }

        });

        $('#addMoreVictims').click(function(){
            $('#victims_details_rows').append('<div class="panel-body victims_row_element">' + $('.row_element2').html() + '</div>');
        });

        $(document).on("click",".deleteVictims",function(){

            $(this).parents('.victims_row_element').remove();
            var deletedID = $(this).parents('.victims_row_element').find('.victims_cid').val();

            if (deletedID) {
                var prevDelId = $('#delete_victims_cid').val();
                if (prevDelId) {
                    $('#delete_victims_cid').val(prevDelId + ',' + deletedID);
                } else {
                    $('#delete_victims_cid').val(deletedID);
                }
            }


        });

        $('#addMoreLawSection').click(function(){
            $('#law_section_details_rows').append('<div class="panel-body law_section_row_element">' + $('.row_element3').html() + '</div>');
        });

        $(document).on("click",".deleteLaw",function(){

            $(this).parents('.law_section_row_element').remove();
            var deletedID = $(this).parents('.law_section_row_element').find('.law_cid').val();

            if (deletedID) {
                var prevDelId = $('#delete_law_cid').val();
                if (prevDelId) {
                    $('#delete_law_cid').val(prevDelId + ',' + deletedID);
                } else {
                    $('#delete_law_cid').val(deletedID);
                }
            }

        });

        $(document).on('change', '.convict_pastcase', function(){

            var haveAnyCase = $(this).parents('.row_element').find('.convict_pastcase').val();
            if(haveAnyCase == '1'){
                $(this).parents('.row_element').find('.convict_details').attr('readonly',false);
            }else{
                $(this).parents('.row_element').find('.convict_details').attr('readonly',true);
                $(this).parents('.row_element').find('.convict_details').val('');
            }

        });

        $(document).on("change",".litigant_name ",function(){

            var employeeId = $('.litigant_name').val();

            if(employeeId !='') {
                var action = "{{ URL::to('case/getEmployeeWiseDesignationAndBattalion') }}";
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: {'employeeId': employeeId, '_token': $('input[name=_token]').val()},
                    dataType: 'json',
                    success: function (data) {
                        $('.litigant_designation').val(data.fk_designation_id).trigger("change");
                        $('.litigant_battalion').val(data.fk_battalion_id).trigger("change");
                    }
                });
            }else{
                $('.litigant_designation').val('').trigger("change");
                $('.litigant_battalion').val('').trigger("change");
            }

        });


        @if(isset($editModeData))
            {!! "  $('.convict_pastcase').trigger('change');" !!}
        @endif


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
                        <li><a href="{{URL::to('case')}}"><i class="glyphicon glyphicon-arrow-right"></i>
                                <span id="Label65">View</span>
                            </a>
                        </li>
                        <li class="active"> @if(isset($editModeData)) {!! 'Edit Case' !!} @else {!! 'Add Case'  !!} @endif</li>
                    </ol>
                </div>

                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(isset($editModeData))
                        {{ Form::open(array('route' => array('case.update', @$editModeData->id), 'method' => 'PUT','enctype'=>'multipart/form-data','id'=>'caseForm')) }}
                        {!! Form::hidden('delete_convict_cid','', $attributes = array('class'=>'form-control  delete_convict_cid','id'=>'delete_convict_cid')) !!}
                        {!! Form::hidden('delete_victims_cid','', $attributes = array('class'=>'form-control  delete_victims_cid','id'=>'delete_victims_cid')) !!}
                        {!! Form::hidden('delete_law_cid','', $attributes = array('class'=>'form-control  delete_law_cid','id'=>'delete_law_cid')) !!}
                    @else
                        {{ Form::open(array('route' => 'case.store','enctype'=>'multipart/form-data','id'=>'caseForm')) }}
                    @endif


                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Litigant Information</span>
                        </div>
                        <div class="panel-body">
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <strong>{{ session()->get('success') }}</strong>
                                </div>
                            @endif  @if(session()->has('error'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <strong>{{ session()->get('error') }}</strong>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Reference No</label>
                                        {!! Form::text('reference_no',(isset($editModeData)) ? $editModeData->reference_no : "", $attributes = array('class'=>'form-control  reference_no','id'=>'reference_no','readonly'=>'readonly','placeholder'=>'Enter Reference No')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Previous Case No</label>
                                        {!! Form::text('previous_case_no', (isset($editModeData)) ? $editModeData->previous_case_no : "", $attributes = array('class'=>'form-control  previous_case_no','id'=>'previous_case_no','placeholder'=>'Enter previous Case No')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Litigant Name<span class="validateRq">*</span></label>
                                        {{ Form::select('litigant_name', $employeeList,  (isset($editModeData)) ? $editModeData->litigant_name : "", array('class' => 'form-control litigant_name required')) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Designation<span class="validateRq">*</span></label>
                                        {{ Form::select('litigant_designation', $designationList, (isset($editModeData)) ? $editModeData->litigant_designation : "", array('class' => 'form-control litigant_designation required','style'=>'pointer-events : none')) }}

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Battalion<span class="validateRq">*</span></label>
                                        {{ Form::select('litigant_battalion', $battalionList, (isset($editModeData)) ? $editModeData->litigant_battalion : "", array('class' => 'form-control litigant_battalion required','style'=>'pointer-events : none')) }}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Convict Information</span>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <button style="float: right;margin-top: -38px;" type="button" id="addMoreConvict" class="btn btn-success btn-md"><i class="fa fa-plus"></i> Add More</button>
                        </div>
                        @if(!isset($editModeData))
                        <div id="Convict_details_rows">
                            <div class="panel-body row_element">
                                <div class="row">
                                    <div class="col-md-3">
                                        {!! Form::hidden('convictDetails[convict_cid][]') !!}
                                        <div class="form-group">
                                            <label for="exampleInput">Convict Name<span class="validateRq">*</span></label>
                                            {!! Form::text('convictDetails[convict_name][]', '', $attributes = array('class'=>'form-control required convict_name','id'=>'convict_name','placeholder'=>'Enter Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                            {!! Form::number('convictDetails[convict_age][]', '', $attributes = array('class'=>'form-control required convict_age','id'=>'convict_age','placeholder'=>'Enter Age')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                            {{ Form::select('convictDetails[convict_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control convict_gender required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Father Name</label>
                                            {!! Form::text('convictDetails[convict_father_name][]', '', $attributes = array('class'=>'form-control fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Mother Name</label>
                                            {!! Form::text('convictDetails[convict_mother_name][]', '', $attributes = array('class'=>'form-control convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                            {!! Form::text('convictDetails[convict_contact_number][]', '', $attributes = array('class'=>'form-control required convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Permanent Address</label>
                                            {!! Form::textarea('convictDetails[convict_permanent_address][]', '', $attributes = array('class'=>'form-control convict_permanent_address','id'=>'convict_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                            {!! Form::textarea('convictDetails[convict_present_address][]', '', $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Have Any Case Past ?<span class="validateRq">*</span></label>
                                            {{ Form::select('convictDetails[convict_pastcase][]', array('0' => 'No', '1' => 'Yes'),'0', array('class' => 'form-control required convict_pastcase')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Details Information</label>
                                            {!! Form::textarea('convictDetails[convict_details][]', '', $attributes = array('class'=>'form-control convict_details','id'=>'convict_details','readonly'=>'readonly','placeholder'=>'Enter Details Information','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                </div>
                            </div>
                        </div>
                        @else
                            <div id="Convict_details_rows">
                                @foreach($ConvictEditModeData as $value)
                                    <div class="panel-body row_element">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {!! Form::hidden('convictDetails[convict_cid][]',$value->id,$attributes = array('class'=>'form-control required convict_cid')) !!}
                                                <div class="form-group">
                                                    <label for="exampleInput">Convict Name<span class="validateRq">*</span></label>
                                                    {!! Form::text('convictDetails[convict_name][]', $value->convict_name , $attributes = array('class'=>'form-control required convict_name','id'=>'convict_name','placeholder'=>'Enter Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                                    {!! Form::number('convictDetails[convict_age][]', $value->convict_age , $attributes = array('class'=>'form-control required convict_age','id'=>'convict_age','placeholder'=>'Enter Age')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                                    {{ Form::select('convictDetails[convict_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), $value->convict_gender, array('class' => 'form-control convict_gender required')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Father Name</label>
                                                    {!! Form::text('convictDetails[convict_father_name][]', $value->convict_father_name, $attributes = array('class'=>'form-control fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Mother Name</label>
                                                    {!! Form::text('convictDetails[convict_mother_name][]', $value->convict_mother_name, $attributes = array('class'=>'form-control convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                                    {!! Form::text('convictDetails[convict_contact_number][]', $value->convict_contact_number, $attributes = array('class'=>'form-control required convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Permanent Address</label>
                                                    {!! Form::textarea('convictDetails[convict_permanent_address][]', $value->convict_permanent_address, $attributes = array('class'=>'form-control convict_permanent_address','id'=>'convict_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                                    {!! Form::textarea('convictDetails[convict_present_address][]', $value->convict_present_address, $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Have Any Case Past ?<span class="validateRq">*</span></label>
                                                    {{ Form::select('convictDetails[convict_pastcase][]', array('0' => 'No', '1' => 'Yes'),$value->convict_pastcase, array('class' => 'form-control required convict_pastcase')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Details Information</label>
                                                    {!! Form::textarea('convictDetails[convict_details][]', $value->convict_details, $attributes = array('class'=>'form-control convict_details','id'=>'convict_details','readonly'=>'readonly','placeholder'=>'Enter Details Information','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                        </div>
                                    </div>

                            @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Victims Information</span>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <button style="float: right;margin-top: -38px;" type="button" id="addMoreVictims" class="btn btn-success btn-md"><i class="fa fa-plus"></i> Add More</button>
                        </div>
                        @if(!isset($editModeData))
                        <div id="victims_details_rows">
                            <div class="panel-body victims_row_element">
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::hidden('victimsDetails[victims_cid][]') !!}
                                        <div class="form-group">
                                            <label for="exampleInput">Name<span class="validateRq">*</span></label>
                                            {!! Form::text('victimsDetails[victim_name][]', '', $attributes = array('class'=>'form-control required name','id'=>'victimsName','placeholder'=>'Enter Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                            {!! Form::number('victimsDetails[victim_age][]', '', $attributes = array('class'=>'form-control required victim_age','id'=>'victim_age','placeholder'=>'Enter Age')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                            {{ Form::select('victimsDetails[victim_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control victim_gender required')) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Father Name</label>
                                            {!! Form::text('victimsDetails[victim_father_name][]', '', $attributes = array('class'=>'form-control  victim_father_name','id'=>'victim_father_name','placeholder'=>'Enter Father Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Mother Name</label>
                                            {!! Form::text('victimsDetails[victim_mother_name][]', '', $attributes = array('class'=>'form-control  victim_mother_name','id'=>'victim_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                            {!! Form::text('victimsDetails[victim_contact_number][]', '', $attributes = array('class'=>'form-control required victim_contact_number','id'=>'victim_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Permanent Address</label>
                                            {!! Form::textarea('victimsDetails[victim_permanent_address][]', '', $attributes = array('class'=>'form-control victim_permanent_address','id'=>'victim_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                            {!! Form::textarea('victimsDetails[victim_present_address][]', '', $attributes = array('class'=>'form-control required victim_present_address','id'=>'victim_present_address','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @else
                            <div id="victims_details_rows">
                                @foreach($victimsEditModeData as $victimsValue)

                                    <div class="panel-body victims_row_element">
                                        <div class="row">
                                            <div class="col-md-4">
                                                {!! Form::hidden('victimsDetails[victims_cid][]',$victimsValue->id,$attributes = array('class'=>'victims_cid','id'=>'victims_cid')) !!}
                                                <div class="form-group">
                                                    <label for="exampleInput">Name<span class="validateRq">*</span></label>
                                                    {!! Form::text('victimsDetails[victim_name][]', $victimsValue->victim_name, $attributes = array('class'=>'form-control required name','id'=>'victimsName','placeholder'=>'Enter Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                                    {!! Form::number('victimsDetails[victim_age][]', $victimsValue->victim_age, $attributes = array('class'=>'form-control required victim_age','id'=>'victim_age','placeholder'=>'Enter Age')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                                    {{ Form::select('victimsDetails[victim_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), $victimsValue->victim_gender, array('class' => 'form-control victim_gender required')) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInput">Father Name</label>
                                                    {!! Form::text('victimsDetails[victim_father_name][]', $victimsValue->victim_father_name, $attributes = array('class'=>'form-control  victim_father_name','id'=>'victim_father_name','placeholder'=>'Enter Father Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInput">Mother Name</label>
                                                    {!! Form::text('victimsDetails[victim_mother_name][]', $victimsValue->victim_mother_name, $attributes = array('class'=>'form-control  victim_mother_name','id'=>'victim_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                                    {!! Form::text('victimsDetails[victim_contact_number][]', $victimsValue->victim_contact_number, $attributes = array('class'=>'form-control required victim_contact_number','id'=>'victim_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInput">Permanent Address</label>
                                                    {!! Form::textarea('victimsDetails[victim_permanent_address][]', $victimsValue->victim_permanent_address, $attributes = array('class'=>'form-control victim_permanent_address','id'=>'victim_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                                    {!! Form::textarea('victimsDetails[victim_present_address][]', $victimsValue->victim_present_address, $attributes = array('class'=>'form-control required victim_present_address','id'=>'victim_present_address','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                            </div>
                                        </div>
                                    </div>
                                 @endforeach
                            </div>
                            @endif
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Crime Information</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label for="exampleInput">Crime Type<span class="validateRq">*</span></label>
                                        {{ Form::select('crime_type', $crimeTypeList,(isset($editModeData)) ? $editModeData->crime_type : "", array('class' => 'form-control crime_type required')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Crime Place<span class="validateRq">*</span></label>
                                        {!! Form::text('crime_place', (isset($editModeData)) ? $editModeData->crime_place : "", $attributes = array('class'=>'form-control required crime_place','id'=>'crime_place','placeholder'=>'Enter Crime Place')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Crime Time<span class="validateRq">*</span></label>
                                        {!! Form::text('crime_time', (isset($editModeData)) ? dateConvertDBtoForm($editModeData->crime_time) : "", $attributes = array('class'=>'form-control required crime_time dateField','id'=>'crime_time','placeholder'=>'Enter Crime Time')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Crime Description</label>
                                        {!! Form::textarea('crime_description', (isset($editModeData)) ? $editModeData->crime_description : "", $attributes = array('class'=>'form-control crime_description','id'=>'crime_description','placeholder'=>'Enter Crime Description','cols'=>'30','rows'=>'2')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Law Section</span>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <button style="float: right;margin-top: -38px;" type="button" id="addMoreLawSection" class="btn btn-success btn-md"><i class="fa fa-plus"></i> Add More</button>
                        </div>

                        @if(!isset($editModeData))
                        <div id="law_section_details_rows">
                            <div class="panel-body law_section_row_element">
                                <div class="col-md-6">
                                    {!! Form::hidden('lawDetails[law_cid][]') !!}
                                    <div class="form-group">
                                        <label for="exampleInput">law Type<span class="validateRq">*</span></label>
                                        {{ Form::select('lawDetails[law_type][]', $lawList, '', array('class' => 'form-control law_type required')) }}
                                    </div>
                                </div>
                                <span class="badge deleteLaw" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                            </div>
                        </div>
                       @else
                            <div id="law_section_details_rows">
                            @foreach($lawEditModeData as $lawValue)
                                    <div class="panel-body law_section_row_element">
                                        <div class="col-md-6">
                                            {!! Form::hidden('lawDetails[law_cid][]',$lawValue->id,$attributes = array('class'=>'law_cid','id'=>'law_cid')) !!}
                                            <div class="form-group">
                                                <label for="exampleInput">law Type<span class="validateRq">*</span></label>
                                                {{ Form::select('lawDetails[law_type][]',$lawList, $lawValue->law_type, array('class' => 'form-control law_type required')) }}
                                            </div>
                                        </div>
                                        <span class="badge deleteLaw" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                    </div>
                             @endforeach
                            </div>
                       @endif
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Others Information</span>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">FIR Copy</label>
                                        {!! Form::file('fir_attach', $attributes = array('class'=>'form-control fir_attach','id'=>'fir_attach')) !!}
                                    </div>
                                    @if(@$editModeData->fir_attach !='')
                                      <a href="{!! url('public/uploads/fircopy/'.$editModeData->fir_attach) !!}" download class="btn btn-primary">Download</a>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Status<span class="validateRq">*</span></label>
                                        {{ Form::select('status', caseStatus(), (isset($editModeData)) ? $editModeData->status : "", array('class' => 'form-control status required')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Evidence</label>
                                        {!! Form::textarea('evidence', (isset($editModeData)) ? $editModeData->evidence : "", $attributes = array('class'=>'form-control evidence','id'=>'evidence','placeholder'=>'Enter Evidence','cols'=>'30','rows'=>'2')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
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
<div class="row_element1" style="display: none;">
    <div class="panel-body row_element">
        <div class="row">
            <div class="col-md-3">
                {!! Form::hidden('convictDetails[convict_cid][]') !!}
                <div class="form-group">
                    <label for="exampleInput">Convict Name<span class="validateRq">*</span></label>
                    {!! Form::text('convictDetails[convict_name][]', '', $attributes = array('class'=>'form-control required convict_name','id'=>'convict_name','placeholder'=>'Enter Name')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                    {!! Form::number('convictDetails[convict_age][]', '', $attributes = array('class'=>'form-control required convict_age','id'=>'convict_age','placeholder'=>'Enter Age')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                    {{ Form::select('convictDetails[convict_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control convict_gender required')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Father Name</label>
                    {!! Form::text('convictDetails[convict_father_name][]', '', $attributes = array('class'=>'form-control  convict_father_name','id'=>'convict_father_name','placeholder'=>'Enter Father Name')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Mother Name</label>
                    {!! Form::text('convictDetails[convict_mother_name][]', '', $attributes = array('class'=>'form-control  convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                    {!! Form::text('convictDetails[convict_contact_number][]', '', $attributes = array('class'=>'form-control required convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Permanent Address</label>
                    {!! Form::textarea('convictDetails[convict_permanent_address][]', '', $attributes = array('class'=>'form-control convict_permanent_address','id'=>'convict_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                    {!! Form::textarea('convictDetails[convict_present_address][]', '', $attributes = array('class'=>'form-control required convict_present_address','id'=>'convict_present_address','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Have Any Case Past ?<span class="validateRq">*</span></label>
                    {{ Form::select('convictDetails[convict_pastcase][]', array('0' => 'No', '1' => 'Yes'),'0', array('class' => 'form-control required convict_pastcase')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Details Information</label>
                    {!! Form::textarea('convictDetails[convict_details][]', '', $attributes = array('class'=>'form-control convict_details','id'=>'convict_details','readonly'=>'readonly','placeholder'=>'Enter Details Information','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
        </div>
    </div>
</div>

<div class="row_element2" style="display: none;">
    <div class="panel-body victims_row_element">
        <div class="row">
            <div class="col-md-4">
                {!! Form::hidden('victimsDetails[victims_cid][]') !!}
                <div class="form-group">
                    <label for="exampleInput">Name<span class="validateRq">*</span></label>
                    {!! Form::text('victimsDetails[victim_name][]', '', $attributes = array('class'=>'form-control required victim_name','id'=>'victim_name','placeholder'=>'Enter Name')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                    {!! Form::number('victimsDetails[victim_age][]', '', $attributes = array('class'=>'form-control required victim_age','id'=>'victim_age','placeholder'=>'Enter Age')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                    {{ Form::select('victimsDetails[victim_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control victim_gender required')) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Father Name</label>
                    {!! Form::text('victimsDetails[victim_father_name][]', '', $attributes = array('class'=>'form-control  victim_father_name','id'=>'victim_father_name','placeholder'=>'Enter Father Name')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Mother Name</label>
                    {!! Form::text('victimsDetails[victim_mother_name][]', '', $attributes = array('class'=>'form-control  victim_mother_name','id'=>'victim_mother_name','placeholder'=>'Enter Mother Name')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                    {!! Form::text('victimsDetails[victim_contact_number][]', '', $attributes = array('class'=>'form-control required victim_contact_number','id'=>'victim_contact_number','placeholder'=>'Enter Contact Number')) !!}
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Permanent Address</label>
                    {!! Form::textarea('victimsDetails[victim_permanent_address][]', '', $attributes = array('class'=>'form-control victim_permanent_address','id'=>'victim_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                    {!! Form::textarea('victimsDetails[victim_present_address][]', '', $attributes = array('class'=>'form-control required victim_present_address','id'=>'victim_present_address','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
            </div>
        </div>
    </div>
</div>

<div class="row_element3" style="display: none;">
    <div class="col-md-6">
        {!! Form::hidden('lawDetails[law_cid][]') !!}
        <div class="form-group">
            <label for="exampleInput">Law Type<span class="validateRq">*</span></label>
            {{ Form::select('lawDetails[law_type][]',$lawList, '', array('class' => 'form-control law_type required')) }}
        </div>
    </div>
   <span class="badge deleteLaw" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
</div>

@endsection
