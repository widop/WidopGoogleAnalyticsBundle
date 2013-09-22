# Usage

## Get your credential

All is explain [here](https://github.com/widop/google-analytics/blob/master/doc/usage.md#get-your-credentials).

## Configuration

The bundle can be configured quite easily, and of course you can change the configuration given your environment
(dev, test, prod):

``` yaml
# app/config/config.yml
widop_google_analytics:
    client_id:        "XXXXXXXXXXXX@developer.gserviceaccount.com"
    profile_id:       "ga:XXXXXXXX"
    private_key_file: "%kernel.root_dir%/Resources/bin/myPrivateKey.p12"
    http_adapter:     "widop_http_adapter.curl"
```

The `client_id`, `profile_id` and `private_key_file` parameters are mandatory while the `http_adapter` is optionnal.
By default, this parameter is set to `widop_http_adapter.curl`. If you want to change the http adapter you can take a
look at the [WidopHttpAdapterBundle](https://github.com/widop/WidopHttpAdapterBundle) documentation.

For testing purpose, you can change the google analytics url used internally by the bundle to fetch you datas:

``` yaml
# app/config/config_test.yml
widop_google_analytics:
    service_url: http://your-own-url
```

## Query

The query documentation is available [here](https://github.com/widop/google-analytics/blob/master/doc/usage.md#query).
To create a new one:

``` php
$query = $this->container->get('widop_google_analytics.query');
```

## Client

The client documentation is available [here](https://github.com/widop/google-analytics/blob/master/doc/usage.md#client).
To get it:

``` php
$client = $this->container->get('widop_google_analytics.client');
```

## Service

The service documentation is available [here](https://github.com/widop/google-analytics/blob/master/doc/usage.md#service).
To get it:

``` php
$service = $this->container->get('widop_google_analytics');
```
