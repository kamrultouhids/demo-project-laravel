<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\DivisionRequest;
use App\Model\DivisionModel;
use LRedis;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $allDivision = DivisionModel::selectDivision();
        return view('admin.setup.division.index', compact('allDivision'));


    }
    public function sendmessage(Request $request){

        $redis = LRedis::connection();
        $data = ['message' => $_POST['message']];
        $redis->publish('message', json_encode($data));

        return response()->json([]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setup.division.addEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DivisionRequest $request)
       {
        $input=$request->all();
        try{
            DivisionModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('division')->with('success', 'Division Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('division')->with('error', 'Division is Found Duplicate');
        } else {
            return redirect('division')->with('error', 'Something Error Found !, Please try again.');
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
        $editDivision = DivisionModel::findOrFail($id);
        return view('admin.setup.division.addEdit', compact('editDivision'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DivisionRequest $request, $id)
    {
        $data = DivisionModel::findOrFail($id);
        $input = $request->all();
        try {
            $data->update($input);
            $result = 0;
        } catch (\Exception $e) {
            $result = $e->errorInfo[1];
        }
        if ($result == 0) {
            return redirect()->back()->with('success', 'Division Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Error Found ! ');
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
        $divisionDelete = DivisionModel::find($id);
        $divisionDelete->delete();
        return redirect()->back()->with('success', 'Division Deleted Successfully');
    }
}
