<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stats;

class AspectRanks extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'aspect_ranks';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
