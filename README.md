# WidopGoogleAnalyticsBundle

The `WidopGoogleAnalyticsBundle` provides a way to use certificate-based authentication in server-to-server interactions for google analytics.

In other words, no user interaction will be required thanks to the ".p12" certificate and you will be able to automate your google analytics authentication and authorization processes as well as the way of querying the google analytics service.

License
-------

The bundle is under the MIT license. See the complete license [here](http://github.com/widop/WidopGoogleAnalyticsBundle/blob/master/Resources/meta/LICENSE).


## Summary
* **[Dependencies](#dependencies)**
* **[TODO](#todo)**
* **[Installation](#install)**
* **[Set up](#setup)**
 - **[Before starting](#foreword)**
 - **[Configuration](#conf)**
 - **[The client](#client)**
 - **[The google analytics service](#ga-service)**
 - **[The query](#query)**
 - **[The response](#response)**

## <a name="dependencies"/> Dependencies
The bundle has a few dependencies:
* WidopHttpAdapterBundle (used when executing HTTP requests [CURL, Buzz ...])

## <a name="todo"/> TODO
* Cache the token
* Tests?

## <a name="install"/> Installation
The bundle can be installed via composer (composer.json):
```json
    "widop/google-analytics-bundle": "dev-master"
```

## <a name="setup"/> Setup
### <a name="foreword"/> Before starting
* create a [google app](http://code.google.com/apis/console)
* enable the google analytics service
* create a service account
* get the mail which will represent the client_id in your ```config.yml```
* download the private key and put it somewhere on your server (for instance you can put it in ```app/bin/```)

### <a name="conf"/> Configuration

The WidopGoogleAnalyticsBundle can be configured quite easily, and of course you can change the configuration given your environment (dev, test, prod) :

```yml
# app/config/config_dev.yml
widop_google_analytics:
    client_id: XXXXXXXXXXXX@developer.gserviceaccount.com
    private_key_file: %kernel.root_dir%/Resources/bin/myPrivateKey.p12
    http_adapter: widop_http_adapter.curl
```

> The ```client_id``` and ```private_key_file``` parameters are mandatory while the ```http_adapter``` is optionnal. By default, this parameter is set to ```widop_http_adapter.curl```. If you want to change the http adapter you can take a look at the [WidopHttpAdapterBundle](https://github.com/widop/WidopHttpAdapterBundle) documentation.

### <a name="client"/> The client
The first service created by the WidopGoogleAnalyticsBundle is the client.
It contains the previous configuration and is used to obtain an OAUTH2 access token.

To obtain it, simply:

```php
<?php
// ...
    $this
        ->container
        ->get('widop_google_analytics.client')
        ->getAccessToken();
// ...
```

If for some reason, you need to change the client configuration on the fly, you can still do it this way:
```php
<?php
...
    $client = $this->container->get('widop_google_analytics.client');
    $client
        ->setClientId('XXXXXXXXXXXX@developer.gserviceaccount.com')
        ->setPrivateKeyFile(__DIR__ . '/bin/myPrivateKey.p12')
        ->getAccessToken();
...
```

### <a name="ga-service"/> The google analytics service
The second service created by the bundle is the ```widop_google_analytics```.
As its name indicates, it allows you to contact the google analytics service.
You pass it your hand-made query and it'll do the job:

```php
<?php
...
    $query = $this->container->get('widop_google_analytics.query');
    // Do your stuff with the query
    $response = $this->container->get('widop_google_analytics')->query($query);
...
```

### <a name="query"/> The query
The query object can be compared to the doctrine query builder, allowing you to easily contact the google analytics service. The query can be obtained either by getting it from the container (as a service), or by being instanciated.

```php
<?php
    $query = $this->container->get('widop_google_analytics.query');
    // Do your stuff with the query
```
> OR

```php
<?php
    use Widop\GoogleAnalyticsBundle\Model\Query;

    $query = new Query();
    // Do your stuff with the query
```

Here is an example of what you can do with the query object:
```php
<?php
    $query = $this->container->get('widop_google_analytics.query');
    $query
        ->setIds('ga:XXXXXXXX')                              // Set your app id
        ->setDimensions(array('ga:eventLabel'))              // Set the dimensions to query
        ->setStartDate(new \DateTime('2012-01-01'))          // Set the start-date parameter
        ->setEndDate(new \DateTime())                        // Set the end-date parameter
        ->setMetrics(array('ga:uniqueEvents'))               // Set the metrics to query
        ->setFilters(array('ga:eventCategory==travelClick')) // Set the filters
        ->setSorts($query->getDimensions());                 // Set the sorting parameters
```

### <a name="response"/> The response
When querying the google analytics service, the ```->query()``` method returns a ```Response``` object.

```php
<?php
...
    $query = $this->container->get('widop_google_analytics.query');
    // Do your stuff with the query
    $response = $this->container->get('widop_google_analytics')->query($query);
    foreach ($response->getRows() as $row) {
        // Do your stuff with $row
    }
...
```

> For the moment, the `->getRows()` method of a response returns an array of *raw* arrays. Maybe it'll be turned into an object in the future.