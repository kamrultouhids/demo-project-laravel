<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','PoliceStation')
    <script>
        jQuery(function (){

            $("#policeStationForm").validate();

            $(document).on("change","#DivisionId",function(){
                var action = "{{ URL::to('policeStation/getDistrict') }}";
                var divisionId=$('#DivisionId').val();
                if(divisionId) {
                    $.ajax({
                        type: 'POST',
                        url: action,
                        data: {'divisionId': divisionId, '_token': $('input[name=_token]').val()},
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

        });

        @if(isset($editPoliceStation))
            {!! "$('#DivisionId').trigger('change');" !!}
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
                            <li><a href="{{URL::to('policeStation')}}"><i></i>
                                    <span id="Label65">Click For Police Station List</span>
                                </a>
                            </li>
                            @if(@$editPoliceStation)
                                <li class="active">Edit Police Station</li>
                            @else
                                <li class="active">Add Police Station</li>
                            @endif
                        </ol>
                    </div>
                    <div class="panel-body" style="height: auto; min-height: 500px;">
                        @if(@$editPoliceStation)
                            <form role="form" id="policeStationForm" method="post" action="{{ route('policeStation.update',@$editPoliceStation->id) }}">
                                <input name="_method" type="hidden" value="PATCH">
                                @else
                                    <form role="form" id="policeStationForm" method="post" action="{{  route('policeStation.store') }}">
                                        @endif
                                        {{ csrf_field() }}
                                        <div class="box-body">
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInput">Division Name<span class="required_field">*</span></label>
                                                        <select name="fk_division_id" id="DivisionId" class="form-control select2 required" style="width: 100%;">
                                                            <option value="">---- Select Division ----</option>
                                                            @foreach($division as $value)
                                                                <option value="{{ $value->id }}" @if(@$editPoliceStation->fk_division_id == $value->id) {{ "selected" }} @endif >{{ $value->division_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('fk_division_id'))
                                                            <span class="validation_msg">
                                                    <strong>{{ $errors->first('fk_division_id') }}</strong>
                                                 </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInput">District Name<span class="required_field">*</span></label>
                                                        <select name="fk_district_id" id="districtId" class="form-control select2 required"
                                                                style="width: 100%;">
                                                            <option value="">---- Select District ----</option>
                                                            @if(isset($editPoliceStation))
                                                                @foreach($district as $value)
                                                                    <option value="{{ $value->id }}" @if(@$editPoliceStation->fk_district_id == $value->id) {{ "selected" }} @endif>{{ $value->district_name }}</option>
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
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInput">Police Station Name<span class="required_field">*</span></label>
                                                        <input type="text" class="form-control required" id="police_station_name" placeholder="Police Station Name" name="police_station_name" value="@if(@$editPoliceStation){{ @$editPoliceStation->police_station_name }} @endif">
                                                        @if($errors->has('police_station_name'))
                                                            <span class="validation_msg">
                                                                <strong>{{ $errors->first('police_station_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                @if(@$editPoliceStation)
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
