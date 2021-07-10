<?php
/**
 * Created by Muhaimenul Islam.
 * User: muhaimenul
 * Date: 7/10/21
 * Time: 12:30 AM
 */


namespace App\Http\Services;


use App\Models\Article;
use App\Models\Comment;
use Muhaimenul\Laracrud\Services\CrudGenerator;

class CommentService extends Service
{
    public function setModel()
    {
        $this->model = new Comment();
    }

    public function getArticleComments($article_id, $per_page = 10)
    {
        $this->with('user')->where('article_id', $article_id)->paginate($per_page);
    }
}
