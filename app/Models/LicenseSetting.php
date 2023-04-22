<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseSetting extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'memory', 'launcher', 'crc32', 'system', 'instance'
    ];
}
