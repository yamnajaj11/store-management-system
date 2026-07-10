# Store Management System

A complete Store Management System developed using Laravel to manage products, customers, suppliers, sales, purchases, and payments.

## About The Project

Store Management System is a web-based application designed to help businesses manage their daily store operations efficiently through an organized dashboard.

The system provides tools for managing inventory, sales transactions, purchasing processes, customer and supplier information, and financial operations.

---

## Features

### Dashboard
- Overview of store activities.
- Quick access to main system sections.
- Display important information and statistics.

### Product Management
- Add, edit, and delete products.
- Manage product information.
- Track available products.

### Customer Management
- Add and manage customers.
- Store customer information.
- Track customer transactions.

### Supplier Management
- Manage suppliers.
- Store supplier information.
- Manage supplier transactions.

### Sales Management
- Create and manage sales invoices.
- Track sales operations.
- Manage customer purchases.

### Purchase Management
- Manage purchase invoices.
- Track purchased products.
- Manage supplier transactions.

### Payment Management
- Track payments.
- Manage financial transactions.

### System Features
- User authentication.
- Organized dashboard.
- Data validation.
- Clean and maintainable code structure.

---

## Technologies Used

### Backend
- PHP
- Laravel Framework

### Frontend
- Blade Template Engine
- HTML
- CSS
- Bootstrap
- JavaScript

### Database
- MySQL
- Laravel Migrations
- Database Relationships

### Development Tools
- Git & GitHub
- Composer
- Visual Studio Code

---

## Project Architecture

The project was developed using:

- **MVC Architecture**
  - Model: Handles database interaction.
  - View: Responsible for displaying data.
  - Controller: Handles application logic.

- **Repository Pattern**
  - Separates database operations from business logic.
  - Improves code organization and maintainability.

- **Eloquent ORM**
  - Provides an easy way to interact with the database using Laravel Models.

---

## Database

The database structure was designed using Laravel Migrations.

The project includes relationships between different entities such as:

- Products
- Customers
- Suppliers
- Sales
- Purchases
- Payments

---

## Screenshots

### Dashboard

![Dashboard](screenshots/dashboard.png)

### Products Management

![Products](screenshots/products.png)

### Customers Management

![Customers](screenshots/customers.png)

### Suppliers Management

![Suppliers](screenshots/suppliers.png)

### Purchases Management

![Purchases](screenshots/purchases.png)

---

## Installation

Clone the repository:

```bash
git clone https://github.com/yamnajaj11/store-management-system.git


cd store-management-system
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve