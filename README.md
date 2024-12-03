# Laravel Meta-Tags Automatic Generation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/infernalmedia/meta-tags.svg?style=flat-square)](https://packagist.org/packages/infernalmedia/meta-tags)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/infernalmedia/meta-tags/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/infernalmedia/meta-tags/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/infernalmedia/meta-tags/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/infernalmedia/meta-tags/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/infernalmedia/meta-tags.svg?style=flat-square)](https://packagist.org/packages/infernalmedia/meta-tags)

This package provides a component that generates meta tags for your website.

Place the component in the head of your layout like this and you're good to go:

```html
<head>
    <x-meta-tags :page-title="$pageTitle ?? null"
                 :meta-image="$seoImage ?? null"
                 :custom-breadcrumb="$breadcrumb ?? null"
                 :description="$pageDescription ?? null" />    
</head>
```

## Installation

You can install the package via composer:

```bash
composer require infernalmedia/meta-tags
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="meta-tags-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="meta-tags-views"
```

## Usage

```php
<x-meta-tags :page-title="$pageTitle ?? null"
             :meta-image="$seoImage ?? null"
             :custom-breadcrumb="$breadcrumb ?? null"
             :description="$pageDescription ?? null" />
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jean Lalande](https://github.com/jlalande)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
