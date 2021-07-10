<?php
/**
 * Created by Muhaimenul Islam.
 * User: muhaimenul
 * Date: 7/10/21
 * Time: 12:30 AM
 */


namespace App\Http\Services;


use App\Models\Article;
use Muhaimenul\Laracrud\Services\CrudGenerator;

class ArticleService extends Service
{
    public function setModel()
    {
        $this->model = new Article();
    }

    public function createArticle(array $data)
    {
        //save image
        if(isset($data['banner']) && $data['banner']) {
            $data['banner'] = upload_file($data['avatar'], 'articles');
        }

        return $this->create($data);
    }

    public function updateArticle(array $data, int $id)
    {
        //save image
        if(isset($data['banner']) && $data['banner']) {
            $data['banner'] = upload_file($data['avatar'], 'articles');
        }

        return $this->update($data, $id);
    }

    public function getArticleBySlug($slug)
    {
        return $this->with('author')->where(['slug' => $slug])->firstOrFail();
    }
}
