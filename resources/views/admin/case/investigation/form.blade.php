
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
       // $("#investagition").validate();
        $('#addMoreConvict').click(function(){

            $('#Convict_details_rows1').append('<div class="panel-body row_element1">' + $('.row_element2').html() + '</div>');

        });


        $(document).on("click",".deleteConvict",function(){
            $(this).parents('.row_element1').remove();
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
                        @if(@$editInvestigationSelect)
                            <li class="active">Edit Investigation</li>
                        @else
                            <li class="active">Add Investigation</li>
                        @endif

                    </ol>
                </div>

                <div class="panel-body" style="height: auto; min-height: 500px;">

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    @foreach($errors->all() as $error)
                                        <strong>{!! $error !!}</strong><br>
                                    @endforeach
                            </div>
                        @endif

                    @if(@$editInvestigation)
                        {{ Form::model(@$editInvestigationSelect, array('route' => array('investigation.update', @$editInvestigationSelect->id), 'method' => 'PUT','id'=>'investagition','files'=>'true')) }}
                    @else
                        {{ Form::open(array('route' => 'investigation.store' , 'id'=>'investagition', 'enctype'=>'multipart/form-data')) }}
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
                            <span>Investigation Details</span>
                        </div>

                        <div id="Convict_details_rows">
                            <div class="panel-body row_element">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Investigation Date <span class="validateRq">*</span></label>
                                            {!! Form::text('investigation_date',(@$editInvestigationSelect) ? dateConvertDBtoForm($editInvestigationSelect->investigation_date) : '', $attributes = array('class'=>'form-control required crimeTime dateField','id'=>'datetimepicker1','placeholder'=>'Enter Crime Time')) !!}

                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Case Number<span class="validateRq">*</span></label>

                                           {!! Form::select('case_number', $selectCaseList, isset($editInvestigationSelect) ? $editInvestigationSelect->case_number : '', array('class'=>'form-control required','id'=>'age')) !!}
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput"> Investigation Details<span class="validateRq">*</span></label>
                                            {!! Form::textarea('investigation_details',(@$editInvestigationSelect) ? $editInvestigationSelect->investigation_details : '', $attributes = array('class'=>'form-control required detailsInformation','id'=>'detailsInformation','placeholder'=>'Enter Details Information','cols'=>'30','rows'=>'2')) !!}

                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput"> Investigation By<span class="validateRq">*</span></label>

                                                {{ Form::select('investigation_by', $selectRabEmployeeList,  (isset($editInvestigationSelect)) ? $editInvestigationSelect->investigation_by : "", array('class' => 'form-control case_id required')) }}

                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInput">Investigation Copy</label>
                                            {!! Form::file('investigation_attach', '', $attributes = array('class'=>'form-control investigation_attach','id'=>'investigation_attach')) !!}
                                        </div>
                                        @if(@$editInvestigationSelect->investigation_attach !='')
                                            <a href="{!! url('public/uploads/investigationFile/'.$editInvestigationSelect->investigation_attach) !!}" download class="btn btn-primary">Download</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span> Attended Person </span>
                            <button style="float: right;margin-top: -6px;" type="button" id="addMoreConvict" class="btn btn-success btn-md"><i class="fa fa-plus"></i> Add More</button>
                        </div>
                        <div class="col-lg-12 col-md-12">


                        </div>
                        @if(@$editInvestigation)
                            @foreach($editInvestigation as $editInvestigation)
                                <input type="hidden" name="attenedId[]" value="{{$editInvestigation->attenedPersonId}}">
                                <div id="Convict_details_rows1">
                                    <div class="panel-body row_element1">
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                    <label for="exampleInput">Attended person<span class="validateRq">*</span></label>
                                                     <select name="attended_person[]" class="form-control">
                                                        <option>Select One</option>
                                                        @foreach ($rabEmployeeSelect as $rabEmployeeSelectssss)
                                                            <option value="{{$rabEmployeeSelectssss->id}}" @if(@$editInvestigation->attended_person == $rabEmployeeSelectssss->id){{ "selected" }} @endif>{{$rabEmployeeSelectssss->employee_name}}</option>
                                                        @endforeach
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                    <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                             </div>
                                         </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div id="Convict_details_rows1">
                                <div class="panel-body row_element1">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Attended person<span class="validateRq">*</span></label>
                                                <select name="attended_person[]" class="form-control required ">
                                                    <option value="">Select One</option>
                                                    @foreach ($rabEmployeeSelect as $rabEmployeeSelectss)
                                                    <option value="{{$rabEmployeeSelectss->id}}">{{$rabEmployeeSelectss->employee_name}}</option>
                                                    @endforeach
                                                </select>

                                     @if($errors->has('attended_person'))span class="validation_msg"><strong>{{ $errors->first('attended_person') }} @endif</strong>
                                                 </span>

                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                            <span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                        </div>
                                        </div>
                                    </div>
                                </div>
 </div>

                        @endif

                    <div class="row">
                        <div class="box-footer">
                            @if(@$editInvestigationSelect)
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


<div class="row_element2" style="display: none;">

<div class="row">

    <div class="col-md-4">
        <div class="form-group">

            <label for="exampleInput">Attended person<span class="validateRq">*</span></label>
            <select name="attended_person[]" class="form-control required">
                <option value="">Select One</option>
                @foreach ($rabEmployeeSelect as $rabEmployeeSelects)
                    <option value="{{$rabEmployeeSelects->id}}">{{$rabEmployeeSelects->employee_name}}</option>
                @endforeach
            </select>
            </div>
        </div>
            <div class="col-md-4"><span class="badge deleteConvict" style="background: red;margin-top: 25px;cursor: pointer;">X</span></div>

        </div>

</div>








@endsection
