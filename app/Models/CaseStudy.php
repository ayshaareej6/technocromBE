<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class CaseStudy extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'case_study';

    protected $fillable = [
        'title', 'desc', 'challenges', 'solution', 'result', 'data', 'image', 'created_by' , 'updated_by'
    ];

    public function getImageAttribute($value)
    {
        if($value) {
            return asset('public/storage/uploads/case-study/'.$value);
        }
        
        return '';
    }
}
