# Library Management System

A Laravel-based library management system designed around the core workflows of a library: book cataloguing, membership management, borrowing, returns, overdue tracking, and fines.

The project focuses on building a clear domain model and keeping core library rules inside application services rather than relying only on controllers.

## Overview

The system currently provides two main areas:

* **Public library interface** for browsing books and managing authenticated borrowing workflows.
* **Admin interface** for managing books, members, and borrowing operations.

The current version is intentionally focused on the **core library domain**. Institution-specific features such as student records, academic departments, or school-specific borrowing rules are not part of this baseline.

## Core Features

### Authentication

* User registration and login
* Session-based authentication
* Role-based admin access
* Logout
* User profile

### Book Management

Administrators can:

* Create books
* Edit books
* View book details
* Delete books
* Manage authors
* Assign categories
* Assign publishers
* Track total copies
* Track available copies
* Store ISBN and shelf location
* Search and filter books

### Membership

The system separates a login account from library membership.

Users can submit a membership application, and administrators can:

* Review pending applications
* Approve applications by creating a library member
* Reject applications
* Create members manually
* Update member information
* View member borrowing history
* Track membership status
* Track outstanding fines

### Borrowing

The borrowing workflow is implemented as a domain service with transactional database operations.

The system checks that:

* The member is active
* The membership has not expired
* A copy of the book is available
* The member does not already have the same book on loan

When a book is borrowed:

* Available quantity is decreased
* A borrowing record is created
* A due date is calculated from the library configuration

### Returns and Fines

When a book is returned:

* The borrowing is marked as returned
* The return date is recorded
* The book's available quantity is restored
* Overdue days are calculated
* A fine is calculated according to the configured daily rate
* The member's outstanding fines are updated

### Borrowing Search and Filters

Administrators can search borrowing records by:

* Member name
* Member email
* Member number
* Book title
* ISBN

Borrowings can also be filtered by:

* Currently borrowed
* Overdue
* Returned

## Architecture

The project follows a conventional Laravel application structure with domain-specific logic extracted where appropriate.

A simplified flow for borrowing is:

```text
HTTP Request
     ↓
Controller
     ↓
BorrowingService
     ↓
Database Transaction
     ↓
Member + Book validation
     ↓
Borrowing record
     ↓
Stock update
```

The `BorrowingService` is responsible for the core borrowing and return rules, including database transactions and row locking where necessary.

This keeps important business rules out of the HTTP controllers.

## Domain Model

The current core domain includes:

```text
User
 └── Role

User
 └── Membership Application
        ↓
      Member
        ↓
    Borrowings
        ↓
       Book
        ├── Authors
        ├── Category
        └── Publisher
```

The project intentionally keeps the core domain generic so it can later be specialized for different types of libraries without introducing school- or university-specific fields into the core models.

## Technology Stack

* **PHP 8.3+**
* **Laravel 12**
* **MySQL**
* **Blade**
* **Tailwind CSS**
* **Eloquent ORM**
* **PHPUnit / Laravel Testing**
* **Git / GitHub**

## Project Structure

```text
app/
├── Http/
│   └── Controllers/
├── Models/
└── Services/

database/
├── factories/
├── migrations/
└── seeders/

resources/
└── views/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

## Getting Started

### Requirements

Make sure the following are installed:

* PHP 8.3 or later
* Composer
* MySQL
* Node.js and npm

### Installation

Clone the repository:

```bash
git clone https://github.com/mahmoodmohamad/library-management-system.git
cd library-management-system
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database connection in `.env`.

Run migrations:

```bash
php artisan migrate
```

Build frontend assets:

```bash
npm run build
```

Start the development server:

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## Configuration

Library borrowing rules are configurable through the application's library configuration.

Examples include:

* Loan period
* Fine per overdue day

This allows borrowing behavior to be changed without hardcoding these values inside the borrowing workflow.

## Testing

The project includes automated tests for important borrowing and return rules.

Examples include:

* Successful borrowing
* Borrowing when no copies are available
* Borrowing by a suspended member
* Borrowing with an expired membership
* Preventing duplicate active borrowing
* Returning a book on time
* Calculating overdue fines
* Restoring book availability after return

Run the test suite with:

```bash
php artisan test
```

## Current Scope

This repository represents the **core library management baseline**.

It is intentionally not tied to a specific institution type.

Possible future specialization could include:

* School libraries
* University libraries
* Public libraries

Institution-specific functionality can be added without making the core library domain dependent on one particular use case.

## Roadmap

The development version may explore additional capabilities such as:

* Authorization policies
* More comprehensive automated tests
* Advanced reporting
* Notifications
* Reservation workflows
* Barcode or QR-based circulation
* Physical copy tracking
* Institution-specific workflows

These features are intentionally kept outside the current core baseline.

## Project Status

The core borrowing, return, membership, book management, and administrative workflows are implemented.

The project is being developed incrementally with an emphasis on:

* Clear domain boundaries
* Transaction-safe borrowing operations
* Maintainable Laravel structure
* Automated testing of business rules
* Keeping the core model independent from institution-specific requirements
