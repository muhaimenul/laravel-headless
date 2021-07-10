<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id',  'id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id',  'id');
    }


    public function isCommenter()
    {
        return $this->user_id == auth()->id;
    }
}
