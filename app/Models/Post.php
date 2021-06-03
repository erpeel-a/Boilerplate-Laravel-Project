<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'post';

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'author',
        'thumbnail',
        'content',
        'status',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
