<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Gravatar 头像和侧边栏
     * 默认大小为100像素
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    //  事件监听
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user){
            $user->activation_token = str_random(30);
        });
    }

    //  博文表 一对多，一个用户可以拥有多个博文
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    //  根据用户id，取出该用户所有博文并以降序排列
    public function feed()
    {
        //  通过  followings  方法取出所有关注用户的信息，再借助  pluck  方法将  id  进行分离并赋值给  user_ids  ；
        $user_ids = $this->followings->pluck('id')->toArray();

        //  将当前用户的  id  加入到  user_ids  数组中;
        array_push($user_ids, $this->id);

        //  
        return Status::whereIn('user_id', $user_ids)
                                ->with('user')
                                ->orderBy('created_at', 'desc');
    }

    //  粉丝关系列表
    public function followers()
    {
        return $this->belongsToMany($this, 'followers', 'user_id', 'follower_id');
    }

    //  用户关注人列表
    public function followings()
    {
        return $this->belongsToMany($this, 'followers', 'follower_id', 'user_id');
    }

    /**
     * sync() 
     * 会接收两个参数，第一个参数为要进行添加的id
     * 第二个参数则指明是否要移除其它不包含在关联的  id  数组中的  id 
     */
    public function follow($user_ids)
    {
        if ( !is_array($user_ids) ) $user_ids = compact('user_ids');
        
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 
     */
    public function unfollow($user_ids)
    {
        if ( !is_array($user_ids) ) $user_ids = compact('user_ids');
        
        $this->followings()->detach($user_ids);
    }

    /**
     * 判断用户 B 是否包含在用户 A 的关注人列表上
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
