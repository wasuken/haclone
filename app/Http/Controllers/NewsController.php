<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsComment;
use Illuminate\Support\Facades\Log;

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
        $comments = NewsComment::all()->where('news_id', $news->id);
        return view('news.show', ['news' => $news, 'comments' => $comments]);
    }
}
