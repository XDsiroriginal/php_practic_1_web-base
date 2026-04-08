<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';
    public $timestamps = false;

    protected $primaryKey = 'department_id';

    protected $fillable = [

        'name',
        'code',
        'description',
    ];
}