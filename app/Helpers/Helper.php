<?php

namespace App\Helpers;
use App\User;
use App\News;

class Helper
{
    /**
     * コメント展開
     *
     * @param array $commentTree
     * @return string
     */

    public static function CommentsTreeToHtml($commentsTree)
    {
        $result = '';
        $commentRoot = $commentsTree['root'];
        if(!empty($commentRoot)){
            $result .= '<div class="card col-md-12 col-md-offset-1">';
            $result .= '<h5 class="card-header">';
            $result .= e(User::find($commentRoot->user_id)->name);
            $newsId = News::find($commentRoot->news_id)->id;
            $result .= '<a class="badge badge-info" href="/comment/reply?parentId='
                    . $commentRoot->id
                    .'&newsId='
                    . $newsId
                    . '">reply</a>';
            $result .= '</h5>';
            $result .= '<div class="card-body">';
            $result .= e($commentRoot->contents);
            $result .= '</div>';
        }
        foreach($commentsTree['children'] as $commentsTreeChild){
            if(!empty($commentsTreeChild)) {
                $result .= self::CommentsTreeToHtml($commentsTreeChild);
            }
        }
        if(!empty($commentRoot)){
            $result .= '</div>';
        }
        return $result;
    }
}
