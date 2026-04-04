# Wasmer Pre-Deploy Checklist

Use this checklist before every Wasmer release.

## 1. Workspace Hygiene

- Confirm the deploy branch only contains intentional code changes.
- Remove tracked runtime artifacts from source control:
  - `storage/framework/*`
  - `storage/logs/*`
  - `public/storage/*`
- Keep only placeholder files such as `.gitignore`.
- Verify `.env` is not staged.

## 2. Wasmer Environment Preparation

- Copy `app.yaml.example` to `app.yaml` and set the Wasmer `owner` and app `name`.
- Confirm `app.yaml` includes both a MySQL database capability and a mounted media volume.
- Confirm the selected Wasmer region supports both databases and volumes.
- Use `.env.wasmer.example` as the source of truth for Wasmer secrets.
- Set a real `APP_KEY`.
- Set the public `APP_URL`.
- Set `APP_DEBUG=false`.
- Provide real mail credentials.
- Provide M-Pesa credentials and callback URL when leaving mock payments behind.
- Confirm the MySQL-compatible database is reachable from Wasmer.

## 3. Dependency and Packaging Checks

- Confirm the in-repo payment package exists at `packages/mpesa-daraja-plugin`.
- Run `composer install --no-dev --prefer-dist --optimize-autoloader`.
- Confirm Composer resolves `landscapehub/mpesa-daraja-plugin` from the repo, not a local sibling directory.

## 4. Database Safety

- Run the full migration chain against a fresh MySQL database before release.
- Review production migration status before release.
- Take a database backup before applying production migrations.
- Run migrations as an explicit Wasmer release step, not as part of web process boot.

## 5. Security and Access Control

- Verify only the booking owner, assigned vendor, or admin can open booking detail pages.
- Verify logout only works over `POST`.
- Verify review verification is computed on the server, not from form input.
- Verify payment secrets are managed through Wasmer secrets, not admin-side `.env` writes.

## 6. Payments

- For the first Wasmer smoke deployment, keep `PAYMENT_PROVIDER=mock`.
- When switching to live payment prep, confirm the Wasmer HTTPS callback URL is externally reachable.
- Test one successful payment callback in staging.
- Test one failed payment flow in staging.

## 7. Smoke Tests

- Homepage loads.
- Product listing loads.
- Service listing loads.
- Login page loads.
- Authenticated customer can create a cart and reach the payment page.
- Authenticated customer can view only their own orders and bookings.
- Vendor can view only assigned booking records.
- Admin dashboard loads for admins and redirects guests to login.

## 8. Wasmer Runtime Checks

- Run `php artisan config:cache`.
- Run `php artisan view:cache`.
- Run `php artisan route:cache`.
- Confirm the Wasmer media volume is mounted at `/app/storage/app/public`, or set `PUBLIC_DISK_ROOT` to the mounted path.
- Confirm upload persistence strategy before relying on media in production.

## 9. Post-Deploy Validation

- Load the Wasmer app over HTTPS.
- Confirm login works.
- Confirm checkout works.
- Confirm payment callbacks update orders.
- Confirm customer and vendor notification emails send or queue correctly.
- Confirm admin analytics show expected totals.

## Manual Follow-Up Items

- Clean the tracked runtime files from Git with `git rm --cached` in a dedicated cleanup commit.
- Backfill the local development database migration history so `migrate:status` matches reality on the old XAMPP database too.
- Add broader automated feature tests for auth, checkout, and booking visibility.
