<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsComment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    //
    public function index()
    {
        $newsList = News::all()->take(30);
        return view('news.index', ['newsList' => $newsList]);
    }
    public function search(Request $req)
    {
        $newsList = News::all()
                  ->take(30)
                  ->where('domain', $req['domain'])
                  ->sortBy('created_at');
        return view('news.index', ['newsList' => $newsList]);
    }
    public function show(Request $req)
    {
        $news = News::find($req['id']);
        $commentsTree = $this->commentsToContinuousRecur(NewsComment::whereNull('parent_news_comments_id')->get(),
                                                     null,
                                                     $news->id);
        return view('news.show', ['news' => $news, 'commentsTree' => $commentsTree]);
    }
    public function commentsToContinuousRecur($roots, $parent, $newsId)
    {
        if(empty($roots)) return [];
        $result = ['root' => NewsComment::find($parent)];
        $children = [];
        foreach($roots as $root){
            $nextChildren = NewsComment::where('news_id', $newsId)
                          ->where('parent_news_comments_id', $root->id)
                          ->get();
            $children = array_merge($children,
                                    array($this->commentsToContinuousRecur($nextChildren, $root->id, $newsId)));
        }
        $result['children'] = $children;
        return $result;
    }
    public function create()
    {
        return view('news.create', []);
    }
    public function store(Request $req)
    {
        $url = $req->url;
        $user = Auth::user();
        News::urlOnlyInGenerate($url, $user->id);
        return redirect('/newsList');
    }
}
