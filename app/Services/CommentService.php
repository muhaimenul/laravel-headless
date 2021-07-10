<?php
/**
 * Created by Muhaimenul Islam.
 * User: muhaimenul
 * Date: 7/10/21
 * Time: 12:30 AM
 */


namespace App\Services;


use App\Models\Article;
use App\Models\Comment;
use Muhaimenul\Laracrud\Services\CrudGenerator;

class CommentService extends Service
{
    public function setModel()
    {
        $this->model = new Comment();
    }

    public function getArticleComments($article_slug, $per_page = 10)
    {
        $articleSvc = app()->make(ArticleService::class);

        return $this->with('user')->where('article_id', $articleSvc->getArticleBySlug($article_slug)->id)->paginate($per_page);
    }


}
