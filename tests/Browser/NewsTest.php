<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NewsTest extends DuskTestCase
{
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL').'/')->assertPortIs(8000);
            $browser
                ->visit(env('APP_URL').'/')
                ->screenshot("index")
                ->assertTitle('haclone');
        });
    }
}
