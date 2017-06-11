@extends('admin.master')
@section('content')
@section('title','View Role')
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
                        <li class="active">View Role</li>
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
                        <a href="{{ URL::to('createRole') }}" class="btn btn-success pull-left">Add Role</a>
                    </h4>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    <table id="example" class="table table-bordered table-hover table-responsive">
                        <thead>
                        <thead>
                            <tr>
                                <th>S/L</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        {!! $sl=null !!}
                        @foreach($data AS $value)
                            <tr>
                                <td>{!! ++$sl !!}</td>
                                <td>{!! $value->role_name !!}</td>
                                <td>
                                    <?php
                                    if($value->status==1){echo "Active";}else{echo "Inactive";}
                                    ?>
                                </td>
                                <td style="width: 77px;">
                                    <a href="{!! route('editRole.edit',$value->id) !!}" title="Edit" class="btn btn-success btn-xs">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="{!!route('deleteRole.delete',$value->id )!!}" class="delete btn btn-danger btn-xs deleteBtn" onclick="if(confirm('are you sure??')){return true;}else{return false;}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                                {{--<td style="text-align: center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">Action</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{!! route('editRole.edit',$value->id) !!}"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>
                                            <li><a href="{!!route('deleteRole.delete',$value->id )!!}" >onclick="if(confirm('are you sure??')){return true;}else{return false;}"<span class="glyphicon glyphicon-trash"></span>Delete</a></li>

                                        </ul>
                                    </div>

                                </td>--}}
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
