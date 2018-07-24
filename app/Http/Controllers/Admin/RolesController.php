<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AdminRole;

use Validator;

class RolesController extends BaseController
{
	public function index(Request $request) {
		return view('admin.roles.index',['roles' => AdminRole::all()]) ;
	}

	public function create(Request $request) {
		$permissions = config('admin.permissions.permissions');
		return view('admin.roles.create_and_edit', ['permissions' => $permissions]);
	}

	protected function getPermissions() {
		$permissoins = isset($_POST['permissions']) ? $_POST['permissions'] : [];
		$_permissions = [];
		foreach($permissoins as $permissoin) {
			if (strpos($permissoin, '|')) {
				$hasMany = explode('|', $permissoin);
				foreach($hasMany as $_permission) {
					array_push($_permissions, $_permission);
				}
			}else {
				array_push($_permissions, $permissoin);
			}
		}
		return $_permissions;
	}

	public function store(Request $request) {
		if (empty($request->name)) {
			$this->error('请输入角色名称');
		}

		AdminRole::create(['name' => $request->name, 'permissions' => json_encode($this->getPermissions())]);
		$this->success('角色添加成功', route('admin.roles.index'));
	}

	public function edit(AdminRole $role) {
		$permissions = config('admin.permissions.permissions');
		return view('admin.roles.create_and_edit', ['role'=> $role, 'permissions' => $permissions]);
	}

	public function update(Request $request, AdminRole $role) {
		$role->update(['name'=>$request->name, 'permissions'=>json_encode($this->getPermissions())]);
		$this->success('角色保存成功', route('admin.roles.index'));
	}

	public function destroy(AdminRole $role) {
		$role->delete() && $this->success('角色删除成功');
	}
}
