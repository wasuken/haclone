<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\News;

class NewsTest extends TestCase
{
    use RefreshDatabase;
    public function testBasic()
    {
        $news = News::create(['url' => 'https://reffect.co.jp/laravel/laravel_sqlite']);
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('haclone')
            ->assertSee('laravel_sqlite');
    }
}
