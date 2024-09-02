<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableItem extends Model
{
    protected $table = 'consumable_items';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['consumable_id', 'item', 'description', 'quantity', 'cost'];

    public function consumable()
    {
        return $this->belongsTo(Consumable::class, 'consumable_id', 'id');
    }
}
