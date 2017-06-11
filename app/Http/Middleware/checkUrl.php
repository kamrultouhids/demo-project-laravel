<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class checkUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$role_id = session('logged_session_data.role_id');
		
		$namedRoute=\Route::currentRouteName();
        $get_current_url="SELECT menu_url FROM `menu_info` where menu_url='$namedRoute'";
        $current_uel_check=DB::select($get_current_url);

        if ($current_uel_check)
        {
            if(!in_array($namedRoute, $current_uel_check))
            {
                $get_url_permission_chk="SELECT menu_url FROM `menu_info`  INNER JOIN `user_permission`  ON (`menu_info`.`menu_id` = `user_permission`.`menu_id`) WHERE `role_id`='$role_id' AND `menu_url`='$namedRoute'";
                $permission_chk=DB::select($get_url_permission_chk);

                if(empty($permission_chk))
                {
                    return response()->view('errors.404', [], 404);
                }
            }
        }
		
        return $next($request);
    }
}
