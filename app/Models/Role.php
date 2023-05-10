<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'see_home',
        'see_screenshots',
        'see_hack_logs',
        'see_connect_logs',
        'see_tools_download',
        'see_guides',
        'ban_hardware',
        'guest_id',
    ];

    public function User(){
        return $this->belongsTo('App\Models\User', 'id');
    }
}
