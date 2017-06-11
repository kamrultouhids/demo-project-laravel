<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InvestigationDetalisRequest;
use App\Model\InvestigationModel;
use App\Model\commonModel;
use DB;

class InvestigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    	//return $rabEmployeeSelect;
        $selectInvestigation = DB::table('investigation_details')
            ->join('case', 'investigation_details.case_number', '=', 'case.id')
            ->select('investigation_details.*', 'case.reference_no')
            ->orWhereNull('investigation_details.deleted_at')
            ->get();
       // $selectInvestigation=InvestigationModel::selectInvestigation();
    
        return view('admin.case.investigation.index',compact('selectInvestigation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       	$rabEmployeeSelect= DB::table('rab_employee')->select('*')->get();
        $selectRabEmployeeList=commonModel::selectRabEmployeeList();
       	//return $rabEmployeeSelect;
            $selectCaseList=commonModel::CaseList();
        return view('admin.case.investigation.form', compact('rabEmployeeSelect','selectCaseList','selectRabEmployeeList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvestigationDetalisRequest $request)
    {
       //$data=$request->all();
       if(!isset($_POST['attended_person'])){
            return redirect()->back()->with('error', 'Attended Person Information should not be empty.');
        }
        $input=$request->all();
        $investigationCopy=$request->file('investigation_attach');

        if($investigationCopy){
        $imgName=md5(str_random(10).time().'_'.$request->file('investigation_attach')).'.'.$request->file('investigation_attach')->getClientOriginalExtension();
        $fileName = $request->file('investigation_attach')->move('public/uploads/investigationFile/',$imgName);
        $input['investigation_attach'] = $imgName;
        }
       $convertData= dateConvertFormtoDB($request->investigation_date);
       $attended_person=$request->attended_person;
     // return $attended_person;

        try{
           $status= InvestigationModel::create(array_merge($input, ['investigation_date' => $convertData]));
           $investigation_id=$status->id;
        // return $request->investigation_attach;
       //return $investigation_id;
             for($i=0;$i<sizeof($attended_person);$i++)
             {
				
				$data['fk_investigation_id']=$investigation_id;
				$data['attended_person']=$attended_person[$i];
                //return $data;
				DB::table('investigation_attended_person')->insert($data);
             }
                $bug = 0;

            //return $bug;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('investigation')->with('success', 'Investigation Details Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('investigation')->with('error', 'Investigation Details is Found Duplicate');
        } else {
            return redirect('investigation')->with('error', 'Something Error Found !, Please try again.');
        }
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

             $selectRabEmployeeList=commonModel::selectRabEmployeeList();

    		$rabEmployeeSelect= DB::table('rab_employee')->select('*')->get();
			$editInvestigationSelect = InvestigationModel::findOrFail($id);
              $selectCaseList=commonModel::CaseList();
    		$editInvestigation=  DB::table('investigation_details')
           		  				->join('investigation_attended_person', 'investigation_details.id', '=', 'investigation_attended_person.fk_investigation_id')
           		  				->join('rab_employee', 'investigation_attended_person.attended_person', '=', 'rab_employee.id')
              					->where('investigation_details.id', '=', $id)
            					->select('investigation_attended_person.id as attenedPersonId','investigation_attended_person.attended_person','rab_employee.employee_name')
            					->get();
           // return $editInvestigation;
         return view('admin.case.investigation.form',compact('editInvestigation','editInvestigationSelect','rabEmployeeSelect','selectCaseList','selectRabEmployeeList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    if(!isset($_POST['attended_person'])){
            return redirect()->back()->with('error', 'Attended Person Information should not be empty.');
        }

        $input=$request->all();
        $updateData = InvestigationModel::findOrFail($id);
        $attended_person=$request->attended_person;
        $attended_person_update=$request->attended_person_update;
        $attenedId=$request->attenedId;
        $investigationCopy=$request->file('investigation_attach');

        if($investigationCopy){
        $imgName=md5(str_random(10).time().'_'.$request->file('investigation_attach')).'.'.$request->file('investigation_attach')->getClientOriginalExtension();
        $fileName = $request->file('investigation_attach')->move('public/uploads/investigationFile/',$imgName);
        $input['investigation_attach'] = $imgName;
        }
       // return $attenedId;
      // 	$input=$request->all();


        try{

                    $convertData= dateConvertFormtoDB($request->investigation_date);
          
	     			$updateData->update(array_merge($input, ['investigation_date' => $convertData]));
	    // return $data;
	           	      

	           for($j=0;$j<sizeof($attenedId);$j++)
	           {

						$attendedPersonId=$attenedId[$j];
						DB::table('investigation_attended_person')->where('id', '=', $attendedPersonId)->delete();

	           }
                        $investigation_id=$id;
                         for($i=0;$i<sizeof($attended_person);$i++)
                         {
                            $data['fk_investigation_id']=$investigation_id;
                            $data['attended_person']=$attended_person[$i];
                            DB::table('investigation_attended_person')->insert($data);
                         }  
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect("investigation/$id/edit")->with('success', 'Investigation Details Update Successfully');
        }elseif ($bug == 1062) {
            return redirect("investigation/$id/edit")->with('error', 'Investigation Details is Found Duplicate');
        } else {
            return redirect("investigation/$id/edit")->with('error', 'Something Error Found !, Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $investigationDelete = InvestigationModel::find($id);
        $investigationDelete->delete();
        return redirect()->back()->with('success', 'Investigation  Deleted Successfully');
    }
}
