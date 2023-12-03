<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccessLevels extends Model {
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'user_access_levels';
    protected $primaryKey = 'access_level';
    public $timestamps = false;
    
}
