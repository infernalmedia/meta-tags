<?php

namespace Infernalmedia\MetaTags;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;
use Spatie\SchemaOrg\BreadcrumbList;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\PostalAddress;
use Spatie\SchemaOrg\Schema;

class MetaTags extends Component
{
    const DEFAULT_IMAGE = "https://website.com/images/default.jpg";

    private $pageTitle;
    private $metaImage;
    private $description;
    private $customBreadcrumb;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        ?string $description = null,
        ?string $pageTitle = null,
        ?string $metaImage = null,
        ?BreadcrumbList $customBreadcrumb = null
    ) {
        $this->description = $description;
        $this->pageTitle = $pageTitle;
        $this->metaImage = $metaImage;
        $this->customBreadcrumb = $customBreadcrumb;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.meta-tags');
    }

    public function getAppUrl()
    {
        return config('app.url');
    }

    public function getGoogleSiteVerification()
    {
        return config('meta.googleSiteVerification');
    }

    public function getGoogleTagManagerKey(): string | false
    {
        if (config('meta.enable_google_tag_tracking')) {
            return config('meta.googleTagManager');
        }

        return false;
    }

    public function getGoogleTagManagerEnvironnement(): string
    {
        if (config('meta.googleTagManagerAuth') && config('meta.googleTagManagerEnv')) {
            $auth = config('meta.googleTagManagerAuth');
            $env = config('meta.googleTagManagerEnv');

            return "&gtm_auth={$auth}&gtm_preview={$env}&gtm_cookies_win=x";
        }

        return '';
    }

    public function getFacebookDomainVerification(): string | false
    {
        if (config('meta.enable_facebook_tracking')) {
            return config('meta.facebookDomainVerification');
        }

        return false;
    }

    public function getTitle()
    {
        return $this->pageTitle ?? config('app.name');
    }

    public function getOgData()
    {
        return [
            "type" => 'website',
            "title" => $this->getTitle(),
            "description" => $this->getDescription(),
            "url" => URL::current(),
            "locale" => str_replace('_', '-', app()->getLocale()),
            "site_name" => config('app.name'),
            "updated_time" => null,
        ];
    }

    public function getOgImage()
    {
        $image = $this->setOgImage();
        return [
            "image" => $image->url,
            "image:secure_url" => $image->url,
        ];
    }

    public function getTwitterData()
    {
        return [
            "card" => 'summary_large_image',
            "title" => $this->pageTitle,
            "site" => config('meta.social_networks.twitter'),
            "description" => $this->getDescription(),
            "image" => $this->getTwitterImage(),
            "creator" => config('meta.social_networks.twitter'),
        ];
    }

    public function getSchema()
    {
        $schema = new Graph();
        $schema->add($this->setOrganization());
        $schema->add($this->setWebsite());
        $schema->add($this->getBreadcrumbs());

        return $schema->toScript();
    }

    public function setOrganization()
    {
        return Schema::organization()
            ->name(config('app.name'))
            ->description($this->getDescription())
            ->telephone(config('meta.phone'))
            ->logo($this->getLogo())
            ->image($this->getSchemaImg())
            ->address($this->getAddress())
            ->url($this->getAppUrl())
            ->sameAs(config('meta.social_networks'))
            ->contactPoint(Schema::contactPoint()
                    ->telephone(config('meta.phone'))
                    ->hoursAvailable($this->getOpeningHours())
                    ->areaServed("North_America"))
            ->areaServed("North_America")
            ->slogan(__(config('meta.slogan')));
    }

    protected function setWebsite()
    {
        return Schema::webSite()
            ->name(config('app.name'))
            ->description($this->getDescription())
            ->url($this->getAppUrl())
            ->sameAs(config('meta.social_networks'))
            ->inLanguage(App::getLocale());
    }

    private function getOpeningHours()
    {
        $days = [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
        ];

        return Schema::openingHoursSpecification()
            ->dayOfWeek($days)
            ->opens(config('meta.opening_hours_start'))
            ->closes(config('meta.opening_hours_end'));
    }

    public function getLogo()
    {
        $path = "{$this->getAppUrl()}/images/logo.png";

        return Schema::ImageObject()
            ->url($path)
            ->height('200px')
            ->width('200px');
    }

    private function getSchemaImg()
    {
        return Schema::ImageObject()
            ->url($this->getDefaultImage());
    }

    private function setOgImage(): object
    {
        $image = $this->getDefaultImage();
        return (object) [
            'url' => $image,
        ];
    }

    private function getTwitterImage(): string
    {
        return $this->getDefaultImage();
    }

    public function getDescription()
    {
        return $this->description ?? '';
    }

    public function getDefaultImage()
    {
        return $this->metaImage ?? config('meta.social_networks.default_image');
    }

    private function getAddress(): PostalAddress
    {
        return Schema::postalAddress()
            ->telephone(config('meta.organization.phone'))
            ->postalCode(config('meta.organization.postal_code'))
            ->streetAddress(config('meta.organization.address'))
            ->addressLocality(config('meta.organization.city'))
            ->addressRegion(config('meta.organization.region'))
            ->addressCountry(config('meta.organization.country'));
    }

    protected function getBreadcrumbs(): BreadcrumbList
    {
        if ($this->customBreadcrumb && $this->customBreadcrumb->getProperties()) {
            return $this->customBreadcrumb;
        }

        return Schema::breadcrumbList()
            ->name(config('app.name'))
            ->itemListElement($this->buildCurrentBreadcrumb());
    }

    private function buildCurrentBreadcrumb(): array
    {
        $appUrl = $this->getAppUrl();
        $list = [];
        $list[] = $this->addHomepage($appUrl);

        if (Route::currentRouteName() !== 'home') {
            $list[] = Schema::listItem()
                ->setProperty('position', 2)
                ->item(
                    Schema::webPage()
                        ->name($this->getTitle())
                        ->url(URL::current())
                        ->setProperty('@id', URL::current())
                );
        }

        return $list;
    }

    private function addHomepage($appUrl)
    {
        return Schema::listItem()
            ->setProperty('position', 1)
            ->item(
                Schema::webPage()
                    ->name(config('app.name'))
                    ->url($appUrl)
                    ->setProperty('@id', $appUrl)
            );
    }
}
