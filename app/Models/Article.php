<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['banner_full_path'];


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id',  'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id',  'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id',  'id');
    }

    public function isAuthor()
    {
        return $this->author_id == auth()->id;
    }


    // accessors
    public function getBannerFullPathAttribute()
    {
        return get_file($this->banner);
    }

}
