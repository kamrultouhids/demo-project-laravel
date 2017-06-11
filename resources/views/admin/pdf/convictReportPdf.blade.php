<link rel="stylesheet" href="{!! asset('public/admin_assets/bootstrap/css/bootstrap.min.css') !!}">
<style>

    .table thead tr th{
        font-size: 11px;
        font-family: arial;
        font-weight: bold;
        background-color: #d3e0e9;
    }
    .table tbody tr td{
        font-size: 11px;
        font-family: arial;
        font-weight: bold;
        padding: 2px;
    }
</style>
<div id="wrapper" class="container">
    <div class="header">
        <img src="{!! asset('public/admin_assets/img/rab-top.jpg') !!}" class="img-circle" alt="Top Image" style="width: 700px">
        <h1 style="text-align: center;font-weight: bold;color: black;text-decoration: underline">Convict Report</h1>
    </div>
    <br>
    <div class="panel-body">
        <table id="example" class="table table-bordered table-hover table-responsive">
            <thead>
            <tr>
                <th>S/l</th>
                <th>Case No</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Father Name</th>
                <th>Mother Name</th>
                <th>Contact Number</th>
            </tr>
            </thead>
            <tbody id="reportTable">
            @foreach($resultData as $key=>$row)
                <tr>
                    <td>{{ (++$key) }}</td>
                    <td>{{ $row->reference_no }}</td>
                    <td>{{ $row->convict_name }}</td>
                    <td>{{ $row->convict_age }}</td>
                    <td>{{ $row->convict_gender }}</td>
                    <td>{{ $row->convict_father_name }}</td>
                    <td>{{ $row->convict_mother_name }}</td>
                    <td>{{ $row->convict_contact_number }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>