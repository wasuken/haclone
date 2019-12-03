<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpQuery;

class News extends Model
{
    //
    protected $guarded = array('d', 'created_at');
    public static function urlOnlyInGenerate(string $url)
    {
        $html = file_get_contents($url);
        $doc = phpQuery::newDocument($html);
        $title = $doc->find('title')->text();
        $domain = str_replace('www.', '', parse_url($url)["host"]);
        return News::create([
            'url' => $url,
            'title' => $title,
            'domain' => $domain,
        ]);
    }
}
