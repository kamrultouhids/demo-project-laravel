
@extends('admin.master')
@section('content')
@section('title','Convict Report')
<style>
    .filterData{ cursor:pointer;font-weight: 700;}
</style>
    <script>
        $(document).ready(function () {
			
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
                    $('#districtId').html('<option value="">---- Please select ----</option>')
                    <?php
                     foreach($district as $value){ ?>
                        $('#districtId').append('<option value="<?php echo  $value->id;?>"> <?php echo $value->district_name;?> </option>');
                   <?php } ?>
                   $('#policeStationId').html('<option value="">---- Please select ----</option>')
                    <?php
                     foreach($policeStation as $value){ ?>
                        $('#policeStationId').append('<option value="<?php echo  $value->id;?>"> <?php echo $value->police_station_name;?> </option>');
                    <?php } ?>
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
							$('#policeStationId').html('<option value="">---- Please select ----</option>')
							$.each(data, function(key, value) {
								$('#policeStationId').append('<option value="'+ key +'">'+ value +'</option>');
							});
						}
					});
				}else{
                    $('#policeStationId').html('<option value="">---- Please select ----</option>')
                    <?php
                     foreach($policeStation as $value){ ?>
                        $('#policeStationId').append('<option value="<?php echo  $value->id;?>"> <?php echo $value->police_station_name;?> </option>');
                    <?php } ?>
                }
			});

            $('#filter').click(function (event) {
                var action = "{{ URL::to('ConvictReport/getConvictReport') }}";

                var case_id=$('[name=case_id]').val();
                var convict_name=$('[name=convict_name]').val();
                var convict_contact_number=$('[name=convict_contact_number]').val();
                var convict_father_name=$('[name=convict_father_name]').val();
                var convict_mother_name=$('[name=convict_mother_name]').val();

                var fk_division_id=$('[name=fk_division_id]').val();
                var fk_district_id=$('[name=fk_district_id]').val();
                var fk_police_station_id=$('[name=fk_police_station_id]').val();

                var law_type=$('[name=law_type]').val();
                var crime_type=$('[name=crime_type]').val();
                var filterData = {
                    '_token': $('input[name=_token]').val(),
                    'case_id':case_id,
                    'convict_name':convict_name,
                    'convict_contact_number':convict_contact_number,
                    'convict_father_name':convict_father_name,
                    'convict_mother_name':convict_mother_name,
                    'fk_division_id':fk_division_id,
                    'fk_district_id':fk_district_id,
                    'fk_police_station_id':fk_police_station_id,
                    'law_type':law_type,
                    'crime_type':crime_type,
                };
                var convictPdfUrl = "{{ URL::to('convictReportPdf') }}";



                $.ajax({
                    url:action,
                    type: 'post',
                    dataType: 'json',
                    data: filterData,
                    beforeSend:function() {
                        $('#filter').attr('disabled',true);
                        $('#filter').html('loading.....');
                    },
                }).done(function (data) {
                    delete(filterData['_token'])
                    $('#downloadConvictReport').attr('href',convictPdfUrl+"?data="+JSON.stringify(filterData));
                    showData(data);
                    $('#filter').attr('disabled',false);
                    $('#filter').html('Filter');
                });
                return false;

            })
        });

        function showData(data) {

            var tableFormat = "";
            var sl=0;
            $.each(data, function(k, v){

                    sl++;
                var url ='<a target="_blank" href="{{ URL::to('case') }}/'+v['case_id']+'",  class="btn btn-success btn-xs"> <i class="fa fa-list" aria-hidden="true" style="color: black;"></i></a>';
                    tableFormat += "<tr style='background:#f4f4f4'>";
                    tableFormat += "<td>"+sl+"</td>";
                    tableFormat += "<td>"+v['reference_no']+"</td>";
                    tableFormat += "<td>"+v['convict_name']+"</td>";
                    tableFormat += "<td>"+v['convict_age']+"</td>";
                    tableFormat += "<td>"+v['convict_gender']+"</td>";
                    tableFormat += "<td>"+v['convict_father_name']+"</td>";
                    tableFormat += "<td>"+v['convict_mother_name']+"</td>";
                    tableFormat += "<td>"+v['convict_contact_number']+"</td>";
                    tableFormat += "<td>"+url+"</td>";
                    tableFormat += "</tr>";
            })
            $('#reportTable').html(tableFormat);
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
                             <li class="active">Convict Report</li>
                        </ol>
                    </div>

                    <div class="panel-body" style="height: auto; min-height: 500px;">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <span data-toggle="collapse" data-target="#filter-panel" class="filterData"><i class="glyphicon glyphicon-filter"></i>Filter</span>
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="collapse" data-target="#filter-panel" style="float:right;margin-top: -38px;" aria-expanded="true">
                                <span class="glyphicon glyphicon-cog"></span> Filter Convict
                            </button>
                            <div class="panel-body">
                                <div id="filter-panel" class="filter-panel collapse" aria-expanded="false" style="height: 0px;">
                                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Case No</label>
                                                {!! Form::select('case_id',$caseListList,'', $attributes = array('class'=>'form-control  case_id','id'=>'case_id')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Convict Name</label>
                                                {!! Form::text('convict_name', '', $attributes = array('class'=>'form-control convict_name','id'=>'convict_name','placeholder'=>'Enter Name')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Contact Number</label>
                                                {!! Form::text('convict_contact_number', '', $attributes = array('class'=>'form-control  convict_contact_number','id'=>'convict_contact_number','placeholder'=>'Enter Contact Number')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Father Name</label>
                                                {!! Form::text('convict_father_name', '', $attributes = array('class'=>'form-control  convict_father_name','id'=>'convict_father_name','placeholder'=>'Enter Father Name')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Mother Name</label>
                                                {!! Form::text('convict_mother_name', '', $attributes = array('class'=>'form-control  convict_mother_name','id'=>'convict_mother_name','placeholder'=>'Enter Mother Name')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Division Name</label>
                                                <select name="fk_division_id" class="form-control select2 required" id="DivisionId" style="width: 100%;">
                                                    <option value="">---- Please select ----</option>
                                                    @foreach($division as $value)
                                                        <option value="{{ $value->id }}">{{ $value->division_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">District Name</label>
                                                <select name="fk_district_id" id="districtId"  class="form-control select2 required" style="width: 100%;">
                                                    <option value="">---- Please select ----</option>
                                                    @foreach($district as $value)
                                                        <option value="{{ $value->id }}">{{ $value->district_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Police Station</label>
                                                <select name="fk_police_station_id" id="policeStationId" class="form-control select2 required"  style="width: 100%;">
                                                    <option value="">----  Please select ----</option>
                                                    @foreach($policeStation as $value)
                                                        <option value="{{ $value->id }}">{{ $value->police_station_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">law Type</label>
                                                {!! Form::select('law_type',$lawList,'', $attributes = array('class'=>'form-control  law_type','id'=>'law_type')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Crime Type</label>
                                                {!! Form::select('crime_type',$crimeTypeList,'', $attributes = array('class'=>'form-control  crime_type  ','id'=>'crime_type  ')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="action-button" id="filter" style="width: 100px;margin-left: -10px;">Filter</button>
                                    </div>
                                    <h4 class="text-right">
                                        <a target="_blank" class="btn btn-success" id="downloadConvictReport" href=""><i class="fa fa-download fa-lg" aria-hidden="true"></i> Download</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <span><b>Convict Report</b></span>
                            </div>
                            <div class="panel-body">
                                <table id="example" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S/l</th>
                                            <th>Case No</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Father Name</th>
                                            <th>Mother Name</th>
                                            <th>Contact Number</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportTable">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
