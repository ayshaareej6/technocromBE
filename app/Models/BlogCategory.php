<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class BlogCategory extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'blog_categories';

    protected $fillable = [
        'name', 'desc', 'created_by' , 'updated_by'
    ];
}
