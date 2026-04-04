# Wasmer Deployment Notes

This project can be deployed to Wasmer Edge in two phases:

1. Host the marketplace with the current mock payment flow.
2. Replace the mock flow with Safaricom Daraja sandbox integration.

## What changed in this repo

- Added `wasmer.toml` so Wasmer can run the Laravel app.
- Added `app.yaml.example` as the Wasmer Edge app configuration template.
- Added `.env.example` and `.env.wasmer.example` with safe placeholders.
- Added database migrations for `cache`, `cache_locks`, and `sessions`.

## Why these changes matter

Wasmer Edge app instances are stateless and ephemeral. This app previously relied on:

- local MySQL running on XAMPP
- file-based sessions
- file-based cache

For Wasmer, use:

- an external MySQL-compatible database
- `SESSION_DRIVER=database`
- `CACHE_DRIVER=database`
- a persistent Wasmer volume mounted at `/app/storage/app/public` if you want local media uploads to survive deploys and restarts

The Laravel config in this repo now accepts either `DB_DATABASE` or Wasmer's auto-provisioned `DB_NAME`. If `DB_DATABASE` is blank, the app will automatically use `DB_NAME`.

## First deployment checklist

1. Install the Wasmer CLI and sign in.
2. Create or choose a MySQL-compatible database.
3. Copy `app.yaml.example` to `app.yaml` and replace `owner` / `name`.
4. Fill the real values in `.env.wasmer.example`.
5. Add those values to Wasmer as app secrets.
6. Confirm the app is pinned to a region that supports both databases and volumes.
7. Run migrations against the production database.
8. Deploy with `wasmer deploy`.

## Suggested Wasmer secrets

At minimum:

- `APP_NAME`
- `APP_ENV=production`
- `APP_KEY`
- `APP_DEBUG=false`
- `APP_URL`
- `DB_CONNECTION=mysql`
- `DB_HOST`
- `DB_PORT`
- `DB_USERNAME`
- `DB_PASSWORD`
- `DB_DATABASE` only if you are not using Wasmer's auto-provisioned `DB_NAME`
- `CACHE_DRIVER=database`
- `SESSION_DRIVER=database`
- `SESSION_SECURE_COOKIE=true`
- `FILESYSTEM_DISK=public`
- `PUBLIC_DISK_ROOT` only if you mount media somewhere other than `/app/storage/app/public`
- `QUEUE_CONNECTION=sync`
- `PAYMENT_PROVIDER=mock`
- `PAYMENT_COMMISSION_RATE=10`
- `MAIL_MAILER`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION`
- `MAIL_FROM_ADDRESS`
- `MAIL_FROM_NAME`

## Commands

Generate a production app key locally:

```powershell
php artisan key:generate --show
```

Create Wasmer secrets from a file:

```powershell
wasmer app secrets create --from-file=.env.wasmer.example
```

Deploy:

```powershell
wasmer deploy
```

List the database Wasmer attached to the app:

```powershell
wasmer app database list --with-password
```

## Important limitation for phase 1

User uploads currently use the local `public` disk. This repo is now prepared to keep those files on a Wasmer volume mounted at `/app/storage/app/public`, but that only stays durable if the deployed app keeps that volume attached in a region that supports volumes.

If you later outgrow local volume-backed media, the next step is moving uploads to object storage such as an S3-compatible bucket.

## Daraja comes after hosting

Once the app is live on Wasmer and reachable on a stable HTTPS URL, the next payment phase should be:

1. switch `PAYMENT_PROVIDER` from `mock` to Daraja
2. implement STK Push against the sandbox
3. make the callback/webhook flow update real order statuses
4. test end to end in sandbox
5. only then start the live onboarding for PayBill or Till
