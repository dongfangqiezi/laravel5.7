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

    //  管理用户更新操作
    /**
     * @param mixed $currentUser    当前登录用户实例
     * @param mixed $user           要进行授权的用户实例
     * @return   bool
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
