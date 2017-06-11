<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Hash;
use App\Http\Requests\loginrequest;

class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){

			
            return redirect()->intended(url('/admin_home'));
       }


            return view('admin.login');

    }

	public function Auth(loginrequest $request)
	{
        if(Auth::attempt(['email'=>$request->userEmail,'password'=>$request->userPassword]))
        {
            $userStatus=Auth::user()->status;
            if($userStatus=='1')
            {
                $user_data = [
                    "id" =>Auth::user()->id,
                    "email" =>Auth::user()->email,
                    "role_id" =>Auth::user()->role_id,
                ];
				
                session()->put('logged_session_data', $user_data);
                return redirect()->intended(url('/admin_home'));
            }
            else
            {
                return redirect(url('admin'))->withInput()->with('Erorr_message','You are blocked. please contact to admin');
            }


        }
        else
        {
            return redirect(url('admin'))->withInput()->with('Erorr_message','Email or password does not matched');
        }


		
		
	}

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect(url('admin'))->with('success_message','logout succseefull..!');
    }

}
