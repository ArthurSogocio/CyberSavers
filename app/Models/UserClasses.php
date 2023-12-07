<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Classes;

class UserClasses extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'user_classes';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'main_class', 'class_id', 'rank'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function class() {
        return $this->hasOne(Classes::class, 'id', 'class_id');
    }
}
