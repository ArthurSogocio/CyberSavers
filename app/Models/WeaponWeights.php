<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponWeights extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'weapon_weights';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
