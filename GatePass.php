<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    use HasFactory;

    protected $fillable = [
        'rollnos', 
        'names', 
        'department', 
        'reason', 
        'timing',
        'status',  // Add status to mass-assignable attributes
        'info',    // Add info to mass-assignable attributes
    ];
}
