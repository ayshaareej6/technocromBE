<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JobApplication extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'job_applications';

    protected $fillable = [
        'job_id', 'user_id', 'cv', 'data', 'job_status', 'created_by' , 'updated_by'
    ];

    public function applicant() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function job() {
        return $this->belongsTo(JobBoard::class, 'job_id', 'id');
    }

    public function getCvAttribute($value) {
        return asset('public/storage/uploads/'.$value);
    }
}
