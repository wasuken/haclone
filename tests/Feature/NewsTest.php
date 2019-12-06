<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
    }
    public function testSearch()
    {
        // 現状はdomainで絞る機能のみ。
        $title = 'バリデーション 5.8 Laravel';
        $this->get('/search?domain=readouble.com')->assertSee($title);
        $this->get('/search?domain=hogehoge.com')->assertDontSee($title);
        // ログイン
        $this->loginLogoutSwitching();
        $this->get('/search?domain=readouble.com')->assertSee($title);
        $this->get('/search?domain=hogehoge.com')->assertDontSee($title);
    }
}
