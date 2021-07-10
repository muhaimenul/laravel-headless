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
use App\Models\User;
use Muhaimenul\Laracrud\Services\CrudGenerator;

class UserService extends Service
{
    public function setModel()
    {
        $this->model = new User();
    }

    public function createUser(array $data)
    {
        $articleSvc = app()->make(ArticleService::class);

        return $this->with('user')->where('article_id', $articleSvc->getArticleBySlug($article_slug)->id)->paginate($per_page);
    }


}
