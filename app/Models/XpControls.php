<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpControls extends Model {
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'xp_control';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
