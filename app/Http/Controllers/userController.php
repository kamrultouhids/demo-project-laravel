<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\roleModel;

use App\Http\Requests\userControllerRequest;

use App\Model\user_info;

use Validator;

use Hash;

use DB;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=user_info::all();
		
		return view('admin.user.view_user',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=roleModel::all();
        return view('admin.user.add_user',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(userControllerRequest $request)
    {
        $img=$request->file('picture');
		$user=new user_info();
		$user->name=$request->name;
        $user->email=$request->email;
		$user->role_id=$request->role_id;
		$user->password=Hash::make($request->password);
		if($img){
            $imgName=md5(str_random(30).time().'_'.$request->file('picture')).'.'.$request->file('picture')->getClientOriginalExtension();
            $request->file('picture')->move('img/',$imgName);
            $user->pic_name=$imgName;
        }
		$user->save();

		return redirect('view-user')->with('success', 'Data insert successed.');
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
       $roledata=roleModel::all();
        $data=user_info::findOrFail($id);
        return view('admin.user.edit_user',['data'=>$data],['roledata'=>$roledata]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(userControllerRequest  $request, $id)
    {
      $img=$request->file('picture');
        $user=user_info::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->role_id=$request->role_id;
        if($img){
            $imgName=md5(str_random(30).time().'_'.$request->file('picture')).'.'.$request->file('picture')->getClientOriginalExtension();
            $request->file('picture')->move('img/',$imgName);
            if(file_exists('img/'.$user->pic_name) AND !empty($user->pic_name)){
                unlink('img/'.$user->pic_name);
            }
            $user->pic_name=$imgName;
        }
        $user->save();
        $request->session()->flash('success','Data Update successed.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $user=user_info::findOrFail($id);
      if (!is_null($user->pic_name)) {
            if(file_exists('img/'.$user->pic_name) AND !empty($user->pic_name)){
                unlink('img/'.$user->pic_name);
            }
      }
      $user->delete();
      return redirect()->back()->with('success','delete success !');
    }
}
