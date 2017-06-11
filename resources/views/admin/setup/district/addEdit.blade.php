<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','District')
<script>
    jQuery(function (){
        $("#districtForm").validate();
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
                        <li><a href="{{URL::to('district')}}"><i></i>
                                <span id="Label65">Click For District List</span>
                            </a>
                        </li>
                        @if(@$result['editDistrict'])
                            <li class="active">Edit District</li>
                        @else
                            <li class="active">Add District</li>
                        @endif
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$result['editDistrict'])
                        <form role="form" method="post" id="districtForm" action="{{ route('district.update',@$result['editDistrict']->id) }}">
                            <input name="_method"  type="hidden" value="PATCH">
                            @else
                                <form role="form" id="districtForm" method="post" action="{{  route('district.store') }}">
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
                                                    <select name="fk_division_id" class="form-control select2 required"
                                                            style="width: 100%;">
                                                        <option value="">---- Select Division ----</option>
                                                        @foreach($result['divisionInfo'] as $value)
                                                            <option value="{{ $value->id }}" @if(@$result['editDistrict']->fk_division_id == $value->id){{ "selected" }} @endif>{{ $value->division_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('fk_division_id'))
                                                        <span class="validation_msg">
                                                            <strong>{{ $errors->first('fk_division_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInput">District Name<span class="required_field">*</span></label>
                                                    <input type="text" class="form-control required" id="district_name" placeholder="Enter District Name" name="district_name" value="@if(@$result['editDistrict']){{ @$result['editDistrict']->district_name }} @endif">
                                                    @if($errors->has('district_name'))
                                                        <span class="validation_msg">
                                                                <strong>{{ $errors->first('district_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="box-footer">
                                                @if(@$result['editDistrict'])
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
