# Library Management System
Laravel 12 · PHP 8.3 · MySQL · Blade · Tailwind (Vite)

## Features
- Public catalogue: search (title/ISBN/author), category + availability filters
- Membership applications (apply → admin review → member created)
- Borrow / return with fines (`config/library.php`), reservation queue
- Admin: books, members, borrowings, pending applications
- Roles + Policies (admin, librarian, member), email verification, password reset

## Setup
cp .env.example .env && php artisan key:generate
composer install && npm ci && npm run build
php artisan migrate --seed

## Scheduler
* * * * * php artisan schedule:run   (runs library:mark-overdue daily)

## Tests / CI
php artisan test · vendor/bin/pint --test (GitHub Actions: Pint, build, tests)

## Domain rules
Loan days / fine per day: config/library.php
Soft deletes on books & members; borrowing history is never cascaded away.