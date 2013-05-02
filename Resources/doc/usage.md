# Usage

## Before Starting

 * Create a [Google App](http://code.google.com/apis/console).
 * Enable the Google Analytics service.
 * Create a service account on [Google App](http://code.google.com/apis/console) (Tab "API Access", choose
   "Create client ID" and then "Service account").
 * Get the mail which will gives you the `client_id` and `profile_id` or simply copy them from
   [Google App](http://code.google.com/apis/console) (use "Email Adress" as `client_id` and "Client ID" as your
   `profile_id`).
 * Download the private key and put it somewhere on your server (for instance, you can put it in `app/bin/`).

## Configuration

The `WidopGoogleAnalyticsBundle` can be configured quite easily, and of course you can change the configuration given
your environment (dev, test, prod):

``` yml
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

## The client

The first service created by the `WidopGoogleAnalyticsBundle` is the **client**. It contains the previous configuration
and is used to obtain an OAUTH2 access token.

To obtain it, simply:

``` php
$client = $this->container->get('widop_google_analytics.client');
```

If for some reason, you need to change the client configuration on the fly, you can still do it this way:

``` php
$client->setClientId('XXXXXXXXXXXX@developer.gserviceaccount.com');
$client->setPrivateKeyFile(__DIR__ . '/bin/myPrivateKey.p12');
```

## The Google Analytics Service

The second service created by the bundle is the `widop_google_analytics`. As its name indicates, it allows you to
contact the google analytics service. You pass it your hand-made query and it'll do the job:

``` php
$query = $this->container->get('widop_google_analytics.query');

// Do your stuff with the query
$response = $this->container->get('widop_google_analytics')->query($query);
```

## The query

The query object can be compared to the doctrine query builder, allowing you to easily contact the google analytics
service. The query can be obtained by getting it from the container.

``` php
$query = $this->container->get('widop_google_analytics.query');
```

Here is an example of what you can do with the query object:

``` php
$query = $this->container->get('widop_google_analytics.query');
$query->setIds('ga:XXXXXXXX');
$query->setDimensions(array('ga:eventLabel'));
$query->setStartDate(new \DateTime('2012-01-01'));
$query->setEndDate(new \DateTime());
$query->setMetrics(array('ga:uniqueEvents'));
$query->setFilters(array('ga:eventCategory==travelClick'));
$query->setSorts($query->getDimensions());
```

## The response

When querying the google analytics service, the `query` method returns a `Response` object.

``` php
$query = $this->container->get('widop_google_analytics.query');
// Configure the query.

// Query the Google Analytics service.
$response = $this->container->get('widop_google_analytics')->query($query);

// Play with the response informations.
$profileInfo = $this->getProfileInfo();
$kind = $this->getKind();
$id = $this->getId();
$query = $this->getQuery();
$selfLink = $this->getSelfLink();
$previousLink = $this->getPreviousLink();
$nextLink = $this->getNextLink();
$startIndex = $this->getStartIndex();
$itemsPerPage = $this->getItemsPerPage();
$totalResults = $this->getTotalResults();
$containsSampledData = $this->containsSampledData();
$columnHeaders = $this->getColumnHeaders();
$totalForAllResults = $this->getTotalsForAllResults();
$hasRows = $this->hasRows();
$rows = $this->getRows();
```
