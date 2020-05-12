<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
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

    //  删除博文，当用户id与博文id相等时 返回true
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
