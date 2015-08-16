Shortnr
==========

A simple file-based URL shortener in PHP: _Shortnr_.

# Usage

1. Clone or download this repository.
2. Open up `config.php` and set your URL.
3. Run the following command to create your redirects.

```
php app.php redirects:create https://dvk.co --key=dvk
```

If the `--key` argument is omitted, a key will be generated based on the target URL. If the target URL is missing a protocol, `http` is assumed.