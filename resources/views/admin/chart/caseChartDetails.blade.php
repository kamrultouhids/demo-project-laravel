@extends('admin.master')
@section('content')
@section('title','View Case Chart Details')


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
                        <li class="active">View Case Chart Details</li>
                    </ol>


                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    <table id="example" class="table table-bordered table-hover table-responsive">
                        <thead>
                        <tr style="background-color: #ddd">
                            <th>S/L</th>
                            <th>Reference No</th>
                            <th>Created Date</th>
                            <th>Crime Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key=>$row)
                            <tr class="{!! $row->id !!}">
                                <td style="width: 100px;">{{ ($key+1) }}</td>
                                <td>{{ $row->reference_no }}</td>
                                <td>{{ dateConvertDBtoForm($row->created_at) }}</td>
                                <td>{{ dateConvertDBtoForm($row->crime_time) }}</td>

                                <td style="width: 100px;">
                                    <a target="_blank" href="{{ URL::to('case') }}/{{$row->id }}"  class="btn btn-success btn-xs"> <i class="fa fa-list" aria-hidden="true" style="color: black;"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
