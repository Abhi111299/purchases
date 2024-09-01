<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Supplier extends Model
{
    protected $table = 'supplier';

    protected $primaryKey = 'id';

    public $timestamps = false; 

    protected $fillable = ['supplier_name','address', 'state', 'post_code','county','email','phone', 'created_at','updated_at'];

}
