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
        <h1 style="text-align: center;font-weight: bold;color: black;text-decoration: underline">Case Report</h1>
    </div>
    <br>
    <div class="panel-body">
        <table id="example" class="table table-bordered table-hover table-responsive">
            <thead>
            <tr>
                <th>S/l</th>
                <th>Reference No</th>
                <th>Litigant Name</th>
                <th>Battalion</th>
                <th>Crime Date</th>
                <th>Crime Type</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody id="reportTable">
            @foreach($resultData as $key=>$row)
            <tr>
                <td>{{ (++$key) }}</td>
                <td>{{ $row->reference_no }}</td>
                <td>{{ $row->employee_name }}</td>
                <td>{{ $row->battalion_name }}</td>
                <td>{{ $row->crime_time }}</td>
                <td>{{ $row->crime_type_name }}</td>
                <td><?=caseStatus()[$row->status]; ?></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>