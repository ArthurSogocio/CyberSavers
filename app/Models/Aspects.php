<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspects extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'aspects';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /*public function aspect() {
        return $this->hasOne(Aspects::class, 'aspect_id', 'id');
    }*/
}
