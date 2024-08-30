<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CleaningLog extends Model
{
    protected $table = 'cleaning_logs';

    protected $primaryKey = 'cleaning_log_id';

    public $timestamps = false;

    protected $fillable = ['cleaning_log_vehicle','cleaning_log_date','cleaning_log_driver','cleaning_log_type','cleaning_log_location','cleaning_log_provider','cleaning_log_cost','cleaning_log_notes','cleaning_log_added_on','cleaning_log_added_by','cleaning_log_updated_on','cleaning_log_updated_by','cleaning_log_status'];
}