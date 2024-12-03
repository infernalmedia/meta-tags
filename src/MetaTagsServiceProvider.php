<?php

namespace Infernalmedia\MetaTags;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MetaTagsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('meta-tags')
            ->hasConfigFile()
            ->hasViewComponent('infernal', MetaTags::class);
    }
}
