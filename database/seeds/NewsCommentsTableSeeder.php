<?php

use Illuminate\Database\Seeder;
use App\NewsComment;

class NewsCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = App\User::all()->first();
        $news = App\News::all()->first();
        NewsComment::create([
            'user_id' => $user->id,
            'news_id' => $news->id,
            'contents' => Str::random(100),
        ]);
        $news_comment = NewsComment::all()
                      ->where('user_id', $user->id)
                      ->where('news_id', $news->id)
                      ->first();
        NewsComment::create([
            'user_id' => $user->id,
            'news_id' => $news->id,
            'parent_news_comments_id' => $news_comment->id,
            'contents' => Str::random(100),
        ]);
    }
}
