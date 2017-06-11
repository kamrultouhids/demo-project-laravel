<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', 'loginController@index');
Route::post('/login', 'loginController@Auth');

Route::group(['middleware' => ['auth']], function () {
	
    Route::get('admin_home', 'HomeController@admin_home');
    Route::get('logout', 'loginController@logout');
	 
	// user info 
    Route::get('Add-User',['as'=>'add_user.create','uses'=>'userController@create']);
    Route::post('Add-User',['as'=>'add_user.store','uses'=>'userController@store']);
    Route::get('view-user',['as'=>'view-user.index','uses'=>'userController@index']);
    Route::get('edit-user/{user}/edit',['as'=>'edit-user.edit','uses'=>'userController@edit']);
    Route::put('edit-user/{user}',['as'=>'edit-user.update','uses'=>'userController@update']);
    Route::get('delete-user/{user}/delete',['as'=>'delete-user.delete','uses'=>'userController@destroy']);
	
	// role 
    route::get('createRole',['as'=>'addRole.create','uses'=>'roleController@create']);
    route::post('saveRole',['as'=>'saveRole.store','uses'=>'roleController@store']);
    route::get('viewRole',['as'=>'addRole.index','uses'=>'roleController@index']);
    Route::get('viewRole/{role}/edit',['as'=>'editRole.edit','uses'=>'roleController@edit']);
    Route::put('updateRole/{role}',['as'=>'updateRole.update','uses'=>'roleController@update']);
    Route::get('deleteRole/{role}/delete',['as'=>'deleteRole.delete','uses'=>'roleController@destroy']);

   // role Permission
    route::get('userPermission',['as'=>'permission.permissionCreate','uses'=>'roleController@permissionCreate']);
    route::post('addRole',['as'=>'addRole.role_permission_relation','uses'=>'roleController@role_permission_relation']);
	Route::post('get_all_menu_url','roleController@get_all_menu_url');
	
	//division
    //Route::get('Division',['as'=>'division.create','uses'=>'DivisionController@create']);
    //Route::post('addDivision',['as'=>'saveDivision.store','uses'=>'DivisionController@store']);

    Route::resource('division','DivisionController',['parameters'=> ['division'=>'id']]);
    Route::Post('sendmessage', 'DivisionController@sendmessage');

    Route::resource('district','DistrictController',['parameters'=> ['district'=>'id']]);
    Route::resource('policeStation','PoliceStationController',['parameters'=> ['policeStation'=>'id']]);
    Route::resource('battalion','BattalionController',['parameters'=> ['battalion'=>'id']]);
    Route::resource('relationship','RelationshipController',['parameters'=> ['relationship'=>'id']]);
    Route::resource('lawSection','LawSectionController',['parameters'=> ['lawSection'=>'id']]);
    Route::resource('crimeType','CrimeTypeController',['parameters'=> ['crimeType'=>'id']]);
    Route::resource('designation','DesignationController',['parameters'=> ['designation'=>'id']]);
    Route::resource('rabEmployee','RabEmployeeController',['parameters'=> ['rabEmployee'=>'id']]);
    Route::resource('witness','WitnessController',['parameters'=> ['witness'=>'id']]);

    Route::Post('policeStation/getDistrict', 'ajaxController@getDistrict');
    Route::Post('battalion/getDivisionWiseDistrict', 'ajaxController@getDivisionWiseDistrict');
    Route::Post('battalion/getDistrictWisePoliceStation', 'ajaxController@getDistrictWisePoliceStation');
    Route::Post('battalion/getEmployeeWiseDesignation', 'ajaxController@getEmployeeWiseDesignation');




    Route::resource('case','CaseController');
    Route::get('case/getCaseConvict/{cid}','CaseController@CaseConvictList');
    Route::post('case/getEmployeeWiseDesignationAndBattalion','RabEmployeeController@employeeWiseDesignationAndBattalion');

    Route::resource('investigation','InvestigationController');
    Route::resource('convictarrestinfo','ConvictArrestInfoController');
    Route::resource('convictnotarrestinfo','ConvictNotArrestInfoController');
    Route::resource('chargesheet','ChargeSheetController');

    Route::resource('coartInfo','CoartController',['parameters'=> ['coart'=>'id']]);

    Route::resource('complain','ComplainController');
    // report
    route::get('CaseReport',['as'=>'CaseReport.index','uses'=>'CaseReportController@index']);
    route::get('CaseReportPdf',['as'=>'CaseReportPdf.casePdf','uses'=>'CaseReportController@casePdf']);
    Route::post('CaseReport/getCaseReport','CaseReportController@getCaseReport');
    route::get('ConvictReport',['as'=>'ConvictReport.index','uses'=>'ConvictReportController@index']);
    Route::post('ConvictReport/getConvictReport','ConvictReportController@getConvictReport');
    route::get('convictReportPdf',['as'=>'convictReportPdf','uses'=>'ConvictReportController@convictReportPdf']);

    Route::get('selectCase/{id}', 'HomeController@selectCase');
    Route::get('selectCoart/{coartYear}', 'HomeController@selectCoart');
    Route::get('selectInvestigation/{investigationYear}', 'HomeController@selectInvestigation');
    Route::get('selectChargesheet/{ChargesheetYear}', 'HomeController@selectChargesheet');
    Route::get('selectConvict/{convictYear}', 'HomeController@selectConvict');
    Route::get('caseChartDetails/{month}/{year}', 'HomeController@caseChartDetails');
});
