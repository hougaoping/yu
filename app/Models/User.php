<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserLoginlog;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Traits\Models\Order;

class User extends Authenticatable
{
    use Notifiable, Order, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'password', 'register_time', 'register_ip', 'ip', 'type', 'admin_roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userEmail()
    {
        return $this->hasOne('App\Models\UserEmail');
    }

	public function userProfile() {
		return $this->hasOne('App\Models\UserProfile');
	}

	public function loginLogs()
    {
        return $this->hasMany('App\Models\UserLoginlog');
    }

	// 获得验证码
	public function verifys()
    {
        return $this->hasMany('App\Models\UserVerify');
    }

	// 用户的反馈
	public function feedbacks()
    {
        return $this->hasMany('App\Models\UserFeedback');
    }

	// 财务明细
	public function finances()
    {
        return $this->hasMany('App\Models\UserFinance');
    }
	
	// 金币明细
	public function coins()
    {
        return $this->hasMany('App\Models\UserCoin');
    }

    public function recordLastLoginLog() {
        $this->last_login_time = time();
        $this->last_login_ip   = request()->getClientIp();
        $this->save();
    }

    public function recordLoginLog($username, $result = true) {
        $this->loginLogs()->create(['user_id' => $this->id, 'username' => $username, 'login_time' => time(), 'result' => intval($result), 'ip' => request()->getClientIp(), 'is_admin' => $this->is_admin, 'url' => request()->getRequestUri()]);
    }

    // 获取当前登录的用户名称
    public function getUsername($asterisk = true) {
        if (session()->has('username')) {
            return $asterisk ? email_asterisk(session()->get('username')) : session()->get('username');
        }else {
            return $this->name;
        }
    }

    public function incrementLoginCount() {
        $this->increment('login_count', 1);
    }

    public function scopeWithOrder($query, $keywords = '')
    {
        $this->withOrder($query, $keywords);
    }

    public function scopeWithSearch($query, $keywords = '', $type = '') {

        !empty($keywords) && $query->where('email', 'like', '%' . $keywords . '%')->orWhere('mobile', 'like', '%' . $keywords . '%');

		if (!empty($type)) {
			switch($type) {
				case 'admin':
					$query->where('is_admin', '1');
				break;
				case 'member':
					$query->where('is_admin', '0');
				break;
                case 'seller':
                    $query->where('type', 'seller');
                break;
                case 'buyer':
                    $query->where('type', 'buyer');
                break;
			}
		}
    }

    protected $_admin_roles_cache = null;

    // 获得管理员权限
    public function permission($active) {
        $permissions = [];
        $ids = json_decode($this->admin_roles);
        if (is_array($ids) and !empty($ids)) {
            if (is_null($this->_admin_roles_cache)) {
                $this->_admin_roles_cache = AdminRole::whereIn('id', $ids)->get();
            } 
            
            foreach($this->_admin_roles_cache as $v) {
                $permission = is_array(json_decode($v['permissions'])) ? json_decode($v['permissions']) : [];
                $permissions = array_merge($permissions, $permission);
            }
        }

        $config = config('admin.permissions');
        foreach ($config['equal'] as $key => $actions) {
            if (in_array($active, $actions)) {
                $active = $key;
                break;
            }
        }

        $permissions = array_merge($config['public'], $permissions);
        if (!in_array($active, $permissions)) {
            return false;
        }
        return true;
    }

    public function getAdminRoles() {
        $all    = AdminRole::pluck('name', 'id');
        $roles  = (array) json_decode($this->admin_roles);
        $_roles = [];
        foreach($all as $key=>$value) {
            if (in_array($key , $roles)) {
                $_roles[] = $value;
            }
        }
        return $_roles;
    }
}
