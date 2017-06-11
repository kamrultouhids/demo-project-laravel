@extends('admin.master')
@section('content')
@section('title','Convict Not Arrest Information')
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
                        })
                    }
                });
            })

       
        $(document).on("click",".deleteVictims",function(){
            $(this).parents('.convict_row_element').remove();
        });

    });

</script>
<div class="box-header with-border">
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
                        @if(@$parentData)
                        <li class="active">Edit  Coart Information</li>
                            @else
                            <li class="active">Add Coart Information</li>
                            @endif
                    </ol>
                </div>

                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$parentData)
                        {{ Form::model(@$parentData, array('route' => array('coartInfo.update', @$parentData->id), 'method' => 'PUT','enctype'=>'multipart/form-data')) }}
                    @else
                        {{ Form::open(array('route' => 'coartInfo.store','enctype'=>'multipart/form-data')) }}
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
                                        {!! Form::text('date', ((isset($parentData)) ? dateConvertDBtoForm($parentData->date) : ''), $attributes = array('class'=>'form-control  dateField','id'=>'name','placeholder'=>'Enter Report Date', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInput">Coart Copy</label>
                                        {!! Form::file('coart_attachment', $attributes = array('class'=>'form-control investigation_attach','id'=>'investigation_attach')) !!}
                                    </div>
                                    @if(@$parentData->coart_attach !='')
                                        <a href="{!! url('public/uploads/coartFile/'.$parentData->coart_attach) !!}" download class="btn btn-primary">Download</a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Coart Name</label>

                                        {!! Form::text('coart_name', ((isset($parentData)) ? $parentData->coart_name : ''), $attributes = array('class'=>'form-control ','id'=>'name','placeholder'=>'Enter Coart Name', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Judge Name</label>
                                        {!! Form::text('judge_name', ((isset($parentData)) ? $parentData->judge_name : ''), $attributes = array('class'=>'form-control ','id'=>'name','placeholder'=>'Enter Judge Name', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">Judgment</label>
                                        {!! Form::textarea('judgment', ((isset($parentData)) ? $parentData->judgment : ''), $attributes = array('class'=>'form-control', 'cols'=>'30','rows'=>'2' ,'id'=>'name','placeholder'=>'Enter Judgment', 'required'=>'required')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span>Convict Details</span>
                        </div>
                        <div id="convict_box">

                            @if (isset($childData))
                            @foreach ($childData as $row)
                            <div class="panel-body convict_row_element">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleInput">Convict Name<span class="validateRq">*</span></label>
                                            {!! Form::text('details[id][]', $row->id, $attributes = array('class'=>'form-control hide','id'=>'name', 'readonly' => 'true')) !!}
                                            {!! Form::text('details[name][]', $row->name, $attributes = array('class'=>'form-control required name','id'=>'name','placeholder'=>'Enter Name', 'required'=>'required', 'readonly' => 'true')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleInput">Judgment<span class="validateRq">*</span></label>
                                            {!! Form::textarea('details[description][]', $row->description, $attributes = array('class'=>'form-control','placeholder'=>'Enter Judgment','cols'=>'30','rows'=>'2','required'=>'required')) !!}
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

<!--  append section -->
<div class="convict_apped_row" style="display: none;">
    <div class="panel-body convict_row_element">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="exampleInput">Convict Name<span class="validateRq">*</span></label>
                    {!! Form::text('details[name][]', '', $attributes = array('class'=>'form-control required name','id'=>'name','placeholder'=>'Enter Name', 'required'=>'required', 'readonly' => 'true')) !!}
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="exampleInput">Judgment<span class="validateRq">*</span></label>
                    {!! Form::textarea('details[description][]', '', $attributes = array('class'=>'form-control','placeholder'=>'Enter Judgment','cols'=>'30','rows'=>'2', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-md-2 text-right">
                <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
