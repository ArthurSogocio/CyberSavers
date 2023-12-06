<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Aspects;
use App\Models\AspectRanks;
use App\Models\Dice;
use App\Models\WeaponRanges;
use App\Models\WeaponWeights;

class UserDetails extends Model {

    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'user_details';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'level', 'aspect_id', 'aspect_rank', 'wp_range', 'wp_weight', 'secondary_toggle', 'swp_weight', 'muscle', 'head', 'heart', 'soul'];

    public function aspect() {
        return $this->hasOne(Aspects::class, 'id', 'aspect_id');
    }

    public function aspect_rank() {
        return $this->hasOne(AspectRanks::class, 'id', 'aspect_rank');
    }

    public function wp_dice() {
        return $this->hasOne(Dice::class, 'id', 'wp_dice');
    }

    public function wp_range() {
        return $this->hasOne(WeaponRanges::class, 'id', 'wp_range');
    }

    public function wp_weight() {
        return $this->hasOne(WeaponWeights::class, 'id', 'wp_weight');
    }

    public function swp_weight() {
        return $this->hasOne(WeaponWeights::class, 'id', 'swp_weight');
    }
}
