<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $urls = [
            'https://pusher.com/docs/chatkit/quick_start/javascript',
            'https://qiita.com/hirotatsuuu/items/7f86344b1f2ffaf0dc7f',
            'https://news.ycombinator.com/news',
            'https://thr3a.hatenablog.com/entry/20171118/1510993074',
            'https://hn.algolia.com/api',
            'https://dev.classmethod.jp/server-side/algolia/algolia-1st-impression/',
            'https://www.j-cast.com/tv/2019/12/03374179.html',
        ];
        foreach($urls as $url){
            App\News::urlOnlyInGenerate($url);
            sleep(3);
        }
    }
}
