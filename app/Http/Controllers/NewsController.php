<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsComment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    //
    public function index(Request $req)
    {
        $req->validate([
            'order' => 'string|min:0|max:30',
        ]);
        $order = 'pupular';
        if(isset($req['order'])){
            $order = $req['order'];
        }
        $newsList = DB::table('news');
        switch($order){
        case 'pupular':
            $newsList = $newsList
                      ->leftJoin('news_comments', 'news.id', '=', 'news_comments.news_id')
                      ->select('news.*', DB::raw('count(news.id) as cnt'))
                      ->groupBy('news.id')->orderBy('cnt', 'desc')
                      ->orderBy('cnt', 'desc');
            break;
        default:         // 該当しない場合は全て最新順
            $newsList = $newsList->orderBy('created_at', 'desc');
        }
        $newsList = $newsList->take(30)->get();
        return view('news.index', ['newsList' => $newsList]);
    }
    public function search(Request $req)
    {
        $req->validate([
            'domain' => 'min:3|max:100',
            'q' => 'min:1|max:100',
        ]);
        $newsList = News::whereNotNull('id');
        if(isset($req['domain'])){
            $newsList = $newsList->where('domain', $req['domain']);
        }
        if(isset($req['q'])){
            $newsList = $newsList->where('domain', 'like', '%' . $req['q'] . '%')
                      ->orWhere('title', 'like', '%' . $req['q'] . '%')
                      ->orWhere('description', 'like', '%' . $req['q'] . '%');
        }
        return view('news.index', ['newsList' => $newsList->orderBy('created_at')->take(30)->get()]);
    }
    public function show(Request $req)
    {
        $req->validate([
            'id' => 'required|exists:news,id',
        ]);
        $news = News::find($req['id']);
        $commentsTree = $this->commentsToContinuousRecur(NewsComment::where('news_id', $news->id)
                                                         ->whereNull('parent_news_comments_id')->get(),
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
        $req->validate([
            'url' => 'required|url',
        ]);
        $url = $req->url;
        $user = Auth::user();
        News::urlOnlyInGenerate($url, $user->id);
        return redirect('/newsList');
    }
}
