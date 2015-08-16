Shortnr
==========

A simple file-based URL shortener in PHP: _Shortnr_.

_Please be warned that this is very much a work in progress. No stable version has been tagged yet, so all this could be subject to breaking changes._

# Usage

1. Clone or download this repository.
2. Open up `config.php` and set your base URL.
3. Configure your webserver to rewrite all requests to `redirect.php`

_Apache_

```
RewriteEngine on
RewriteRule . redirect.php [L]
```

_Nginx_
```
try_files $uri /redirect.php;
```

4. Run the following from the command line to create a redirect.

```
php app.php redirects:create https://dvk.co --key=dvk
```

If the `--key` argument is omitted, a key will be generated based on the target URL. If the target URL is missing a protocol, `http` is assumed.

```
$ php app.php redirects:create google.com
Scheme of target URL missing, assuming "http".
Success! Redirect to http://google.com/ created at http://shortnr.com/gglcm.
```