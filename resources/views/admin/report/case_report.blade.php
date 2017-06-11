
@extends('admin.master')
@section('content')
@section('title','Case Report')
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
                var action = "{{ URL::to('CaseReport/getCaseReport') }}";

                var reference_no=$('[name=reference_no]').val();
                var litigant_name=$('[name=litigant_name]').val();
                var litigant_battalion=$('[name=litigant_battalion]').val();

                var convict_gender=$('[name=convict_gender]').val();
                var convict_from_age=$('[name=convict_from_age]').val();
                var convict_to_age=$('[name=convict_to_age]').val();

                var victim_from_age=$('[name=victim_from_age]').val();
                var victim_to_age=$('[name=victim_to_age]').val();
                var victim_gender=$('[name=victim_gender]').val();

                var crime_type=$('[name=crime_type]').val();
                var crime_time=$('[name=crime_time]').val();
                var crime_from_date=$('[name=crime_from_date]').val();
                var crime_to_date=$('[name=crime_to_date]').val();

                var fk_division_id=$('[name=fk_division_id]').val();
                var fk_district_id=$('[name=fk_district_id]').val();
                var fk_police_station_id=$('[name=fk_police_station_id]').val();

                var status=$('[name=status]').val();
                var pdfUrl = "{{ URL::to('CaseReportPdf') }}";

                var filterData = {
                    '_token': $('input[name=_token]').val(),
                    'reference_no':reference_no,
                    'litigant_name':litigant_name,
                    'litigant_battalion':litigant_battalion,
                    'convict_gender':convict_gender,
                    'convict_from_age':convict_from_age,
                    'convict_to_age':convict_to_age,
                    'victim_from_age':victim_from_age,
                    'victim_to_age':victim_to_age,
                    'victim_gender':victim_gender,
                    'crime_type':crime_type,
                    'crime_from_date':crime_from_date,
                    'crime_to_date':crime_to_date,
                    'fk_division_id':fk_division_id,
                    'fk_district_id':fk_district_id,
                    'fk_police_station_id':fk_police_station_id,
                    'status':status,
                };


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
                    $('#downloadCaseReport').attr('href',pdfUrl+"?data="+JSON.stringify(filterData));
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
                    var crime_time = v['crime_time'];
                    var url ='<a target="_blank" href="{{ URL::to('case') }}/'+v['id']+'"  class="btn btn-success btn-xs"> <i class="fa fa-list" aria-hidden="true" style="color: black;"></i></a>';
                    sl++;
                    tableFormat += "<tr style='background:#f4f4f4'>";
                    tableFormat += "<td>"+sl+"</td>";
                    tableFormat += "<td>"+v['reference_no']+"</td>";
                    tableFormat += "<td>"+v['employee_name']+"</td>";
                    tableFormat += "<td>"+v['battalion_name']+"</td>";
                    tableFormat += "<td>"+crime_time+"</td>";
                    tableFormat += "<td>"+v['crime_type_name']+"</td>";
                    tableFormat += "<td>"+<?=json_encode(caseStatus())?>[v['status']]+"</td>";
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
                             <li class="active">Case Report</li>
                        </ol>
                    </div>

                    <div class="panel-body" style="height: auto; min-height: 500px;">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <span data-toggle="collapse" data-target="#filter-panel" class="filterData"><i class="glyphicon glyphicon-filter"></i>Filter</span>
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="collapse" data-target="#filter-panel" style="float:right;margin-top: -38px;" aria-expanded="true">
                                <span class="glyphicon glyphicon-cog"></span> Filter Case
                            </button>
                            <div class="panel-body">
                                <div id="filter-panel" class="filter-panel collapse" aria-expanded="false" style="height: 0px;">
                                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Reference No</label>
                                                {!! Form::select('reference_no',$caseListList,'', $attributes = array('class'=>'form-control  reference_no','id'=>'reference_no')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Litigant Name</label>
                                                {{ Form::select('litigant_name', $employeeList,'', array('class' => 'form-control litigant_name')) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Battalion</label>
                                                {{ Form::select('litigant_battalion', $battalionList,'', array('class' => 'form-control litigant_battalion')) }}

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">status</label>
                                                {{ Form::select('status', caseStatus(),"", array('class' => 'form-control status')) }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Convict Gender</label>
                                                {{ Form::select('convict_gender', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control convict_gender')) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Convict From Age</label>
                                                {!! Form::number('convict_from_age','', $attributes = array('class'=>'form-control  convict_from_age','id'=>'convict_from_age','placeholder'=>'Enter Convict From Range')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Convict To Age</label>
                                                {!! Form::number('convict_to_age','', $attributes = array('class'=>'form-control  convict_to_age','id'=>'convict_to_age','placeholder'=>'Enter Convict To Range')) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Crime Type</label>
                                                {{ Form::select('crime_type', $crimeTypeList,'', array('class' => 'form-control crime_type')) }}
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Victim Gender</label>
                                                {{ Form::select('victim_gender', array('' => '--- Please select ---', 'Male' => 'Male', 'Female' => 'Female'), '', array('class' => 'form-control victim_gender')) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Victim From Age</label>
                                                {!! Form::number('victim_from_age','', $attributes = array('class'=>'form-control victim_from_age','id'=>'victim_from_age','placeholder'=>'Enter Victim From Range')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Victim To Age</label>
                                                {!! Form::number('victim_to_age','', $attributes = array('class'=>'form-control victim_to_age','id'=>'victim_to_age','placeholder'=>'Enter Victim To Range')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Crime Date From</label>
                                                {!! Form::text('crime_from_date','', $attributes = array('class'=>'form-control required crime_from_date dateField','id'=>'crime_from_date','placeholder'=>'Enter Crime From Date')) !!}
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

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInput">Crime To From</label>
                                                {!! Form::text('crime_to_date','', $attributes = array('class'=>'form-control required crime_to_date dateField','id'=>'crime_to_date','placeholder'=>'Enter Crime To Date')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="action-button" id="filter" style="width: 100px;margin-left: -10px;">Filter</button>
                                    </div>
                                    <h4 class="text-right">
                                        <a target="_blank" class="btn btn-success" id="downloadCaseReport" href=""><i class="fa fa-download fa-lg" aria-hidden="true"></i> Download</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <span><b>Case Report</b></span>
                            </div>
                            <div class="panel-body">
                                <table id="example" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S/l</th>
                                            <th>Reference No</th>
                                            <th>Litigant Name</th>
                                            <th>Battalion</th>
                                            <th>Crime Date</th>
                                            <th>Crime Type</th>
                                            <th>Status</th>
                                            <th>Details</th>
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
