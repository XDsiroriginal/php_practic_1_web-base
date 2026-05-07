<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;
    protected $table = 'repair';
    protected $primaryKey = 'repair_id';

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'equipment_id',
        'report_date',
        'break_message',
        'repair_start_date',
        'repair_end_date',
        'cost',
        'work_performed',
        'status',
        'created_at',
        'updated_at',
    ];
}