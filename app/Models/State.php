<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    protected $primaryKey = 'state_id';

    public $timestamps = false;

    protected $fillable = ['state_name','state_added_on','state_added_by','state_updated_on','state_updated_by','state_status'];
}