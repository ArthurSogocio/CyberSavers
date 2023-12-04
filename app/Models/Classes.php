<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = 'classes';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
