# REST Client Bundle

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/RestClientBundle/build-status/develop) |

## Installation

```sh
composer require innmind/rest-client-bundle
```

Enable the bundle by adding the following line in your app/AppKernel.php of your project:

```php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Innmind\Rest\ClientBundle\InnmindRestClientBundle,
        );
        // ...
    }
    // ...
}
```

Then you need to specify the types you allow in the app, here's an example:

```yaml
innmind_rest_client:
    content_type:
        json:
            priority: 0
            media_types:
                application/json: 0
```

## Usage

```php
$container
    ->get('innmind_rest_client')
    ->server('http://example.com/')
    ->capabilities()
    ->names();
```

This example would return all the resource available through the api of `http://example.com/`.

Then you can access the following method on any server: `all`, `read`, `create`, `update` and `remove`. Check the [interface](https://github.com/Innmind/rest-client/blob/master/src/ServerInterface.php) to understand how to use these methods.
