<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'trainings';

    protected $primaryKey = 'training_id';

    public $timestamps = false;

    protected $fillable = ['training_name','training_added_on','training_added_by','training_updated_on','training_updated_by','training_status'];
}