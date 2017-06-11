<link rel="stylesheet" href="{!! asset('public/admin_assets/bootstrap/css/bootstrap.min.css') !!}">
<style>
    .text-design{
        font-family: arial;
        font-size: 12px;
    }
    .top-header{
        font-size: 18px;
        font-family: arial;
    }
    .labels{
        font-weight: bold;
        font-family: arial;
        font-size: 14px;
        line-height: 20px !important;
    }
    .top-header{ font-size: 20px !important; }

    .borderless td, .borderless th {
        border-top: none !important;
        border-left: none !important;
    }

</style>
<div id="wrapper" class="container">
    <div class="header">
        <img src="{!! asset('public/admin_assets/img/rab-top.jpg') !!}" class="img-circle" alt="Top Image" style="width: 700px">
        <h1 style="text-align: center;font-weight: bold;color: black;text-decoration: underline">RAB Litigant</h1>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="top-header">Litigant Information</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <table class="table borderless" cellpadding="0" cellspacing="0">
                                    <tr class="heading_tr">
                                        <td class="labels">Reference No</td>
                                        <td class="labels">Previous Case No</td>
                                        <td class="labels">Litigant Name</td>
                                    </tr>
                                    <tr>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->reference_no: '' }}</td>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->previous_case_no: '' }}</td>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->employee_name: '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="labels">Designation</td>
                                        <td class="labels">Battalion</td>
                                    </tr>
                                    <tr>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->designation_name: '' }}</td>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->battalion_name: '' }}</td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>


                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="top-header">Convict Information</span>
                        </div>

                            @if(isset($editModeData))
                            <div id="Convict_details_rows">

                                @foreach($ConvictEditModeData as $key=>$value)
                                    <div class="panel-body row_element">
                                        <h4 style="text-decoration: underline">Convict No : {{ ++$key }}</h4>
                                        <div class="row">
                                            <table class="table borderless">
                                                <tr>
                                                    <td class="labels">Convict Name</td>
                                                    <td class="labels">Age</td>
                                                    <td class="labels">Gender</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_name: '' }}</td>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_age: '' }}</td>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_gender: '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="labels">Father Name</td>
                                                    <td class="labels">Mother Name</td>
                                                    <td class="labels">Contact Number</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_father_name: '' }}</td>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_mother_name: '' }}</td>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_contact_number: '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="labels">Permanent Address</td>
                                                    <td class="labels">Present  Address</td>
                                                    <td class="labels">Have Any Case Past ?</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_permanent_address: '' }}</td>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_present_address: '' }}</td>
                                                    <td class="text-design">@if($value->convict_pastcase == 0){{ "No" }} @else {{ "Yes" }} @endif</td>
                                                </tr>
                                                @if($value->convict_pastcase == 1)
                                                <tr>
                                                    <td class="labels">Details Information</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-design">{{ (isset($value)) ? $value->convict_details: '' }}</td>
                                                </tr>
                                                    @endif
                                            </table>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="top-header">Victims Information</span>
                        </div>
                        @if(isset($editModeData))
                            <div id="victims_details_rows">
                                @foreach($victimsEditModeData as $key=>$victimsValue)

                                    <div class="panel-body victims_row_element">
                                        <h4 style="text-decoration: underline">Victim No : {{ ++$key }}</h4>
                                        <div class="row">
                                            <table class="table borderless">
                                                <tr>
                                                    <td class="labels">Name</td>
                                                    <td class="labels">Age</td>
                                                    <td class="labels">Gender</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_name: '' }}</td>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_age: '' }}</td>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_gender: '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="labels">Father Name</td>
                                                    <td class="labels">Mother Name</td>
                                                    <td class="labels">Contact Number</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_father_name: '' }}</td>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_mother_name: '' }}</td>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_contact_number: '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="labels">Permanent Address</td>
                                                    <td class="labels">Present  Address</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_permanent_address: '' }}</td>
                                                    <td class="text-design">{{ (isset($victimsValue)) ? $victimsValue->victim_present_address: '' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>  
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="top-header">Crime Information</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <table class="table borderless">
                                    <tr>
                                        <td class="labels">Crime Type</td>
                                        <td class="labels">Crime Place</td>
                                        <td class="labels">Crime Time</td>
                                    </tr>
                                    <tr >
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->crime_type_name : "" }}</td>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->crime_place : "" }}</td>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->crime_time : "" }}</td>
                                    </tr>
                                    <tr>
                                        <td class="labels">Crime Description</td>
                                    </tr>
                                    <tr>
                                        <td class="text-design">{{ (isset($editModeData)) ? $editModeData->crime_description : "" }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <span class="top-header">Law Section</span>
                        </div>
                        @if(isset($editModeData))
                            <div id="law_section_details_rows">
                                @foreach($lawEditModeData as $lawValue)
                                    <div class="panel-body law_section_row_element">
                                        <table class="table borderless">
                                            <tr>
                                                <td class="labels">law Type</td>

                                            </tr>
                                            <tr>
                                                <td class="text-design">{{ (isset($lawValue)) ? $lawValue->section_name : "" }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
            </div>
        </div>
    </div>

</div>