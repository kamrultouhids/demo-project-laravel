@extends('admin.master')
@section('content')
@section('title','View District')

<script type="text/javascript">

    $('body').on('click', '.delete', function () {

        var actionTo=$(this).attr('href');
        var token=$(this).attr('data-token');
        var id=$(this).attr('data-id');
        swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: "No, cancel plz!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url:actionTo,
                            type: 'post',
                            data: {_method: 'delete',_token:token},
                            success: function (data) {
                                swal({
                                        title: "Deleted!",
                                        text: "Data has been Deleted.",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $('.'+id).fadeOut();
                                        }
                                });
                            }

                        });
                    } else {
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
        return false;
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
                        <li class="active">View District</li>
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
                        <a href="{{ URL::to('district/create') }}" class="btn btn-success pull-left">Add District</a>
                    </h4>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                    <table id="example" class="table table-bordered table-hover table-responsive">
                        <thead>
                        <tr style="background-color: #ddd">
                            <th>S/L</th>
                            <th>Division Name</th>
                            <th>District Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($result['districtInfo'] as $key=>$row)
                            <tr class="{{$row->id}}">
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $row->division_name }}</td>
                                <td>{{ $row->district_name }}</td>
                                <td style="width: 77px;">
                                    <a href="{{ URL::to('district/' . $row->id . '/edit') }}" title="Edit" class="btn btn-success btn-xs">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="{!! route('district.destroy',$row->id) !!}" class="delete btn btn-danger btn-xs deleteBtn" data-token="{!! csrf_token() !!}" data-id="{!! $row->id!!}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
