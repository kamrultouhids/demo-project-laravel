<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\commonModel;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Model\ComplainModel;
use App\Http\Requests\ComplainRequest;
class ComplainController extends Controller
{
    public function index()
    {
        $complainData=ComplainModel::selectComplain();
        return view('admin.case.complain.index',compact('complainData'));
    
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $battalionList= commonModel::selectBattalionList();
        return view('admin.case.complain.form',['battalionList'=>$battalionList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isset($_POST['defendantDetails']['defendant_name'])){
            return redirect()->back()->with('error', 'Defendant Information should not be empty.');
        }
        try{
            date_default_timezone_set("Asia/Dhaka");

            //return $request->all();
            $complainData['date'] = dateConvertFormtoDB($request->date);
            $complainData['battalion'] = $request->litigant_battalion;
            $complainData['created_at'] = date('Y-m-d H:i:s');
            $complainData['created_by'] =Auth::user()->id;
            $complainData['complainant_name'] = $request->complainant_name;
            $complainData['complainant_age'] = $request->complainant_age;
            $complainData['complainant_gender'] = $request->complainant_gender;
            $complainData['complainant_father_name'] = $request->complainant_father_name;
            $complainData['complainant_mother_name'] = $request->complainant_mother_name;
            $complainData['complainant_contact_number'] = $request->complainant_contact_number;
            $complainData['complainant_permanent_address'] = $request->complainant_permanent_address;
            $complainData['complainant_present_address'] = $request->complainant_present_address;
            $complainData['complainant_details'] = $request->complainant_details;





           //return $complainData;
            $result = DB::table('complain_info')->insertGetId($complainData);
            $insert_id =$result;


            $createPOI = ['reference_no'=>'Complain'.-date('Ymd').$insert_id];
            DB::table('complain_info')->where('id', $insert_id)->update($createPOI);

            $defendantDetails=$request->defendantDetails;

            for($i=0;$i<sizeof($defendantDetails['defendant_name']);$i++)
            {

                $data['complainant_info_id']=$insert_id;
                $data['defendant_name']=$defendantDetails['defendant_name'][$i];
                $data['defendant_age']=$defendantDetails['defendant_age'][$i];
                $data['defendant_gender']=$defendantDetails['defendant_gender'][$i];
                $data['defendant_father_name']=$defendantDetails['defendant_father_name'][$i];
                $data['defendant_mother_name']=$defendantDetails['defendant_mother_name'][$i];
                $data['defendant_contact_number']=$defendantDetails['defendant_contact_number'][$i];
                $data['defendant_permanent_address']=$defendantDetails['defendant_permanent_address'][$i];
                $data['defendant_present_address']=$defendantDetails['defendant_present_address'][$i];
                //return $data;
                DB::table('complainant_defendant_info')->insert($data);
            }
            $bug = 0;

            //return $bug;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('complain')->with('success', 'Complain Details Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('complain')->with('error', 'Complain Details is Found Duplicate');
        } else {
            return redirect('complain')->with('error', 'Something Error Found !, Please try again.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getDefendant=DB::table('complainant_defendant_info')
            ->where('complainant_info_id', '=', $id)
            ->get();
        $editComplain=DB::table('complain_info')
            ->join('complainant_defendant_info', 'complain_info.id', '=', 'complainant_defendant_info.complainant_info_id')
            ->where('complain_info.id', '=', $id)
            ->select('complain_info.*','complainant_defendant_info.complainant_info_id','complainant_defendant_info.defendant_name','complainant_defendant_info.defendant_age','complainant_defendant_info.defendant_gender','complainant_defendant_info.defendant_father_name','complainant_defendant_info.defendant_mother_name','complainant_defendant_info.defendant_contact_number','complainant_defendant_info.defendant_permanent_address','complainant_defendant_info.defendant_present_address')
            ->first();
       // dd($editComplain);
      //  exit;
    //return $editComplain;
        $battalionList= commonModel::selectBattalionList();
        return view('admin.case.complain.form',compact('battalionList','editComplain','getDefendant'));
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
        if(!isset($_POST['defendantDetails']['defendant_name'])){
            return redirect()->back()->with('error', 'Defendant Information should not be empty.');
        }
        try{
            date_default_timezone_set("Asia/Dhaka");

            //return $request->all();
            $complainData['date'] = dateConvertFormtoDB($request->date);
            $complainData['battalion'] = $request->litigant_battalion;
            $complainData['created_at'] = date('Y-m-d H:i:s');
            $complainData['created_by'] =Auth::user()->id;
            $complainData['complainant_name'] = $request->complainant_name;
            $complainData['complainant_age'] = $request->complainant_age;
            $complainData['complainant_gender'] = $request->complainant_gender;
            $complainData['complainant_father_name'] = $request->complainant_father_name;
            $complainData['complainant_mother_name'] = $request->complainant_mother_name;
            $complainData['complainant_contact_number'] = $request->complainant_contact_number;
            $complainData['complainant_permanent_address'] = $request->complainant_permanent_address;
            $complainData['complainant_present_address'] = $request->complainant_present_address;
            $complainData['complainant_details'] = $request->complainant_details;







       
            DB::table('complain_info')->where('id', $id)->update($complainData);

            $defendantDetails=$request->defendantDetails;
            $defendantId=$request->defendantId;
            for($j=0;$j<sizeof($defendantId);$j++)
            {
                $defendantPersonId=$defendantId[$j];
                DB::table('complainant_defendant_info')->where('id', '=', $defendantPersonId)->delete();
            }
            for($i=0;$i<sizeof($defendantDetails['defendant_name']);$i++)
            {

                $data['complainant_info_id']=$id;
                $data['defendant_name']=$defendantDetails['defendant_name'][$i];
                $data['defendant_age']=$defendantDetails['defendant_age'][$i];
                $data['defendant_gender']=$defendantDetails['defendant_gender'][$i];
                $data['defendant_father_name']=$defendantDetails['defendant_father_name'][$i];
                $data['defendant_mother_name']=$defendantDetails['defendant_mother_name'][$i];
                $data['defendant_contact_number']=$defendantDetails['defendant_contact_number'][$i];
                $data['defendant_permanent_address']=$defendantDetails['defendant_permanent_address'][$i];
                $data['defendant_present_address']=$defendantDetails['defendant_present_address'][$i];
                //return $data;
                DB::table('complainant_defendant_info')->insert($data);
            }
            $bug = 0;

            //return $bug;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect("complain/$id/edit")->with('success', 'Complain   Update Successfully');
        }elseif ($bug == 1062) {
            return redirect("complain/$id/edit")->with('error', 'Complain   Update is Found Duplicate');
        } else {
            return redirect("complain/$id/edit")->with('error', 'Something Error Found !, Please try again.');
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
        $complainDelete = ComplainModel::find($id);
        $complainDelete->delete();
        return redirect()->back()->with('success', 'Complain  Deleted Successfully');
    }
}
