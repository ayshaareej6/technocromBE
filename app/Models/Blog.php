<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Blog extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'blogs';

    protected $fillable = [
        'category_id', 'title', 'slug', 'desc', 'tags', 'data', 'image', 'created_by' , 'updated_by'
    ];

    public function setSlugAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function category() {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }
}
