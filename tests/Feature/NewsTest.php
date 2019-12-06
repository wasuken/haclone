<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\News;
use App\User;

class NewsTest extends TestCase
{
    use RefreshDatabase;
    private $pwd = 'unchiunchi';
    private $email = 'unchi@test.com';
    private $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'unchi',
            'email' => $this->email,
            'password' => Hash::make($this->pwd),
        ]);
        // なんども取得するのは迷惑だし先に取得しとく。
        News::urlOnlyInGenerate('https://readouble.com/laravel/5.8/ja/validation.html', $this->user->id);
    }
    public function testBasic()
    {
        // とりあえず、記事が表示されてるかどうかだけ。
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('haclone')
            ->assertSee(mb_substr('バリデーション 5.8 Laravel', 0, 10));
    }
    // あらかじめ作成したユーザでログイン/ログアウトを切り替える。
    // 別に切り替えなくても、ログインのみで良かったかもしれない。
    public function loginLogoutSwitching()
    {
        if(Auth::check()){
            $resp = $this->post('/logout');
            $this->assertFalse(Auth::check());
        }else{
            $resp = $this->post('/login', [
                'email' => $this->email,
                'password' => $this->pwd,
            ]);
            $this->assertTrue(Auth::check());
        }
    }
    // ログインできるかどうかだけチェックする。
    public function testLogin()
    {
        $this->loginLogoutSwitching();
        $this->get('/')->assertSee($this->user->name);
    }
    public function testLoginFail()
    {
        $str = 'うんち';
        $resp = $this->followingRedirects()->post('/login', [
            'email' => $this->email . $str,
            'password' => $this->pwd . $str,
        ])->assertDontSee($this->user->name)
              ->assertSee('These credentials do not match our records.');
        $this->assertFalse(Auth::check());
    }
    public function testNewsShow()
    {
        $news = News::all()->first();
        $this->get('/news?id='.$news->id)->assertSee(mb_substr($news->title, 0, 35));
        $this->followingRedirects()
            ->get('/news?id=lksajfkdsakfjdsak')
            ->assertSee('The selected id is invalid.');
        // ログイン時
        $this->loginLogoutSwitching();
        $this->get('/news?id='.$news->id)->assertSee(mb_substr($news->title, 0, 35));
        $this->followingRedirects()
            ->get('/news?id=lksajfkdsakfjdsak')
            ->assertSee('The selected id is invalid.');
    }
    //
    public function testNewsPost()
    {
        // ログインしてない状態からpostページを取得しようとする(失敗)
        $this->get('/news/create')->assertDontSee('Post News');
        // ログインしてない状態からpostしようとする(失敗)
        $this->post('/news', [
            'url' => 'https://news.ycombinator.com/',
        ]);
        $this->get('/newsList')->assertDontSee('Hacker News');
        // ログインしている状態からpostページを取得しようとする(成功)
        $this->loginLogoutSwitching();
        $this->get('/news/create')->assertSee('Post News');
        // ログインしている状態からpostしようとする(成功)
        $this->post('/news', [
            'url' => 'https://news.ycombinator.com/',
        ]);
        $this->get('/newsList')->assertSee('Hacker News');
        $this->followingRedirects()->post('/news', [
            'url' => 'ガババビッチ',
        ])->assertSee('The url format is invalid.');
    }
    public function testSearch()
    {
        // 現状はdomainで絞る機能のみ。
        $errorMsgList = [];
        $errorMsgList['domain_greater_than_100'] = 'The domain may not be greater than 100 characters.';
        $errorMsgList['domain_least_3'] = 'The domain must be at least 3 characters.';
        $errorMsgList['q_greater_than_100'] = 'The q may not be greater than 100 characters.';
        $errorMsgList['q_least_1'] = 'The q must be at least 1 characters.';
        $title = 'バリデーション 5.8 Laravel';
        // no ログイン
        $this->get('/search?domain=readouble.com')->assertSee($title);
        $this->get('/search?domain=hogehoge.com')->assertDontSee($title);
        $this->get('/search?q=readouble')->assertSee($title);
        $this->get('/search?q=hogehoge')->assertDontSee($title);
        $this->followingRedirects()->get('/search?domain=')
            ->assertSee($errorMsgList['domain_least_3']);
        $this->followingRedirects()->get('/search?q=')
            ->assertSee($errorMsgList['q_least_1']);
        $this->followingRedirects()->get('/search?q=' . Str::random(200))
            ->assertSee($errorMsgList['q_greater_than_100']);
        $this->followingRedirects()
            ->get('/search?domain=' . Str::random(200))
            ->assertSee($errorMsgList['domain_greater_than_100']);
        // ログイン
        $this->loginLogoutSwitching();
        $this->get('/search?domain=readouble.com')->assertSee($title);
        $this->get('/search?domain=hogehoge.com')->assertDontSee($title);
        $this->get('/search?q=readouble')->assertSee($title);
        $this->get('/search?q=hogehoge')->assertDontSee($title);
        $this->followingRedirects()->get('/search?domain=')
            ->assertSee($errorMsgList['domain_least_3']);
        $this->followingRedirects()->get('/search?q=')
            ->assertSee($errorMsgList['q_least_1']);
        $this->followingRedirects()->get('/search?q=' . Str::random(200))
            ->assertSee($errorMsgList['q_greater_than_100']);
        $this->followingRedirects()
            ->get('/search?domain=' . Str::random(200))
            ->assertSee($errorMsgList['domain_greater_than_100']);
    }
}
