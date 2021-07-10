<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Services\ArticleService;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    protected $articleSvc;

    public function __construct(ArticleService $articleService)
    {
        $this->articleSvc = $articleService;
    }

    public function publicArticles()
    {
        $articles = $this->articleSvc->with('author')->paginate(20);
        return response()->json($articles);
    }

    public function publicArticle($id)
    {
        $articles = $this->articleSvc->with('author')->findOrFail($id);
        return response()->json($articles);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->articleSvc->where('auther_id', auth()->id)->paginate(20);
        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $data = $request->validated();
        $data['author_id'] = auth()->id;

        try {
            $article = $this->articleSvc->createArticle($data);
            $data = [
                'status' => true,
                'message' => 'Created successfully!',
                'article' => $article
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->load('author');
        return response()->json($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if(!$article->isAuthor()) abort(404);

        $data = [
            'categories' => Category::all(),
            'article' => $article
        ];
        return response($data)->json();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        if(!$article->isAuthor()) abort(404);
        $data = $request->validated();

        try {
            $article = $this->articleSvc->updateArticle($data, $article->id);
            $data = [
                'status' => true,
                'message' => 'Updated successfully!',
                'article' => $article
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if(!$article->isAuthor()) abort(404);

        try {
            if($article->delete()) {
                $data = [
                    'status' => true,
                    'message' => 'Deleted successfully!',
                ];
                return response()->json($data);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
