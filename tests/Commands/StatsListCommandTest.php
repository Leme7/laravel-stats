<?php

namespace Wnx\LaravelStats\Tests\Commands;

use Wnx\LaravelStats\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class StatsListCommandTest extends TestCase
{
    /**
     * Override stats.path confiugration to not include `tests` folder
     * This fixes the issue, that orchestra does not ship with the
     * default `tests` folder and would throw an error, because
     * the path does not exist.
     */
    public function overrideConfig()
    {
        config()->set('stats.paths', [
            base_path('app'),
            base_path('database'),
        ]);
        config()->set('stats.ignored_namespaces', []);
    }

    /** @test */
    public function it_works()
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');

        $this->overrideConfig();

        $this->artisan('stats');
        $resultAsText = Artisan::output();

        $this->assertContains('Middlewares', $resultAsText);
        $this->assertContains('Controllers', $resultAsText);
        $this->assertContains('Other', $resultAsText);
        $this->assertContains('Total', $resultAsText);
    }

    /** @test */
    public function it_displays_all_headers()
    {
        $this->overrideConfig();

        $this->artisan('stats');
        $result = Artisan::output();

        $this->assertContains('Name', $result);
        $this->assertContains('Classes', $result);
        $this->assertContains('Methods', $result);
        $this->assertContains('Methods/Class', $result);
        $this->assertContains('Lines', $result);
        $this->assertContains('LoC', $result);
        $this->assertContains('LoC/Method', $result);
    }
}
