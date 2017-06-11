<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use App\model\roleModel;

use App\model\userPermissionModel;

use Validator;

class roleController extends Controller
{
    public function create(){
        return view('admin.user.add_role');
    }

    public function store(Request $input){
        $validator=validator::make($input->all(),[
            'name'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $addRole=new roleModel();
        $addRole->role_name=$input->name;
        $addRole->save();
        return redirect('viewRole')->with('success', 'New Role Created. .');
    }
    public function index()
    {
        $data=roleModel::all();
        return view('admin.user.view_role',['data'=>$data]);
    }

    public function edit($id)
    {
        $value=roleModel::findOrFail($id);
        return view("admin.user.edit_role",['value'=>$value]);
    }

    public function update(Request $input, $id)
    {
        $validator=validator::make($input->all(),[
            'name'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $created_by = session('logged_session_data.role_id');

        $addRole=roleModel::findOrFail($id);
        $addRole->role_name=$input->name;
        $addRole->save();
        $input->session()->flash('success','Role Updated.');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $role=roleModel::findOrFail($id);
        $role->delete();
        return redirect()->back()->with('success','Role delete success !');
    }

    /**
     *
     * @permission relation
     *
     */

    public function permissionCreate()
    {
		$data=roleModel::all();
        return view('admin.user.add_user_permission',['data'=>$data]);
    }

	public function get_all_menu_url(Request $request)
    {
		
        $role=$request->role;
		
       $permissions=DB::table('menu_info')
        ->join('user_permission', 'menu_info.menu_id', '=', 'user_permission.menu_id')
        ->where('user_permission.role_id', '=', $role)
        ->get();

        $parentQuery=" SELECT * FROM `menu_info` WHERE `parent` !=0 ";
        $all_sub_menus=DB::select($parentQuery);


         $all_menu=DB::table('menu_info')
             ->where('parent', '=', 0)
			 ->orderBy('ModuleID')
			 ->orderBy('menu_id')
             ->get();
         if($all_menu)
        {
    
             ?>

                <label class="col-sm-3 control-label" style="padding: 17px;">Pages permission </label>

                    <div id="area_select" class="col-sm-9">
                        <?php
						$moduleId = NULL;
                        foreach ($all_menu as $all_menu) {
							    if($moduleId  != $all_menu->ModuleID){
									$moduleId = $all_menu->ModuleID;
										$get_module_name=DB::table('module_info')->where('ModuleID', '=', $moduleId)->limit(1)->get();
									if($moduleId != 1){ echo '</div></div>'; }
									echo '<div class="panel panel-default" style="margin-bottom:15px; padding:20px">
										<span style="font-weight:bold; border-bottom:1px solid #000;">'.$get_module_name[0]->ModuleName.'</span>
										 <div class="panel-body">';								
								}
							
							
							if($moduleId  != $all_menu->ModuleID){
								$moduleId = $all_menu->ModuleID;
								$get_module_name=DB::table('module_info')->where('ModuleID', '=', $moduleId)->get();
							echo $get_module_name[0]->ModuleName;
								
								if($moduleId != 1){
									echo '</div></div>';
								}
								echo '<div class="panel panel-default" style="margin-bottom:15px; padding:20px">
									<span style="font-weight:bold;">'.$get_module_name[0]->ModuleName.'</span>
									 <div class="panel-body">';								
							}
                            $check='aa';
                            
                            foreach ($permissions as $permission) {
                                
                                
                                if($all_menu->menu_id == $permission->menu_id){
                                    $check= ' checked="checked"';
									break;  
                                }
                            }
                            
                        ?>
                   
                      <div class="checkbox">
                        <label>
                            <input type="checkbox" <?php echo $check;?> name="menu_id[]" value="<?php echo $all_menu->menu_id; ?>" ><?php echo $all_menu->menu_name;?>
                        </label>
                       </div>
                            <?php
                            foreach ($all_sub_menus as $sub) {

                                $checked = '';
                                if ($all_menu->menu_id == $sub->parent) {

                                    foreach ($permissions as $permission) {

                                        if ($sub->menu_id == $permission->menu_id) {

                                            $checked = 'checked="checked"';

                                            break;
                                        }
                                    }
                                    ?>
                                    <label style="margin-left: 24px;">
                                        <input type="checkbox" <?php echo $checked; ?> name="menu_id[]" value="<?php echo $sub->menu_id; ?>" > <?php echo $sub->menu_name; ?>
                                    </label>&nbsp;

                                    <?php
                                }

                            }
                        }
                         ?>
                    </div>
                 <?php
        }
      
    }
	
	 public function role_permission_relation(Request $input){

        $validator=validator::make($input->all(),[
            'RoleName'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		
		
        $role_id=  $input->RoleName;
		
        $delete_role = DB::table('user_permission')->where('role_id', '=', $role_id)->delete();

        $menu=count($input->menu_id);
        for ($i = 0; $i < $menu; $i++) {
           $insertRolePermission = array(
                "menu_id"  =>  $input->menu_id[$i],
                "role_id"  =>  $role_id,
            );
            $save = userPermissionModel::create($insertRolePermission);
        }
      
        $input->session()->flash('success','Permission has been updated.');
        return redirect()->back();
        
       
    }
}
