<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'model',
        'manufacturer',
        'commission_date',
        'cost',
        'status_id',
        'user_id',
        'department_id',
        'created_at',
        'updated_at'
    ];
}