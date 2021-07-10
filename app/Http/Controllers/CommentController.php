<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    protected $commentSvc;

    public function __construct(CommentService $commentSvc)
    {
        $this->commentSvc = $commentSvc;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getArticleComments($slug)
    {
        return response()->json($this->commentSvc->getArticleComments($slug));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = $this->commentSvc->where('user_id', auth()->id)->paginate(20);
        return response()->json($comments);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id;

        try {
            $comment = $this->commentSvc->create($data);
            $data = [
                'status' => true,
                'message' => 'Created successfully!',
                'article' => $comment
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Comment $comment)
    {
        if(!$comment->isCommenter()) abort(404);
        $data = $request->validated();

        try {
            $comment = $this->commentSvc->update($data, $comment->id);
            $data = [
                'status' => true,
                'message' => 'Updated successfully!',
                'article' => $comment
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if(!$comment->isCommenter()) abort(404);

        try {
            if($comment->delete()) {
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
