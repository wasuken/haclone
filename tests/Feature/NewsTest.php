<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\News;
use App\User;

class NewsTest extends TestCase
{
    use RefreshDatabase;
    public function testBasic()
    {
        $user = User::create([
            'name' => 'unchi',
            'email' => 'unchi@test.com',
            'password' => Hash::make('unchiunchi')
        ]);
        $news = News::urlOnlyInGenerate('https://reffect.co.jp/laravel/laravel_sqlite', $user->id);
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('haclone')
            ->assertSee('Laravelでsqliteデータベースを使ってみよう | アールエフェクト');
    }
    public function testLogin()
    {
        $this->post('/')
    }

}
