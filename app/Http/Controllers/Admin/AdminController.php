<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\User;
use App\Models\AdminRole;

class AdminController extends BaseController
{
	public function index(Request $request) {
		$admin = new User();
    	$list = $admin->where('is_admin', 1)->withOrder($this->_order())->paginate($this->_rows());
    	return view('admin.admin.index', compact('list')) ;
	}

	public function create(Request $request) {
		$permissions = config('admin.permissions.permissions');
		return view('admin.admin.create_and_edit', ['adminRoles' => AdminRole::all() , 'permissions' => $permissions]);
	}

	public function store(Request $request) {

		$validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6',
        ], [
            'email.unique'       => '电子邮箱已经存在',
            'email.required'     => '请输入电子邮箱',
            'password.required'  => '请输入登录密码',
        ]);
        
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
        }

        $user = User::create([
        	'name'          => $request->name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'register_time' => time(),
            'register_ip'   => $request->getClientIp(),
            'admin_roles'   => json_encode(isset($_POST['admin_roles']) ? $_POST['admin_roles'] : []),
        ]);

        $user->is_admin = 1;
        $user->save();

        
		$this->success('管理员添加成功', route('admin.admin.index'));
	}

	public function edit(User $admin) {
        $permissions = config('admin.permissions.permissions');
		return view('admin.admin.create_and_edit', ['admin' => $admin, 'adminRoles' => AdminRole::all() , 'hasRoles'=>json_decode($admin->admin_roles, true) ,'permissions' => $permissions]);
	}

	public function update(Request $request, User $admin) {
        if ($admin->where('email', $request->email)->where('id', '<>', $admin->id)->first()) {
            $this->error('电子邮箱已经存在');
        }

        if (!empty($request->password)) {
            if($request->password == $request->password_confirmation) {
                $admin->password = bcrypt($request->password);
            }else {
                $this->error('两次密码不一致');
            }
        }

        $admin->name = $request->name;
        $admin->admin_roles = json_encode(isset($_POST['admin_roles']) ? $_POST['admin_roles'] : []);
        $admin->save();
        $this->success('管理员保存成功', route('admin.admin.index'));
	}

	public function destroy(User $admin) {
        $admin->delete() && $this->success('管理员删除成功');
	}
}
