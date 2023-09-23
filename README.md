# CORS plugin for October CMS

This plugin is based on [https://github.com/barryvdh/laravel-cors](https://github.com/barryvdh/laravel-cors/blob/master/config/cors.php).

All configuration for the plugin can be done via the backend settings.

The following cors headers are supported:

* Access-Control-Allow-Origin
* Access-Control-Allow-Headers
* Access-Control-Allow-Methods
* Access-Control-Allow-Credentials
* Access-Control-Expose-Headers
* Access-Control-Max-Age

Currently these headers are sent for every request. There is no per-route configuration possible at this time.

## Attention : 
j'ai modifié dans la classe Cors : 
```php
public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
par 
public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
```
j'ai aussi modifier la methode handle de HandlePreflight . ça semble fonctionner mais je ne mesure pas l'impace : 
```php
public function handle($request, Closure $next)
{
    $response = $next($request);
    if ($this->cors->isPreflightRequest($request) && $this->hasMatchingCorsRoute($request)) {
        $preflight = $this->cors->handlePreflightRequest($request);
        $response->headers->add($preflight->headers->all());
    }

    return $response;
}
par 
public function handle($request, Closure $next)
{
    $response = $next($request);
    if ($this->cors->isPreflightRequest($request) && $this->hasMatchingCorsRoute($request)) {
        $preflight = $this->cors->handlePreflightRequest($request);
        $response = response('', 200);
        $response->headers->add($preflight->headers->all());
    }

    return $response;
}
```
## Setup

After installing the plugin visit the CORS settings page in your October CMS backend settings.

You can add `*` as an entry to `Allowed origins`, `Allowed headers` and `Allowed methods` to allow any kind of CORS request from everywhere.

It is advised to be more explicit about these settings. You can add values for each header via the repeater fields.

> It is important to set these intial settings once for the plugin to work as excpected!

### Filesystem configuration

As an alternative to the backend settings you can create a `config/config.php` file in the plugins root directory to configure it.

The filesystem configuration will overwrite any defined backend setting.

```php
<?php
// plugins/waka/wakapi/config/config.php
return [
    'supportsCredentials' => true,
    'maxAge'              => 3600,
    'allowedOrigins'      => ['*'],
    'allowedHeaders'      => ['*'],
    'allowedMethods'      => ['GET', 'POST'],
    'exposedHeaders'      => [''],
];
```