<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Route;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

	public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
	
	// 必须是管理员，并且不能删除自己的
	public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

	public function admin(User $currentUser)
    {
        return $currentUser->is_admin;
    }

    public function permission(User $currentUser) {
        return permission($currentUser, Route::currentRouteName());
    }
	
	public function seller(User $currentUser)
    {
        return $currentUser->type == 'seller';
    }
	
	public function buyer(User $currentUser)
    {
        return $currentUser->type == 'buyer';
    }
}