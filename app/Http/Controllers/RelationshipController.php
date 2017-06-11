<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\RelationshipRequest;
use App\Model\RelationshipModel;

class RelationshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allRelationship = RelationshipModel::selectRelationship();
        return view('admin.setup.relationship.index')->with('allRelationship',$allRelationship);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setup.relationship.addEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RelationshipRequest $request)
    {
        $input=$request->all();
        try{
            RelationshipModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('relationship')->with('relationship', 'Relationship Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('relationship')->with('error', 'Relationship is Found Duplicate');
        } else {
            return redirect('relationship')->with('error', 'Something Error Found !, Please try again.');
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
        $editRelationship = RelationshipModel::FindOrFail($id);
        return view('admin.setup.relationship.addEdit')->with('editRelationship',$editRelationship);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RelationshipRequest $request, $id)
    {
        $data = RelationshipModel::findOrFail($id);
        $input = $request->all();
        try {
            $data->update($input);
            $result = 0;
        } catch (\Exception $e) {
            $result = $e->errorInfo[1];
        }
        if ($result == 0) {
            return redirect()->back()->with('success', 'Relationship Updated Successfully');
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
        $relationshipDelete = RelationshipModel::find($id);
        $relationshipDelete->delete();
        return redirect('relationship')->with('success', 'Relationship Deleted Successfully');
    }
}
