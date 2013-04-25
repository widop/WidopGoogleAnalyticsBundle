# Installation

## Symfony >= 2.1.*

Require the bundle in your composer.json file (**You should choose the tag/branch that fits to your needs**):

```
{
    "require": {
        "widop/google-analytics-bundle": "*",
    }
}
```

Register the bundles:

``` php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        new Widop\GoogleAnalyticsBundle\WidopGoogleAnalyticsBundle(),
        new Widop\HttpAdapterBundle\WidopHttpAdapterBundle(),
        // ...
    );
}
```

Install the bundle:

```
$ composer update
```

## Symfony <= 2.0.*

Add Wid'op Google Analytics & Http Adapter bundles (**You should choose the tag/branch that fits to your needs**):

```
[WidopGoogleAnalyticsBundle]
    git=http://github.com/widop/WidopGoogleAnalyticsBundle.git
    target=bundles/Widop/GoogleAnalyticsBundle
    version=1.0.0

[WidopHttpAdapterBundle]
    git=http://github.com/widop/WidopHttpAdapterBundle.git
    target=bundles/Widop/HttpAdapterBundle
    version=1.0.0
```

Autoload the Wid'op Google Analytics & Http Adapter bundles namespaces:

``` php
// app/autoload.php

$loader->registerNamespaces(array(
    'Widop\\GoogleAnalyticsBundle' => __DIR__.'/../vendor/bundles',
    'Widop\\HttpAdapterBundle'     => __DIR__.'/../vendor/bundles',
    // ...
);
```

Register the bundles:

``` php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        new Widop\GoogleAnalyticsBundle\WidopGoogleAnalyticsBundle(),
        new Widop\HttpAdapterBundle\WidopHttpAdapterBundle(),
        // ...
    );
}
```

Run the vendors script:

``` bash
$ php bin/vendors install
```
