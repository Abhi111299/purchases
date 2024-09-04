<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumabl extends Model
{
    protected $table = 'consumabls';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['supplier_name','supplier_address','phone','purchase_order_date','quotation_number','email', 'consumable_added_by', 'delivery_date', 'delivery_address','uploaded_file','subtotal','shipping','total_without_gst','gst', 'total', 'purchase_order_number'];

    public function items()
    {
        return $this->hasMany(ConsumableItem::class, 'consumable_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_name');
    }

}