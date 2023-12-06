<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Stats;

class UserStats extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'user_stats';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'stat', 'value'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function stat() {
        return $this->hasOne(Stats::class, 'id', 'stat');
    }
}
