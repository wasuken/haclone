<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    //
    public function index()
    {
        $newsList = News::all();
        return view('news.index', ['newsList' => $newsList]);
    }
}
