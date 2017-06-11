@extends('admin.master')
@section('content')
@section('title','View User')
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
                        <li class="active">View User</li>
                    </ol>
                </div>
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
                    <h4>
                        <a href="{{ URL::to('Add-User') }}" class="btn btn-success pull-left">Add User</a>
                    </h4>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    <table id="example" class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr style="background: #ddd">
                                <th>S/L</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Picture</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {!! $sl=null !!}
                            @foreach($data AS $value)
                                <tr>
                                    <td>{!! ++$sl !!}</td>
                                    <td>{!! $value->name !!}</td>
                                    <td>{!! $value->email !!}</td>
                                    <td>
                                        <img src="img/{!! $value->pic_name !!}" style="width:50px; height:50px">
                                    </td>
                                    <td style="width: 77px;">
                                        <a href="{!! route('edit-user.edit',$value->id) !!}" title="Edit" class="btn btn-success btn-xs">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <a href="{!!route('delete-user.delete',$value->id )!!}" class="delete btn btn-danger btn-xs deleteBtn" onclick="if(confirm('are you sure??')){return true;}else{return false;}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
