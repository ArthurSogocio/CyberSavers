<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dice extends Model {
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'catalogs';
    protected $primaryKey = 'catalog_id';
    protected $fillable = ['product_name', 'catalog_number', 'sequence', 'tag_id', 'species_id', 'product_type_id', 'catalog_creation_date'
        , 'host_id'];
    public $timestamps = false;

    public function inventory() {
        return $this->hasMany(Inventory::class, 'catalog_id');
    }
}
