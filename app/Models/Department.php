<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $primaryKey = 'department_id';

    public $timestamps = false;

    protected $fillable = ['department_name','department_added_on','department_added_by','department_updated_on','department_updated_by','department_status'];
}