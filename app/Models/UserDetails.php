<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Aspects;

class UserDetails extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'user_details';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function aspect() {
        return $this->hasOne(Aspects::class, 'id', 'aspect_id');
    }
}
