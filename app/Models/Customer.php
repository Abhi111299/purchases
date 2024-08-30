<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $primaryKey = 'customer_id';

    public $timestamps = false;

    protected $fillable = ['customer_name','customer_address','customer_person','customer_email','customer_phone','customer_comments','customer_added_on','customer_added_by','customer_updated_on','customer_updated_by','customer_status'];
}