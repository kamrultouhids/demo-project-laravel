@extends('admin.master')
@section('content')
@section('title','Charge Sheet')
<script type="text/javascript">

    jQuery(function (){
            
        $('#loadCase').on('click', function(){
            var caseID = $('.case_id').val();
            $.ajax({
                url:"{{ URL::to('case/getCaseConvict/') }}/"+caseID,
                type: 'GET',
                data: {},
                success: function (data) {
                    $('#convict_box').html('');
                    $.each(data, function(k, v){
                        var setVal = $('.convict_apped_row').html();
                        $('#convict_box').append(setVal);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.name').val(v.convict_name);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.age').val(v.convict_age);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.gender').val(v.convict_gender);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.father').val(v.convict_father_name);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.mother').val(v.convict_mother_name);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.contact').val(v.convict_contact_number);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.permanent').val(v.convict_permanent_address);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.present').val(v.convict_present_address);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.haveAnyCase').val(v.convict_pastcase);
                        $('#convict_box').find('.convict_row_element').eq(k).find('.details').val(v.convict_details);
                    })
                }
            });
        })


        $('#addMoreConvict').on('click', function(){
            var appendHTML = $('.convict_apped_row').html();
            $('#convict_box').append(appendHTML);
        });

       
        $(document).on("click",".deleteVictims",function(){
            $(this).parents('.convict_row_element').remove();
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
                        <li class="active">Add Charge Sheet</li>
                    </ol>
                </div>

                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$parentData)
                        {{ Form::model(@$parentData, array('route' => array('chargesheet.update', @$parentData->id), 'method' => 'PUT','enctype'=>'multipart/form-data')) }}
                    @else
                        {{ Form::open(array('route' => 'chargesheet.store','enctype'=>'multipart/form-data')) }}
                    @endif


                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Basic Information</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Case No</label>

                                        {{ Form::select('case_id', $caseReference,  (isset($parentData)) ? $parentData->case_id : "", array('class' => 'form-control case_id required')) }}

                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label for="exampleInput">&nbsp;</label>
                                    <button type="button" class="btn" id="loadCase">Load</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Date</label>
                                        {!! Form::text('date', ((isset($parentData)) ? dateConvertDBtoForm($parentData->date) : ''), $attributes = array('class'=>'form-control  dateField','id'=>'name','placeholder'=>'Enter Date', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Chargesheet Copy</label>
                                        {!! Form::file('chargesheet_attach',$attributes = array('class'=>'form-control investigation_attach','id'=>'investigation_attach')) !!}
                                    </div>
                                    @if(@$parentData->chargesheet_attach !='')
                                        <a href="{!! url('public/uploads/chargesheetFile/'.$parentData->chargesheet_attach) !!}" download class="btn btn-primary">Download</a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Convict Details</span>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <button style="float: right;margin-top: -38px;" type="button" id="addMoreConvict" class="btn btn-success btn-md"><i class="fa fa-plus"></i> Add More</button>
                        </div>


                        <div id="convict_box">

                            @if (isset($childData))
                            @foreach ($childData as $row)
                            <div class="panel-body convict_row_element">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Convict Name<span class="validateRq">*</span></label>
                                            {!! Form::text('details[id][]', $row->id, $attributes = array('class'=>'form-control hide','id'=>'name', 'readonly' => 'true')) !!}

                                            {!! Form::text('details[convict_name][]', $row->convict_name, $attributes = array('class'=>'form-control required name','id'=>'name','placeholder'=>'Enter Name', 'required'=>'required')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Age<span class="validateRq">*</span></label>
                                            {!! Form::text('details[convict_age][]', $row->convict_age, $attributes = array('class'=>'form-control required age','placeholder'=>'Enter Place', 'required'=>'required')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Gender<span class="validateRq">*</span></label>

                                            {{ Form::select('details[convict_gender][]', array('Male' => 'Male', 'Female' => 'Female'),$row->convict_gender, array('class' => 'form-control required gender', 'required'=>'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Father Name</label>
                                            {!! Form::text('details[convict_father_name][]', $row->convict_father_name, $attributes = array('class'=>'form-control father','placeholder'=>'Enter Place')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Mother Name</label>
                                            {!! Form::text('details[convict_mother_name][]', $row->convict_mother_name, $attributes = array('class'=>'form-control mother','placeholder'=>'Enter Place')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                                            {!! Form::text('details[convict_contact_number][]', $row->convict_contact_number, $attributes = array('class'=>'form-control required contact','placeholder'=>'Enter Place', 'required'=>'required')) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Have Any Case Past ?</label>
                                            {{ Form::select('details[convict_pastcase][]', array('0' => 'No', '1' => 'Yes'),$row->convict_pastcase, array('class' => 'form-control haveAnyCase')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Permanent Address</label>
                                            {!! Form::textarea('details[convict_permanent_address][]', $row->convict_permanent_address, $attributes = array('class'=>'form-control permanent','placeholder'=>'Enter Place', 'cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Present Address</label>
                                            {!! Form::textarea('details[convict_present_address][]', $row->convict_present_address, $attributes = array('class'=>'form-control present','placeholder'=>'Enter Place', 'cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInput">Convict Details</label>
                                            {!! Form::textarea('details[convict_details][]', $row->convict_details, $attributes = array('class'=>'form-control details','placeholder'=>'Enter Place', 'cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-right">
                                        <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                            @endif

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
<!-- 'chargesheet_information_id', 'convict_name', 'convict_age', 'convict_gender', 'convict_father_name', 'convict_mother_name', 'convict_contact_number', 'convict_permanent_address', 'convict_present_address', 'convict_pastcase', 'convict_details' -->
<!--  append section -->
<div class="convict_apped_row" style="display: none;">
    <div class="panel-body convict_row_element">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Convict Name<span class="validateRq">*</span></label>
                    {!! Form::text('details[convict_name][]', '', $attributes = array('class'=>'form-control required name','id'=>'name','placeholder'=>'Enter Name', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Age<span class="validateRq">*</span></label>
                    {!! Form::text('details[convict_age][]', '', $attributes = array('class'=>'form-control required age','placeholder'=>'Enter Place', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Gender<span class="validateRq">*</span></label>

                    {{ Form::select('details[convict_gender][]', array('Male' => 'Male', 'Female' => 'Female'),'No', array('class' => 'form-control required gender', 'required'=>'required')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Father Name</label>
                    {!! Form::text('details[convict_father_name][]', '', $attributes = array('class'=>'form-control father','placeholder'=>'Enter Place')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Mother Name</label>
                    {!! Form::text('details[convict_mother_name][]', '', $attributes = array('class'=>'form-control mother','placeholder'=>'Enter Place')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Contact Number<span class="validateRq">*</span></label>
                    {!! Form::text('details[convict_contact_number][]', '', $attributes = array('class'=>'form-control required contact','placeholder'=>'Enter Place', 'required'=>'required')) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Have Any Case Past ?</label>
                    {{ Form::select('details[convict_pastcase][]', array('0' => 'No', '1' => 'Yes'),0, array('class' => 'form-control haveAnyCase')) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Permanent Address</label>
                    {!! Form::textarea('details[convict_permanent_address][]', '', $attributes = array('class'=>'form-control permanent','placeholder'=>'Enter Place', 'cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Present Address</label>
                    {!! Form::textarea('details[convict_present_address][]', '', $attributes = array('class'=>'form-control present','placeholder'=>'Enter Place', 'cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInput">Convict Details</label>
                    {!! Form::textarea('details[convict_details][]', '', $attributes = array('class'=>'form-control details','placeholder'=>'Enter Place', 'cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>

            <div class="col-md-2 text-right">
                <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
            </div>
        </div>
    </div>
</div>

@endsection
