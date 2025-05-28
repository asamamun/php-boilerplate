# PHP Boilerplate

A lightweight, modern PHP boilerplate project featuring MVC architecture, PSR-4 autoloading, database integration, and a flexible routing system. Perfect for kickstarting your PHP web applications with best practices built-in.

## Features

- **MVC Architecture** - Clean separation of concerns with Model-View-Controller pattern
- **PSR-4 Autoloading** - Modern PHP autoloading standard for better code organization  
- **Database Integration** - Built-in database connectivity and ORM capabilities
- **Routing System** - Flexible URL routing with clean URLs
- **Environment Configuration** - Environment-based configuration management
- **Composer Support** - Dependency management with Composer
- **Development Server** - Built-in development server for quick testing

## Requirements

- PHP 7.4 or higher
- Composer
- MySQL/MariaDB (or your preferred database)
- Web server (Apache/Nginx) or use built-in PHP server

## Quick Start

### 1. Installation

Clone the repository:
```bash
git clone https://github.com/asamamun/php-boilerplate.git
cd php-boilerplate
```

Install dependencies:
```bash
composer install
```

### 2. Configuration

Copy the environment configuration file:
```bash
cp .env.example .env
```

Edit `.env` file and configure your database connection:
```env
DB_HOST=localhost
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
```

### 3. Database Setup

Create your database and run any necessary migrations or setup scripts.

### 4. Start Development Server

Launch the built-in development server:
```bash
composer serve
```

Your application will be available at `http://localhost:8000` (or the port specified in your configuration).

## Project Structure

```
php-boilerplate/
├── app/
│   ├── Controllers/     # Application controllers
│   ├── Models/         # Data models
│   ├── Views/          # View templates
│   └── ...
├── public/             # Public web directory
│   ├── index.php      # Application entry point
│   └── .htaccess      # Apache rewrite rules
├── config/            # Configuration files
├── routes/            # Route definitions
├── vendor/            # Composer dependencies
├── .env.example       # Environment configuration template
├── composer.json      # Composer configuration
├── Router.php         # Main routing handler
└── README.md
```

## Usage

### Creating Controllers

Controllers should extend the base controller class and follow PSR-4 naming conventions:

```php
<?php
namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->view('home.index', ['title' => 'Welcome']);
    }
}
```

### Defining Routes

Routes are defined in the routing configuration. The routing system supports:
- GET, POST, PUT, DELETE methods
- Route parameters
- Middleware support
- Named routes

### Working with Models

Models handle data logic and database interactions:

```php
<?php
namespace App\Models;

class User extends BaseModel
{
    protected $table = 'users';
    
    public function findByEmail($email)
    {
        // Your database query logic
    }
}
```

### Views and Templates

Views are stored in the `app/Views` directory and can be rendered from controllers:

```php
return $this->view('template_name', $data);
```

## Configuration

### Environment Variables

All environment-specific configurations should be stored in the `.env` file:

- Database connections
- API keys
- Debug settings
- Application URLs

### Router Configuration

The `Router.php` file contains the main routing logic. Customize it according to your application's needs.

### Apache Configuration

The included `.htaccess` file provides:
- Clean URL rewriting
- Security headers
- Cache control
- Error handling

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Development Guidelines

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add comments for complex logic
- Keep controllers thin and models fat
- Use dependency injection where appropriate

## Security Considerations

- Always validate and sanitize user input
- Use prepared statements for database queries
- Keep `.env` file out of version control
- Regularly update dependencies
- Use HTTPS in production

## License

This project is open source. Please check the LICENSE file for details.

## Support

If you encounter any issues or have questions:

1. Check the existing issues on GitHub
2. Create a new issue with detailed information
3. Provide code examples and error messages

## Roadmap

- [ ] Add unit testing framework
- [ ] Implement middleware system
- [ ] Add CLI command support
- [ ] Database migration system
- [ ] API authentication
- [ ] Caching layer

---