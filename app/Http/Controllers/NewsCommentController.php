<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\NewsComment;

class NewsCommentController extends Controller
{
    //
    public function index()
    {
        $comments = NewsComment::all()->sortBy('create_at');
        return view('comments.index', ['comments' => $comments]);
    }
    public function reply(Request $req)
    {
        if(!isset($req->parentId)) return back()->withInput();
        if(!isset($req->newsId)) return back()->withInput();

        $toComment = NewsComment::find($req->parentId);
        return view('comments.reply', ['parentId' => $req->parentId,
                                       'newsId' => $req->newsId,
                                       'toComment' => $toComment]);
    }
    public function create()
    {
        return view('comments.create', []);
    }
    public function store(Request $req)
    {
        $user = Auth::user();
        $comment = NewsComment::create([
            'user_id' => $user->id,
            'news_id' => $req->newsId,
            'parent_news_comments_id' => isset($req->parentId)? $req->parentId : null,
            'contents' => $req->commentText,
        ]);
        return redirect('/news?id=' . htmlentities($req->newsId, ENT_QUOTES, 'UTF-8', false));
    }
}
