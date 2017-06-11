@extends('admin.master')
@section('content')
@section('title','Convict Arrest Information')
<script type="text/javascript">

    jQuery(function (){
            
        $("#convictArrestInfoForm").validate();


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
                        <li class="active">Add Convict Arrest Information</li>
                    </ol>
                </div>

                <div class="panel-body" style="height: auto; min-height: 500px;">
                    @if(@$parentData)
                        {{ Form::model(@$parentData, array('route' => array('convictarrestinfo.update', @$parentData->id), 'method' => 'PUT', 'id'=>'convictArrestInfoForm','enctype'=>'multipart/form-data')) }}
                    @else
                        {{ Form::open(array('route' => 'convictarrestinfo.store','enctype'=>'multipart/form-data')) }}
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
                                        {!! Form::text('date', ((isset($parentData)) ? dateConvertDBtoForm($parentData->date) : ''), $attributes = array('class'=>'form-control  dateField','id'=>'name','placeholder'=>'Enter Convict Arrest Date', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInput">Attach</label>
                                        {!! Form::file('attachment', '', $attributes = array('class'=>'form-control attach','id'=>'attach')) !!}
                                    </div>
                                    @if(@$parentData->attach !='')
                                      <a href="{!! url('public/uploads/convictarrestinfoattach/'.$parentData->attach) !!}" download class="btn btn-primary">Download</a>
                                    @endif
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
                                            <label for="exampleInput">Place<span class="validateRq">*</span></label>
                                            {!! Form::text('details[place][]', $row->place, $attributes = array('class'=>'form-control required','placeholder'=>'Enter Place', 'required'=>'required')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleInput">Legal Goods Seized</label>
                                            {!! Form::textarea('details[legal_goods_seized][]', $row->legal_goods_seized, $attributes = array('class'=>'form-control','placeholder'=>'Enter Legal Goods Seized Description','cols'=>'30','rows'=>'2')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleInput">Illegal Goods Seized</label>
                                            {!! Form::textarea('details[illegal_goods_seized][]', $row->illegal_goods_seized, $attributes = array('class'=>'form-control','placeholder'=>'Enter Illegal Goods Seized Description','cols'=>'30','rows'=>'2')) !!}
                                        </div>
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
                    <label for="exampleInput">Place<span class="validateRq">*</span></label>
                    {!! Form::text('details[place][]', '', $attributes = array('class'=>'form-control required','placeholder'=>'Enter Place', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-md-2 text-right">
                <span class="badge deleteVictims" style="background: red;margin-top: 25px;cursor: pointer;">X</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="exampleInput">Legal Goods Seized</label>
                    {!! Form::textarea('details[legal_goods_seized][]', '', $attributes = array('class'=>'form-control','placeholder'=>'Enter Legal Goods Seized Description','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="exampleInput">Illegal Goods Seized</label>
                    {!! Form::textarea('details[illegal_goods_seized][]', '', $attributes = array('class'=>'form-control','placeholder'=>'Enter Illegal Goods Seized Description','cols'=>'30','rows'=>'2')) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
