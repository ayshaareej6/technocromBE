<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JobBoard extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'job_boards';

    protected $fillable = [
        'job_code', 'title', 'desc', 'type', 'shift', 'mode', 'last_date', 'location', 'data', 'created_by' , 'updated_by'
    ];
}
