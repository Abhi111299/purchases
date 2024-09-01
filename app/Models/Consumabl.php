<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumabl extends Model
{
    protected $table = 'consumabls';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['supplier_name','supplier_address','phone','purchase_order_date','quotation_number','email','delivery_address','uploaded_file','subtotal','shipping','total_without_gst','gst', 'total', 'purchase_order_number'];
}