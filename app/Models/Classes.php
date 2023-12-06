<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dice;
use App\Models\WeaponRanges;

class Classes extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = 'classes';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function wp_range() {
        return $this->hasOne(Dice::class, 'id', 'wp_dice');
    }
    
    public function wp_dice() {
        return $this->hasOne(Dice::class, 'id', 'wp_dice');
    }
}
