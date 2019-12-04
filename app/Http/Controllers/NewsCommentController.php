<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsComment;

class NewsCommentController extends Controller
{
    //
    public function index()
    {
        $comments = NewsComment::all()->sortBy('created_at');
        return view('comments.index', ['comments' => $comments]);
    }
}
