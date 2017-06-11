
<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','RAB Litigant')


<script>

    jQuery(function (){

        $("#complain").validate();

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
                        @if(@$editComplain)
                            <li class="active">Edit Complain</li>
                        @else
                            <li class="active">Add Complain</li>
                        @endif

                    </ol>
                </div>

                <div class="panel-body" style="height: auto; min-height: 500px;">

                    @if(@$editComplain)
                        {{ Form::open(array('route' => array('complain.update', @$editComplain->id), 'method' => 'PUT','enctype'=>'multipart/form-data','id'=>'complain')) }}
                    @else
                    {{ Form::open(array('route' => 'complain.store' , 'id'=>'complain', 'enctype'=>'multipart/form-data')) }}
                    @endif
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
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <span>Basic Information</span>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Reference No</label>
                                            {!! Form::text('reference_no',(isset($editComplain)) ? $editComplain->reference_no : "", $attributes = array('class'=>'form-control  reference_no','id'=>'reference_no','readonly'=>'readonly','placeholder'=>'Enter Reference No')) !!}
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Battalion<span class="validateRq">*</span></label>
                                            {{ Form::select('litigant_battalion', $battalionList, (isset($editComplain)) ? $editComplain->battalion : "", array('class' => 'form-control litigant_battalion required','style'=>'pointer-events : auto')) }}

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Date<span class="validateRq">*</span></label>
                                            {!! Form::text('date', (isset($editComplain)) ? dateConvertDBtoForm($editComplain->date) : "", $attributes = array('class'=>'form-control required crime_time dateField','id'=>'crime_time','placeholder'=>'Enter Crime Time')) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span> Complainant Information </span>
                           </div>
                        <div class="col-lg-12 col-md-12">


                        </div>
                        <div id="Convict_details_rows1">
                            <div class="panel-body row_element">
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="exampleInput">Complainant Name<span class="validateRq">*</span></label>
                                            {!! Form::text('complainant_name', (isset($editComplain)) ? $editComplain->complainant_name : "", $attributes = array('class'=>'form-control required convict_name','id'=>'convict_name','placeholder'=>'Enter Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                            {!! Form::number('complainant_age', (isset($editComplain)) ? $editComplain->complainant_age : "", $attributes = array('class'=>'form-control required convict_age','id'=>'convict_age','placeholder'=>'Enter Age')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                            {{ Form::select('complainant_gender', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), (isset($editComplain)) ? $editComplain->complainant_gender : "", array('class' => 'form-control convict_gender required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Father Name</label>
                                            {!! Form::text('complainant_father_name', (isset($editComplain)) ? $editComplain->complainant_father_name : "", $attributes = array('class'=>'form-control fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Mother Name</label>
                                            {!! Form::text('complainant_mother_name', (isset($editComplain)) ? $editComplain->complainant_mother_name : "", $attributes = array('class'=>'form-control convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                            {!! Form::text('complainant_contact_number', (isset($editComplain)) ? $editComplain->complainant_contact_number : "", $attributes = array('class'=>'form-control required convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Permanent Address</label>
                                            {!! Form::textarea('complainant_permanent_address', (isset($editComplain)) ? $editComplain->complainant_permanent_address : "", $attributes = array('class'=>'form-control convict_permanent_address','id'=>'convict_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                            {!! Form::textarea('complainant_present_address', (isset($editComplain)) ? $editComplain->complainant_present_address : "", $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Complain Details<span class="validateRq">*</span></label>
                                            {!! Form::textarea('complainant_details', (isset($editComplain)) ? $editComplain->complainant_details : "", $attributes = array('class'=>'form-control required complainant_details','id'=>'complainant_details','placeholder'=>'Enter Complain Details','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        </div>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <span>Defendant Information</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <button style="float: right;margin-top: -38px;" type="button" id="addMoreConvict" class="btn btn-success btn-md"><i class="fa fa-plus"></i> Add More</button>
                            </div>
                            @if(isset($getDefendant))



                                <div id="Convict_details_rows">
                                    @foreach($getDefendant as $value)
                                        <input type="hidden" name="defendantId[]" value="{{$value->id}}">

                                    <div class="panel-body row_element">
                                        <div class="row">
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="exampleInput">Defendant Name<span class="validateRq">*</span></label>
                                                    {!! Form::text('defendantDetails[defendant_name][]', $value->defendant_name, $attributes = array('class'=>'form-control required defendant_name','id'=>'defendant_name','placeholder'=>'Enter Name')) !!}

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                                    {!! Form::number('defendantDetails[defendant_age][]', $value->defendant_age, $attributes = array('class'=>'form-control required defendant_age','id'=>'defendant_age','placeholder'=>'Enter Age')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                                    {{ Form::select('defendantDetails[defendant_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), $value->defendant_gender, array('class' => 'form-control defendant_gender required')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Father Name</label>
                                                    {!! Form::text('defendantDetails[defendant_father_name][]', $value->defendant_father_name, $attributes = array('class'=>'form-control fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Mother Name</label>
                                                    {!! Form::text('defendantDetails[defendant_mother_name][]', $value->defendant_mother_name, $attributes = array('class'=>'form-control convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                                    {!! Form::text('defendantDetails[defendant_contact_number][]', $value->defendant_contact_number, $attributes = array('class'=>'form-control required convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Permanent Address</label>
                                                    {!! Form::textarea('defendantDetails[defendant_permanent_address][]', $value->defendant_permanent_address, $attributes = array('class'=>'form-control convict_permanent_address','id'=>'convict_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                                    {!! Form::textarea('defendantDetails[defendant_present_address][]', $value->defendant_present_address, $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                        </div>


                                    </div>
                                    @endforeach
                                </div>

                                @else
                                <div id="Convict_details_rows">
                                    <div class="panel-body row_element">
                                        <div class="row">
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="exampleInput">Defendant Name<span class="validateRq">*</span></label>
                                                    {!! Form::text('defendantDetails[defendant_name][]', '', $attributes = array('class'=>'form-control required defendant_name','id'=>'defendant_name','placeholder'=>'Enter Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                                    {!! Form::number('defendantDetails[defendant_age][]', '', $attributes = array('class'=>'form-control required defendant_age','id'=>'defendant_age','placeholder'=>'Enter Age')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                                                    {{ Form::select('defendantDetails[defendant_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control convict_gender required')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Father Name</label>
                                                    {!! Form::text('defendantDetails[defendant_father_name][]', '', $attributes = array('class'=>'form-control fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Mother Name</label>
                                                    {!! Form::text('defendantDetails[defendant_mother_name][]', '', $attributes = array('class'=>'form-control convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                                    {!! Form::text('defendantDetails[defendant_contact_number][]', '', $attributes = array('class'=>'form-control required convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Permanent Address</label>
                                                    {!! Form::textarea('defendantDetails[defendant_permanent_address][]', '', $attributes = array('class'=>'form-control convict_permanent_address','id'=>'convict_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                                                    {!! Form::textarea('defendantDetails[defendant_present_address][]', '', $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                                                </div>
                                            </div>
                                            <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                        </div>


                                    </div>
                                </div>

                                @endif
                            </div>
                    <div class="row">
                        <div class="box-footer">
                            @if(@$editComplain)
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

</section>
<!--  append section -->

<div class="row_element1" style="display: none;">
    <div class="panel-body row_element">
        <div class="row">
            <div class="col-md-3">

                <div class="form-group">
                    <label for="exampleInput">Defendant Name<span class="validateRq">*</span></label>
                    {!! Form::text('defendantDetails[defendant_name][]', '', $attributes = array('class'=>'form-control required convict_name','id'=>'convict_name','placeholder'=>'Enter Name')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                    {!! Form::number('defendantDetails[defendant_age][]', '', $attributes = array('class'=>'form-control required convict_age','id'=>'convict_age','placeholder'=>'Enter Age')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>
                    {{ Form::select('defendantDetails[defendant_gender][]', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control convict_gender required')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Father Name</label>
                    {!! Form::text('defendantDetails[defendant_father_name][]', '', $attributes = array('class'=>'form-control fatherName','id'=>'fatherName','placeholder'=>'Enter Father Name')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Mother Name</label>
                    {!! Form::text('defendantDetails[defendant_mother_name][]', '', $attributes = array('class'=>'form-control convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                    {!! Form::text('defendantDetails[defendant_contact_number][]', '', $attributes = array('class'=>'form-control required convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Permanent Address</label>
                    {!! Form::textarea('defendantDetails[defendant_permanent_address][]', '', $attributes = array('class'=>'form-control convict_permanent_address','id'=>'convict_permanent_address','placeholder'=>'Enter Permanent Address','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Present  Address<span class="validateRq">*</span></label>
                    {!! Form::textarea('defendantDetails[defendant_present_address][]', '', $attributes = array('class'=>'form-control required presentAddress','id'=>'presentAddress','placeholder'=>'Enter Present Address','cols'=>'30','rows'=>'2')) !!}
                </div>
                <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
            </div>
        </div>


    </div>
</div>








@endsection
