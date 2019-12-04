<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpQuery;

class News extends Model
{
    //
    protected $guarded = array('d', 'created_at');
    public static function urlOnlyInGenerate(string $url, int $user_id)
    {
        $html = file_get_contents($url);
        $doc = phpQuery::newDocument($html);
        $title = $doc->find('title')->text();
        $description = mb_substr($doc->find('body')->text(), 300);
        $domain = str_replace('www.', '', parse_url($url)["host"]);
        return News::create([
            'url' => $url,
            'title' => $title,
            'domain' => $domain,
            'user_id' => $user_id,
            'description' => $description,
        ]);
    }
}
