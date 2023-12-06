<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponRanges extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'weapon_ranges';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
