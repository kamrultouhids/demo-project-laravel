<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','Battalion')
<script>
    jQuery(function (){
        $("#battalionForm").validate();

        $(document).on("change","#DivisionId",function(){
            var action = "{{ URL::to('battalion/getDivisionWiseDistrict') }}";
            var divisionId=$('#DivisionId').val();
            var token =$('input[name=_token]').val();
            if(divisionId) {
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: {'divisionId': divisionId, '_token': token},
                    dataType: 'json',
                    success: function (data) {
                        $('#districtId').html('<option value="">---- Select District ----</option>')
                        $.each(data, function(key, value) {
                            $('#districtId').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('#districtId').html('<option value="">---- Select District ----</option>');
            }
        });

        $(document).on("change","#districtId",function(){
            var action = "{{ URL::to('battalion/getDistrictWisePoliceStation') }}";
            var districtId=$('#districtId').val();
            var token = $('input[name=_token]').val();
            if(districtId) {
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: {'districtId': districtId, '_token': token},
                    dataType: 'json',
                    success: function (data) {
                        $('#policeStationId').html('<option value="">---- Select Police Station ----</option>')
                        $.each(data, function(key, value) {
                            $('#policeStationId').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('#policeStationId').html('<option value="">---- Select Police Station ----</option>');
            }
        });

        $(document).on("change","#contactPersonId",function(){
            var action = "{{ URL::to('battalion/getEmployeeWiseDesignation') }}";
            var contactId=$('#contactPersonId').val();
            var token =$('input[name=_token]').val();
            if(contactId) {
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: {'contactId': contactId, '_token': token},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.fk_designation_id);
                        $('.designation').val(data.fk_designation_id).trigger("change");
                    }
                });
            }else{
                $('.designation').val('').trigger("change");
            }
        });
    });
    @if(isset($editBattalion))
        {!! "$('#DivisionId').trigger('change');" !!}
    @endif
    @if(isset($editBattalion))
        {!! "$('#districtId').trigger('change');" !!}
    @endif


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
                        <li><a href="{{URL::to('battalion')}}"><i></i>
                                <span id="Label65">Click For Battalion List</span>
                            </a>
                        </li>
                        @if(@$editBattalion)
                        <li class="active">Edit Battalion</li>
                        @else
                        <li class="active">Add Battalion</li>
                        @endif
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                        @if(@$editBattalion)
                            <form role="form" id="battalionForm" method="post" action="{{ route('battalion.update',@$editBattalion->id) }}">
                             <input name="_method" type="hidden" value="PATCH">
                        @else
                             <form role="form" id="battalionForm" method="post" action="{{  route('battalion.store') }}">
                         @endif
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Division Name<span class="required_field">*</span></label>
                                        <select name="fk_division_id" class="form-control select2 required" id="DivisionId" style="width: 100%;">
                                            <option value="">---- Select Division ----</option>
                                            @foreach($division as $value)
                                            <option value="{{ $value->id }}" @if(@$editBattalion->fk_division_id == $value->id) {{ "selected" }} @endif >{{ $value->division_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('fk_division_id'))
                                        <span class="validation_msg">
                                                <strong>{{ $errors->first('fk_division_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">District Name<span class="required_field">*</span></label>
                                        <select name="fk_district_id" id="districtId"  class="form-control select2 required" style="width: 100%;">
                                            <option value="">---- Select District ----</option>
                                            @if(isset($editBattalion))
                                            @foreach($district as $value)
                                            <option value="{{ $value->id }}" @if(@$editBattalion->fk_district_id == $value->id) {{ "selected" }} @endif>{{ $value->district_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has('fk_district_id'))
                                        <span class="validation_msg">
                                            <strong>{{ $errors->first('fk_district_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Police Station Name<span class="required_field">*</span></label>
                                        <select name="fk_police_station_id" id="policeStationId" class="form-control select2 required"  style="width: 100%;">
                                            <option value="">----  Select Police Station ----</option>
                                            @if(isset($editBattalion))
                                            @foreach($policeStation as $value)
                                                <option value="{{ $value->id }}" @if(@$editBattalion->fk_police_station_id == $value->id) {{ "selected" }} @endif>{{ $value->police_station_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has('fk_police_station_id'))
                                        <span class="validation_msg">
                                            <strong>{{ $errors->first('fk_police_station_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Battalion Name<span class="required_field">*</span></label>
                                        <input type="text" class="form-control required" value="@if(@$editBattalion){{ @$editBattalion->battalion_name }} @endif" id="battalion_name" placeholder="Enter Battalion name" name="battalion_name" value="">
                                        @if($errors->has('battalion_name'))
                                            <span class="validation_msg">
                                            <strong>{{ $errors->first('battalion_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Battalion Address</label>
                                        <input type="text" class="form-control required"  value="@if(@$editBattalion){{ @$editBattalion->battalion_address }} @endif" id="battalion_address" placeholder="Enter Battalion Address" name="battalion_address" value="">
                                        @if($errors->has('battalion_address'))
                                            <span class="validation_msg">
                                            <strong>{{ $errors->first('battalion_address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Contact Person Name<span class="required_field">*</span></label>
                                        <select name="contact_person_name" id="contactPersonId" class="form-control select2 required"  style="width: 100%;">
                                        <option value="">----  select Contact Person ----</option>
                                        @foreach($contactPersonList as $value)
                                            <option value="{{ $value->id }}" @if(@$editBattalion->contact_person_name == $value->id) {{ "selected" }} @endif>{{ $value->employee_name }}</option>
                                        @endforeach
                                        </select>
                                        @if($errors->has('contact_person_name'))
                                            <span class="validation_msg">
                                            <strong>{{ $errors->first('contact_person_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Contact Person Designation<span class="required_field">*</span></label>
                                        {{ Form::select('designation', $designationList, (isset($editBattalion)) ? $editBattalion->designation : "", array('class' => 'form-control designation required')) }}
                                        @if($errors->has('designation'))
                                            <span class="validation_msg">
                                            <strong>{{ $errors->first('designation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Mobile No.<span class="required_field">*</span></label>
                                        <input type="text" class="form-control required" value="@if(@$editBattalion){{ @$editBattalion->contact_no }} @endif" id="contact_no" placeholder="Enter Mobile No." name="contact_no" value="">
                                        @if($errors->has('contact_no'))
                                            <span class="validation_msg">
                                            <strong>{{ $errors->first('contact_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                @if(@$editBattalion)
                                <button type="submit" class="action-button" style="width: 100px;margin-left: -9px;">Update</button>
                                @else
                                <button type="submit" class="action-button" style="width: 100px;margin-left: -9px;">Save</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
