<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password1',
        'approve',
        'ip',
        'enddate',
        'version',
        'avatar',
        'last_login',
        'parent_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function LastLogin() {
        if(json_decode($this->last_login) == null) return null;
        $lastLogin = json_decode($this->last_login)->last_login;
        return $lastLogin;
    }

    public function Role() {
//        return $this->hasOne('App\Models\Role');
        return Role::where('guest_id', $this->id)->first();
    }

    public function GetRoleString() {
        $res = [];
        $role = $this->Role();
        if($role==null) return $res;
        if($role->see_home) array_push($res, 'Home');
        if($role->see_screenshots) array_push($res, 'Screenshots');
        if($role->see_hack_logs) array_push($res, 'HackLogs');
        if($role->see_connect_logs) array_push($res, 'ConnectLogs');
        if($role->see_tools_download) array_push($res, 'ToolsDownload');
        if($role->see_guides) array_push($res, 'Guides');
        if($role->ban_hardware) array_push($res, 'Hardware');

        return $res;
    }
}
