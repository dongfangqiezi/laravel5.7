<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

   
    /**
     * 管理用户更新操作
     * @param mixed $currentUser    当前登录用户实例
     * @param mixed $user           要进行授权的用户实例
     * @return   bool
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * 用户删除操作
     */
    public function destroy(User $currentUser, User $user)
    {
        //  只有当前用户拥有管理权限且删除的用户不是自己时才显示链接
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
