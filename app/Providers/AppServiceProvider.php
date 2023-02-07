<?php

namespace App\Providers;

use App\Post\GetPost;
use App\Facts\GetFact;
use App\Stories\GetStory;
use App\Post\PostInterface;
use App\Facts\FactInterface;
use App\Pharmalys\Pharmalys;
use Filament\Facades\Filament;
use App\Stories\StoryInterface;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FactInterface::class, GetFact::class);
        $this->app->bind(StoryInterface::class, GetStory::class);
        $this->app->bind(PostInterface::class, GetPost::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationItems($this->getPages());
        });
    }

    public function getPages()
    {
        $serial = 1;

        $pages = [];
        foreach (\App\Pharmalys\Pharmalys::getPages() as $pageValue => $page) {
            $url = "/admin/page-blocks/?page={$pageValue}";

            $pages[] = NavigationItem::make($page['title'])
                ->url($url, shouldOpenInNewTab: false)
                ->icon($page['icon'])
                ->group('Pages')
                ->sort($serial);

            $serial++;
        }

        return $pages;
    }
}
