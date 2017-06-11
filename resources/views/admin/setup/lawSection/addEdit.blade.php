<style>
    .validation_msg {
        color: red;
    }
</style>
@extends('admin.master')
@section('content')
@section('title','Law Section')
<script>
    jQuery(function (){
        $("#lawSectionForm").validate();
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
                        <li><a href="{{URL::to('lawSection')}}"><i></i>
                                <span id="Label65">Click For Law Section List</span>
                            </a>
                        </li>
                        @if(@$editLawSection)
                            <li class="active">Edit Law Section</li>
                        @else
                            <li class="active">Add Law Section</li>
                        @endif
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$editLawSection)
                    {{ Form::model(@$editLawSection, array('route' => array('lawSection.update', @$editLawSection->id), 'method' => 'PUT','id' => 'lawSectionForm')) }}
                    @else
                    {{ Form::open(array('route' => 'lawSection.store','id' => 'lawSectionForm')) }}
                    @endif
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('name', 'Law Section Name') }}<span class="required_field">*</span>
                                                {{ Form::text('section_name', Input::old('section_name'), array('class' => 'form-control required','placeholder' => 'Law Section Name')) }}
                                                @if($errors->has('section_name'))
                                                <span class="validation_msg">
                                                     <strong>{{ $errors->first('section_name') }}</strong>
                                                 </span>
                                                @endif
                                            </div>
                                        </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('name', 'Law Section Description') }}<span class="required_field">*</span>
                                                {{ Form::textarea('section_description', Input::old('section_description'), array('class' => 'form-control required','placeholder' => 'Law Section Name')) }}
                                                @if($errors->has('section_description'))
                                                    <span class="validation_msg">
                                                     <strong>{{ $errors->first('section_description') }}</strong>
                                                 </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        @if(@$editLawSection)
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
    </div>
</section>
@endsection
