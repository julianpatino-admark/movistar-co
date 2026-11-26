# Admark GoContact

Laravel Composer package for submitting lead payloads to the GoContact poll API.

## Install

```bash
composer install
php artisan migrate --force
```

The Laravel service provider is registered through Composer package
auto-discovery. It loads the monitor route and view, configures the log channel,
and registers the audit migration. The migration creates the attempts table
linked to the `forms` table supplied by `admark/tracking`.

The package configuration is loaded automatically. To copy it into the
application for customization, run `php artisan vendor:publish --tag=gocontact-config`.
The monitor view can optionally be published with
`php artisan vendor:publish --tag=gocontact-views`.

## Configure

Set these values in the application's environment. Keep credentials out of
source control:

```dotenv
GOCONTACT_BASE_URL=https://your-instance.gocontact.com
GOCONTACT_USERNAME=api-user@your-instance.gocontact.com
GOCONTACT_PASSWORD=secret
GOCONTACT_DATABASE_ID=44
GOCONTACT_ALTERNATE_DATABASE_ID=56
GOCONTACT_ALTERNATE_PERCENTAGE=40
```

The package requests a token with Basic Authentication at
`/poll/auth/token`, caches it using Laravel's configured cache store, and sends
the supplied lead payload using the access token in its authorization header to
`/poll/api/databases/{database}/contacts`.
When called by the tracking integration, the submitted `phone` field is mapped
to GoContact's `first_phone` field and the original `phone` key is omitted from
the API request.

For deployments with a different route, the base path, token path, and contacts
path can be overridden in `config/gocontact.php`. HTTPS is required and TLS
certificate verification remains enabled.

## Submit a lead

```php
use Admark\GoContact\GoContact;

$result = app(GoContact::class)->insert([
    'form_id' => $persistedForm->id,
    'contact' => 'Example Contact',
    'first_phone' => '3000000000',
    'email' => 'example@example.com',
    'direct_to_hopper' => true,
]);
```

`insert()` returns a normalized status array containing the HTTP status and
GoContact response. It accepts an optional second lead ID for compatibility
with landing tracking integrations; that value is not added to the API payload.
Transport, authentication, HTTP, and invalid-response failures throw
`GoContactException`. Logs include the event, stage, database, HTTP status,
duration, response content type, and provider request ID when available. For
HTTP errors, the response body is logged up to 4 KB so provider validation
messages can be diagnosed. Sensitive fields and exact values from the submitted
payload and authentication request are redacted; credentials, tokens, and the
lead payload are not logged.

The container-managed client assigns each persisted `forms.id` to a database
using a shared transactional counter. The alternate percentage must be an
integer from 0 to 100. Complete blocks of 100 assignments match that percentage
exactly; smaller blocks carry their fractional remainder forward. With 20%,
every fifth assignment goes to the alternate database. Defaults are primary 44,
alternate 56 and 40% (60% to primary, 40% to alternate). Both database IDs must be distinct and nonempty.

Assignments are committed before the HTTP call, survive failures and retries,
and are not recalculated after a configuration change. Changing the IDs or
percentage resets the remainder for new assignments. Queue insertion assigns
on the first submission attempt; it does not count waiting forms. Each form is
counted once, even if the phone number appears on another form. Run the routing
migration before rolling out the new client. No HTTP call is made if routing
cannot be persisted. Do not use an in-memory cache as a routing counter.

`insert()` requires the internal persisted form ID in `form_id` (or `id` for
model arrays). The second argument remains the tracking ID, not the form ID.
Routing fields are not sent to GoContact. `executeFlowState()` with an explicit
database ID is a low-level override that bypasses automatic assignment; landing
flows use `insert()`. A manually constructed client without a router retains
the legacy single-database behavior.

## Monitor failures

This application writes GoContact events to the dedicated `gocontact` daily log
channel at `storage/logs/gocontact-YYYY-MM-DD.log`. The default retention is 30
days and can be changed with `GOCONTACT_LOG_DAYS`; the channel and minimum log
level can be changed with `GOCONTACT_LOG_CHANNEL` and `GOCONTACT_LOG_LEVEL`.
Failures have the `gocontact.lead.failed` event and include the failure stage,
HTTP status when available, duration, provider request ID, and sanitized
diagnostics. Successful submissions are written as `gocontact.lead.submitted`.

On a server, follow today's events with:

```bash
tail -f storage/logs/gocontact-$(date +%F).log
```

To list failures from retained logs:

```bash
grep -h 'gocontact.lead.failed' storage/logs/gocontact-*.log
```

Log files must remain accessible only to authorized server operators. Do not
serve `storage/logs` as public web content.

The package stores each attempt in `gocontact_submissions`, linked to `forms.id`
and retaining the chosen database ID and GoContact's returned record ID when present. Queued submissions
use the original form ID as well. The private monitor is available at
`/monitor/gocontact`. The host application supplies Laravel session authentication,
the `viewGoContactMonitor` gate and a dedicated persistent rate limiter through
`gocontact.monitor.middleware`. Accounts require explicit `monitor_access`
permission; there is no public registration or Basic Auth fallback. Change the
monitor path with `GOCONTACT_MONITOR_PATH`; authentication routes remain under
`/monitor`. See the root README for provisioning and email configuration.
The monitor includes assignment totals and successful/failed attempt totals per
database, plus a database filter. Attempts are not unique leads: retries add
attempts but do not add assignments. Historical attempts retain a null database
ID because their original destination cannot be inferred reliably.

For a local/path Composer repository, ensure `packages/admark/gocontact` is
listed in the root `composer.json` repositories and require `admark/gocontact`.
After changing only package source, run `composer reinstall admark/gocontact`
so Composer refreshes
the package installation and Laravel's package discovery manifest.

## Tests

The package tests use Laravel's HTTP client fakes and never contact GoContact.
Run them from a Laravel project with:

```bash
vendor/bin/phpunit packages/admark/gocontact/tests
```
