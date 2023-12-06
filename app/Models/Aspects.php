<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stats;

class Aspects extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'aspects';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function boon() {
        return $this->hasOne(Stats::class, 'stat_boon', 'id');
    }
    
    public function bane() {
        return $this->hasOne(Stats::class, 'stat_bane', 'id');
    }
}
