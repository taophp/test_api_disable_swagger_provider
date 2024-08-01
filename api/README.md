# Test the new `_api_disable_swagger_provider` flag

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
