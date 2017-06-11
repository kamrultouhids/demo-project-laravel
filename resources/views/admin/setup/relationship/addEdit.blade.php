<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','Relationship')
<script>
    jQuery(function (){
        $("#relationShipForm").validate();
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
                        <li><a href="{{URL::to('relationship')}}"><i></i>
                                <span id="Label65">Click For Relationship List</span>
                            </a>
                        </li>
                        @if(@$editRelationship)
                            <li class="active">Edit Relationship</li>
                        @else
                            <li class="active">Add Relationship</li>
                        @endif
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$editRelationship)
                        <form role="form" method="post" id="relationShipForm" action="{{ route('relationship.update',@$editRelationship->id) }}">
                            <input name="_method" type="hidden" value="PATCH">
                            @else
                                <form role="form" id="relationShipForm" method="post" action="{{  route('relationship.store') }}">
                                    @endif
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInput">Relationship Name<span class="required_field">*</span></label>
                                                    <input type="text" class="form-control required" id="relationship_name" placeholder="Enter Relationship name" name="relationship_name" value="@if(@$editRelationship){{ @$editRelationship->relationship_name }} @endif">
                                                    @if($errors->has('relationship_name'))
                                                        <span class="validation_msg">
                                                            <strong>{{ $errors->first('relationship_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            @if(@$editRelationship)
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
