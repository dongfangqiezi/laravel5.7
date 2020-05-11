<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 博文动态
 */
class Status extends Model
{
    //  一对一，一条博文属于一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
