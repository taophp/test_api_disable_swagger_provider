# Test the new `_api_disable_swagger_provider` flag

## About this branch
After [just adding the flag], I tried to set html format options anywhere it should make sense:
- on the [User entity](https://github.com/taophp/test_api_disable_swagger_provider/blob/afd8a8bf41a2c43a9c159510d7bb59081bf5c4ef/api/src/Entity/User.php#L36),
- in the [configuration](https://github.com/taophp/test_api_disable_swagger_provider/blob/afd8a8bf41a2c43a9c159510d7bb59081bf5c4ef/api/config/packages/api_platform.yaml#L9) (probably useless).

It does not work.

## About branches
Rebuild docker images and restart containers is useless after first build (see _How to reproduce_ below). So you can try to click
the activation link just after emptying the cache :
``` bash
docker compose exec php bin/console c:c
```

Here are the routes:
```
-------------------------------------- ---------- -------- ------ -----------------------------------
 Name                                   Method     Scheme   Host   Path
-------------------------------------- ---------- -------- ------ -----------------------------------
 api_genid                              GET|HEAD   ANY      ANY    /.well-known/genid/{id}
 api_errors                             GET|HEAD   ANY      ANY    /errors/{status}
 api_validation_errors                  GET|HEAD   ANY      ANY    /validation_errors/{id}
 api_entrypoint                         GET|HEAD   ANY      ANY    /{index}.{_format}
 api_doc                                GET|HEAD   ANY      ANY    /docs.{_format}
 api_jsonld_context                     GET|HEAD   ANY      ANY    /contexts/{shortName}.{_format}
 _api_validation_errors_problem         GET        ANY      ANY    /validation_errors/{id}
 _api_validation_errors_hydra           GET        ANY      ANY    /validation_errors/{id}
 _api_validation_errors_jsonapi         GET        ANY      ANY    /validation_errors/{id}
 _api_/users{._format}_get_collection   GET        ANY      ANY    /users.{_format}
 _api_/users{._format}_post             POST       ANY      ANY    /users.{_format}
 _api_/users/{id}{._format}_get         GET        ANY      ANY    /users/{id}.{_format}
 _api_/users/{id}{._format}_put         PUT        ANY      ANY    /users/{id}.{_format}
 _api_/users/{id}{._format}_patch       PATCH      ANY      ANY    /users/{id}.{_format}
 _api_/users/{id}{._format}_delete      DELETE     ANY      ANY    /users/{id}.{_format}
 user_activate                          GET        ANY      ANY    /users/activate/{token}
 user_register                          POST       ANY      ANY    /users/register
 _preview_error                         ANY        ANY      ANY    /_error/{code}.{_format}
 _wdt                                   ANY        ANY      ANY    /_wdt/{token}
 _profiler_home                         ANY        ANY      ANY    /_profiler/
 _profiler_search                       ANY        ANY      ANY    /_profiler/search
 _profiler_search_bar                   ANY        ANY      ANY    /_profiler/search_bar
 _profiler_phpinfo                      ANY        ANY      ANY    /_profiler/phpinfo
 _profiler_xdebug                       ANY        ANY      ANY    /_profiler/xdebug
 _profiler_font                         ANY        ANY      ANY    /_profiler/font/{fontName}.woff2
 _profiler_search_results               ANY        ANY      ANY    /_profiler/{token}/search/results
 _profiler_open_file                    ANY        ANY      ANY    /_profiler/open
 _profiler                              ANY        ANY      ANY    /_profiler/{token}
 _profiler_router                       ANY        ANY      ANY    /_profiler/{token}/router
 _profiler_exception                    ANY        ANY      ANY    /_profiler/{token}/exception
 _profiler_exception_css                ANY        ANY      ANY    /_profiler/{token}/exception.css
 user_activat                           GET        ANY      ANY    /users/activat/{token}
-------------------------------------- ---------- -------- ------ -----------------------------------
```
I wonder where the last route came from...

And the log:
```
php-1       | 2024/08/02 10:27:51.982	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "40966", "client_ip": "172.19.0.1", "proto": "HTTP/1.1", "method": "GET", "host": "localhost", "uri": "/_next/webpack-hmr", "headers": {"Sec-Websocket-Extensions": ["permessage-deflate"], "Sec-Gpc": ["1"], "Connection": ["keep-alive, Upgrade"], "Sec-Fetch-Mode": ["websocket"], "Pragma": ["no-cache"], "Sec-Fetch-Dest": ["empty"], "Origin": ["https://localhost"], "Sec-Websocket-Key": ["vcKtZayCoNOlxEiUxCUHJw=="], "Sec-Fetch-Site": ["same-origin"], "Cache-Control": ["no-cache"], "Upgrade": ["websocket"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Accept": ["*/*"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Sec-Websocket-Version": ["13"], "Dnt": ["1"], "Cookie": ["REDACTED"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "http/1.1", "server_name": "localhost"}}, "bytes_read": 3693, "user_id": "", "duration": 261.793211712, "size": 135, "status": 101, "resp_headers": {"Server": ["Caddy"], "Alt-Svc": ["h3=\":443\"; ma=2592000"], "Upgrade": ["websocket"], "Connection": ["Upgrade"], "Sec-Websocket-Accept": ["mkSRmh+F42wc3HU/CuG881dWkng="], "Permissions-Policy": ["browsing-topics=()"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""]}}
pwa-1       |  GET /users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae 404 in 4ms
php-1       | 2024/08/02 10:27:52.015	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae", "headers": {"Accept-Encoding": ["gzip, deflate, br, zstd"], "Sec-Gpc": ["1"], "Priority": ["u=0, i"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Alt-Used": ["localhost"], "Sec-Fetch-Site": ["same-site"], "Sec-Fetch-Mode": ["navigate"], "Sec-Fetch-User": ["?1"], "Accept": ["text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/png,image/svg+xml,*/*;q=0.8"], "Dnt": ["1"], "Cookie": ["REDACTED"], "Upgrade-Insecure-Requests": ["1"], "Sec-Fetch-Dest": ["document"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.007252818, "size": 888, "status": 404, "resp_headers": {"Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""], "Etag": ["\"r8cbdmi3421kv\""], "Content-Type": ["text/html; charset=utf-8"], "Cache-Control": ["no-store, must-revalidate"], "Permissions-Policy": ["browsing-topics=()"], "X-Powered-By": ["Next.js"], "Server": ["Caddy"], "Content-Encoding": ["gzip"], "Vary": ["Accept-Encoding"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"]}}
php-1       | 2024/08/02 10:27:52.068	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/development/_buildManifest.js", "headers": {"Accept-Encoding": ["gzip, deflate, br, zstd"], "Sec-Gpc": ["1"], "Sec-Fetch-Dest": ["script"], "Accept": ["*/*"], "Dnt": ["1"], "Cookie": ["REDACTED"], "Sec-Fetch-Site": ["same-origin"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Alt-Used": ["localhost"], "Sec-Fetch-Mode": ["no-cors"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.004969892, "size": 296, "status": 200, "resp_headers": {"Cache-Control": ["no-store, must-revalidate"], "Last-Modified": ["Fri, 02 Aug 2024 10:21:48 GMT"], "Server": ["Caddy"], "Accept-Ranges": ["bytes"], "Etag": ["W/\"128-191129c2307\""], "Content-Length": ["296"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""], "Content-Type": ["application/javascript; charset=UTF-8"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"], "Vary": ["Accept-Encoding"], "Permissions-Policy": ["browsing-topics=()"]}}
php-1       | 2024/08/02 10:27:52.070	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/chunks/webpack.js", "headers": {"User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Sec-Gpc": ["1"], "Alt-Used": ["localhost"], "Accept": ["*/*"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Sec-Fetch-Dest": ["script"], "Sec-Fetch-Site": ["same-origin"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"], "Sec-Fetch-Mode": ["no-cors"], "Dnt": ["1"], "Cookie": ["REDACTED"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.006717874, "size": 9100, "status": 200, "resp_headers": {"Date": ["Fri, 02 Aug 2024 10:27:52 GMT"], "Accept-Ranges": ["bytes"], "Content-Type": ["application/javascript; charset=UTF-8"], "Vary": ["Accept-Encoding"], "Cache-Control": ["no-store, must-revalidate"], "Permissions-Policy": ["browsing-topics=()"], "Server": ["Caddy"], "Etag": ["W/\"ba8b-191129c220d\""], "Content-Encoding": ["gzip"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""], "Last-Modified": ["Fri, 02 Aug 2024 10:21:47 GMT"]}}
php-1       | 2024/08/02 10:27:52.071	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/development/_ssgManifest.js", "headers": {"Sec-Fetch-Mode": ["no-cors"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Sec-Gpc": ["1"], "Cookie": ["REDACTED"], "Sec-Fetch-Dest": ["script"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Alt-Used": ["localhost"], "Accept": ["*/*"], "Dnt": ["1"], "Sec-Fetch-Site": ["same-origin"], "Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.003705227, "size": 76, "status": 200, "resp_headers": {"Content-Type": ["application/javascript; charset=UTF-8"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"], "Accept-Ranges": ["bytes"], "Content-Length": ["76"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""], "Server": ["Caddy"], "Vary": ["Accept-Encoding"], "Last-Modified": ["Fri, 02 Aug 2024 10:21:48 GMT"], "Etag": ["W/\"4c-191129c2307\""], "Permissions-Policy": ["browsing-topics=()"], "Cache-Control": ["no-store, must-revalidate"]}}
php-1       | 2024/08/02 10:27:52.071	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/chunks/pages/_error.js", "headers": {"Cookie": ["REDACTED"], "Sec-Fetch-Site": ["same-origin"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Alt-Used": ["localhost"], "Sec-Fetch-Mode": ["no-cors"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Sec-Fetch-Dest": ["script"], "Accept": ["*/*"], "Dnt": ["1"], "Sec-Gpc": ["1"], "Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.007932577, "size": 1586, "status": 200, "resp_headers": {"Last-Modified": ["Fri, 02 Aug 2024 09:47:14 GMT"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"], "Cache-Control": ["no-store, must-revalidate"], "Accept-Ranges": ["bytes"], "Etag": ["W/\"104a-191127c7d27\""], "Content-Type": ["application/javascript; charset=UTF-8"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""], "Server": ["Caddy"], "Vary": ["Accept-Encoding"], "Permissions-Policy": ["browsing-topics=()"], "Content-Encoding": ["gzip"]}}
php-1       | 2024/08/02 10:27:52.073	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/chunks/react-refresh.js", "headers": {"Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Dnt": ["1"], "Sec-Gpc": ["1"], "Sec-Fetch-Dest": ["script"], "Sec-Fetch-Mode": ["no-cors"], "Accept": ["*/*"], "Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"], "Alt-Used": ["localhost"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Cookie": ["REDACTED"], "Sec-Fetch-Site": ["same-origin"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.00593892, "size": 25434, "status": 200, "resp_headers": {"Server": ["Caddy"], "Cache-Control": ["no-store, must-revalidate"], "Last-Modified": ["Fri, 02 Aug 2024 09:47:14 GMT"], "Vary": ["Accept-Encoding"], "Permissions-Policy": ["browsing-topics=()"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""], "Accept-Ranges": ["bytes"], "Content-Type": ["application/javascript; charset=UTF-8"], "Etag": ["W/\"1418d-191127c7d27\""], "Content-Encoding": ["gzip"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"]}}
php-1       | 2024/08/02 10:27:52.089	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/chunks/pages/_app.js", "headers": {"Accept": ["*/*"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Sec-Fetch-Dest": ["script"], "Sec-Fetch-Mode": ["no-cors"], "Dnt": ["1"], "Sec-Gpc": ["1"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Alt-Used": ["localhost"], "Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"], "Cookie": ["REDACTED"], "Sec-Fetch-Site": ["same-origin"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.025883476, "size": 162738, "status": 200, "resp_headers": {"Last-Modified": ["Fri, 02 Aug 2024 10:21:47 GMT"], "Etag": ["W/\"b1555-191129c2209\""], "Content-Type": ["application/javascript; charset=UTF-8"], "Cache-Control": ["no-store, must-revalidate"], "Permissions-Policy": ["browsing-topics=()"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""], "Server": ["Caddy"], "Accept-Ranges": ["bytes"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"], "Vary": ["Accept-Encoding"], "Content-Encoding": ["gzip"]}}
php-1       | 2024/08/02 10:27:52.195	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/chunks/main.js", "headers": {"Sec-Gpc": ["1"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Alt-Used": ["localhost"], "Cookie": ["REDACTED"], "Sec-Fetch-Dest": ["script"], "Sec-Fetch-Mode": ["no-cors"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"], "Sec-Fetch-Site": ["same-origin"], "Accept": ["*/*"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Dnt": ["1"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.132199634, "size": 1132670, "status": 200, "resp_headers": {"Server": ["Caddy"], "Cache-Control": ["no-store, must-revalidate"], "Last-Modified": ["Fri, 02 Aug 2024 09:47:14 GMT"], "Content-Encoding": ["gzip"], "Accept-Ranges": ["bytes"], "Etag": ["W/\"4e7b32-191127c7d27\""], "Permissions-Policy": ["browsing-topics=()"], "Content-Type": ["application/javascript; charset=UTF-8"], "Vary": ["Accept-Encoding"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""]}}
php-1       | 2024/08/02 10:27:52.302	INFO	http.log.access.log0	handled request	{"request": {"remote_ip": "172.19.0.1", "remote_port": "55727", "client_ip": "172.19.0.1", "proto": "HTTP/3.0", "method": "GET", "host": "localhost", "uri": "/_next/static/development/_devMiddlewareManifest.json", "headers": {"Referer": ["https://localhost/users/activate/f5a5263b06527eddce62124a9dc267c6fcb7cfb480f6535413429111d67d77ae"], "Dnt": ["1"], "Sec-Fetch-Dest": ["empty"], "User-Agent": ["Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0"], "Accept": ["*/*"], "Priority": ["u=4"], "Accept-Encoding": ["gzip, deflate, br, zstd"], "Alt-Used": ["localhost"], "Cookie": ["REDACTED"], "Sec-Fetch-Mode": ["cors"], "Sec-Fetch-Site": ["same-origin"], "Accept-Language": ["fr-FR,fr;q=0.8,en-US;q=0.5,en;q=0.3"], "Sec-Gpc": ["1"]}, "tls": {"resumed": true, "version": 772, "cipher_suite": 4865, "proto": "h3", "server_name": "localhost"}}, "bytes_read": 0, "user_id": "", "duration": 0.001036944, "size": 2, "status": 200, "resp_headers": {"Server": ["Caddy"], "Content-Type": ["application/json; charset=utf-8"], "Vary": ["Accept-Encoding"], "Date": ["Fri, 02 Aug 2024 10:27:52 GMT"], "Permissions-Policy": ["browsing-topics=()"], "Link": ["</docs.jsonld>; rel=\"http://www.w3.org/ns/hydra/core#apiDocumentation\", </.well-known/mercure>; rel=\"mercure\""]}}
```

## Introduction
This project is here just to discover how to use the new `_api_disable_swagger_provider` flag for [API Platform](https://api-platform.com).
It reproduce the typical use case :
- user registers through the API,
- the app sends a  mail to confirm the address with a activation link,
- the user opens the link with a browser.

The `_api_disable_swagger_provider` flag was developped to allow API Platform to respond with an HTML confirmation page.
Without it, the browser receives a 404 error page.

With it, well, it the same for me.

## How to reproduce
``` bash
git clone https://github.com/taophp/test_api_disable_swagger_provider.git
cd test_api_disable_swagger_provider
docker compose build --no-cache
docker compose up -d
curl -kX 'POST' \
  'https://localhost/users/register' \
  -H 'accept: application/ld+json' \
  -H 'Content-Type: application/json' \
  -d '{
  "email": "user@example.com",
  "password": "string"
}'
```
Then open your browser on http://localhost:8025 to see the confirmation email and click the activation link.

## Branches
The main branch is the initial state of the application : no action was taken to solve the issue.
Please, inspect branches to see what was tried (one try, one branch).
If you want to try something yourself and share with, make you own branch, push and get in touch (by [mail](mailto:mail@stephanemourey.fr) or on [Slack](https://symfony-devs.slack.com/archives/C39FKU9AL/p1722507207623139)).

## References
See :
- https://github.com/api-platform/core/issues/6384
- https://github.com/api-platform/core/pull/6449/commits/b303fe0b3b51be15b27f92e2a25f2c560f663446
- https://stackoverflow.com/questions/78817074/how-to-use-the-api-disable-swagger-provider-flag-inside-extraproperties-use-c
