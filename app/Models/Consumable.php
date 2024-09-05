<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumable extends Model
{
    protected $table = 'consumables';

    protected $primaryKey = 'consumable_id';

    public $timestamps = false;

    protected $fillable = ['consumable_name','consumable_added_on','consumable_added_by','consumable_updated_on','consumable_updated_by','consumable_status'];

    public function items()
    {
        return $this->hasMany(Consumable::class, 'consumable_id', 'id');
    }

}