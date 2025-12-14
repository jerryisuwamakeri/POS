# POS System

A modern, feature-rich Point of Sale (POS) system built with Laravel, designed for multi-branch retail operations with comprehensive inventory management, sales tracking, and reporting capabilities.

## Features

### Core Functionality
- **Multi-Branch Support** - Manage multiple business locations from a single system
- **Role-Based Access Control** - Super Admin, Admin, Sales, and Accounting roles with granular permissions
- **Real-time Inventory Management** - Track stock levels, low stock alerts, and inventory movements
- **POS Terminal** - Fast, intuitive point-of-sale interface for quick transactions
- **Customer Management** - Track customer information and purchase history
- **Product Management** - Comprehensive product catalog with categories, variants, and pricing
- **Order Management** - Complete order lifecycle tracking and management
- **Receipt Generation** - Automatic PDF receipt generation with business branding
- **Expense Tracking** - Record and categorize business expenses
- **Shift Management** - Clock in/out system with shift tracking
- **Comprehensive Reporting** - Sales reports, inventory reports, and accounting summaries
- **Data Export** - Export reports to Excel/CSV formats

### User Roles & Permissions

#### Super Admin
- Full system access
- Manage all businesses and branches
- User and role management
- System-wide settings and configurations

#### Admin
- Branch-level management
- Product and inventory management
- User management within branch
- Sales and accounting oversight
- Branch deletion rights

#### Sales
- POS terminal access
- Customer management
- Order creation
- Shift clock in/out

#### Accounting
- View-only access to financial data
- Expense management
- Report generation and exports

## 🛠 Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates + Tailwind CSS + Vite
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Sanctum
- **Permissions**: Spatie Laravel Permission
- **PDF Generation**: DomPDF (with Laravel wrapper)
- **Excel Export**: PhpSpreadsheet (via Laravel Excel)

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js >= 18.x and NPM
- MySQL >= 5.7 or MariaDB >= 10.3
- Required PHP Extensions:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - Fileinfo
  - GD (for image processing and PDF generation)
  - ZIP

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd pos
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
Edit your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run migrations and seed the database:
```bash
# Run migrations
php artisan migrate

# Seed with roles, permissions, and demo data
php artisan db:seed
```

### 5. Build Frontend Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

### 6. Storage Setup
```bash
# Create symbolic link for public storage
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### 7. Start the Development Server
```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

## Database Structure

### Core Tables
- `users` - User accounts with branch assignments
- `businesses` - Business/organization records
- `branches` - Branch locations with geo-coordinates
- `products` - Product catalog
- `product_variants` - Product variations (size, color, etc.)
- `categories` - Product categories
- `inventory` - Stock levels per branch
- `orders` - Sales orders/transactions
- `order_items` - Line items for orders
- `payments` - Payment records
- `customers` - Customer information
- `expenses` - Business expense records
- `shifts` - Employee shift records
- `audit_logs` - System audit trail
- `exports` - Export job tracking

## Customization

### Branding
- Update logo: Place your logo at `public/build/assets/logo.png`
- Update colors: Modify Tailwind config in `tailwind.config.js`
- Update business info: Edit seeder files in `database/seeders/`

### Adding New Branches
Run the seeder or manually create via the admin panel:
```bash
php artisan db:seed --class=KanoBranchSeeder
```

### Currency Settings
The system uses kobo (100 kobo = 1 Naira) internally. Helper functions:
- `to_kobo($amount)` - Convert Naira to kobo
- `from_kobo($amount)` - Convert kobo to Naira
- `format_currency($amount)` - Format as currency string

## Common Commands

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# View routes
php artisan route:list

# Create new user
php artisan tinker
>>> User::create([...])

# Run migrations
php artisan migrate
php artisan migrate:fresh --seed  # Fresh start with seed data

# Generate policy
php artisan make:policy BranchPolicy --model=Branch
```

## Mobile Responsiveness

The system is fully responsive with touch-optimized interfaces for mobile devices:
- Mobile-friendly POS terminal
- Swipe navigation on mobile
- Touch-optimized buttons and forms
- Responsive tables and charts

## Security Features

- CSRF protection on all forms
- Password hashing with bcrypt
- Role-based authorization with policies
- Input validation and sanitization
- SQL injection protection via Eloquent ORM
- XSS protection via Blade escaping
- Audit logging for sensitive operations

## Reports Available

- **Sales Reports**: Daily, weekly, monthly sales summaries
- **Inventory Reports**: Stock levels, low stock alerts
- **Expense Reports**: Categorized expense tracking
- **User Activity**: Shift logs and audit trails
- **Customer Reports**: Purchase history and analytics

## Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate secure `APP_KEY`
- [ ] Configure production database
- [ ] Set up proper file permissions
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up SSL certificate (HTTPS)
- [ ] Configure queue worker for background jobs
- [ ] Set up scheduled tasks (cron)
- [ ] Configure backup strategy
- [ ] Set up monitoring and logging

### Recommended Web Server Configuration (Nginx)
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/pos/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## License

This project is proprietary software. All rights reserved.

## Support & Contact

For support, feature requests, or bug reports:
- Email: makerijerry.dev@gmail.com
- Documentation: [Link to docs]
- Issue Tracker: [Link to issues]

## Acknowledgments

Built with:
- [Laravel](https://laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [DomPDF](https://github.com/dompdf/dompdf)
- [Laravel Excel](https://laravel-excel.com)

---

**Version**: 1.0.0  
**Last Updated**: December 2025
