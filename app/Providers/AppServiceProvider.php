<?php

namespace App\Providers;

use App\UrlPaginator;
use Illuminate\Support\ServiceProvider;
use Statamic\Extensions\Pagination\LengthAwarePaginator;
use Statamic\Facades\Entry;
use Statamic\StaticSite\Generator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        SSG::after(function () {
            $from = public_path('img');
            $to = config('statamic.ssg.destination').'/img';
            app('files')->copyDirectory($from, $to);
        });
        
        if ($this->app->runningInConsole()) {
            $this->bootSsg();
        }

        
    }

    private function bootSsg()
    {
        $this->app->extend(LengthAwarePaginator::class, function ($paginator) {
            $options = $paginator->getOptions();
            $options['path'] = preg_replace('/\/page\/\d+$/', '', $options['path']);

            return $this->app->makeWith(UrlPaginator::class, [
                'items' => $paginator->getCollection(),
                'total' => $paginator->total(),
                'perPage' => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'options' => $options,
            ]);
        });

        UrlPaginator::currentPageResolver(function () {
            return optional($this->app['request']->route())->parameter('page');
        });

        $this->app->beforeResolving(Generator::class, function ($generator) {
            $config = config('statamic.ssg');

            $config['urls'] = array_merge(
                $config['urls'],
                $this->articleUrls(),
                // $this->blogUrls(),
                // $this->tagUrls(),
                // etc
            );

            config(['statamic.ssg' => $config]);
        });
    }

    private function articleUrls()
    {
        // The URL of the listing.
        $url = '/news';

        // The number of entries per page, according to your collection tag.
        $perPage = 10;

        // The total number of entries in the collection.
        // Make sure to mimic whatever params/filters are on the collection tag.
        $total = Entry::query()->where('collection', 'news')->where('status', 'published')->count();

        return collect(range(1, ceil($total / $perPage)))
            ->map(fn ($page) => $url.'/page/'.$page)
            ->all();
    }
}