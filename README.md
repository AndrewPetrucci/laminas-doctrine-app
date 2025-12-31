# Laminas Doctrine Skill Tree Application

A modern PHP web application built with **Laminas** (formerly Zend Framework) and **Doctrine ORM** for visualizing and managing complex skill tree data.

## 🎯 Project Overview

This project renders interactive skill tree data from an external source, providing a dynamic visualization interface for viewing and managing skill node allocations. The application uses Laminas MVC architecture for robust, scalable backend development paired with Doctrine for advanced database operations.

## 🚀 Features

- **Skill Tree Visualization**: Dynamic rendering of skill tree structures with node positioning
- **Interactive Interface**: View and navigate complex skill hierarchies
- **Modular Architecture**: Clean separation of concerns using Laminas modules
- **Database Integration**: Doctrine ORM for data persistence and management
- **RESTful API**: Built-in API endpoints for data operations
- **Testing**: Comprehensive unit tests included

### Planned Features

- Group information integration for improved node positioning
- Dynamic viewport management ("viewing window") for large skill trees
- Edge rendering between connected nodes within viewport
- Responsive viewport panning and zooming
- Node allocation/deallocation functionality
- Visual asset support (icons, images)
- Improved naming conventions for UI components

## 📋 Prerequisites

- **PHP 8.1+**
- **Composer**
- **Docker** (optional, for containerized development)
- **MySQL/MariaDB** (via Docker or local installation)
- **Node.js** (optional, for asset compilation)

## 🛠️ Installation

### Using Docker (Recommended)

```bash
# Build and start containers
docker-compose up -d

# Install dependencies
docker-compose exec app composer install

# Generate local configuration
cp config/autoload/local.php.dist config/autoload/local.php
cp config/autoload/development.local.php.dist config/autoload/development.local.php

# Clear configuration cache
docker-compose exec app php bin/clear-config-cache.php
```

### Local Installation

```bash
# Install PHP dependencies
composer install

# Create configuration files
cp config/autoload/local.php.dist config/autoload/local.php
cp config/autoload/development.local.php.dist config/autoload/development.local.php

# Configure database connection in config/autoload/local.php

# Clear configuration cache
php bin/clear-config-cache.php
```

## 🏗️ Project Structure

```
├── bin/                          # Executable scripts
│   └── clear-config-cache.php   # Clear application cache
├── config/                       # Application configuration
│   ├── application.config.php   # Main application config
│   ├── container.php            # Dependency injection container
│   ├── modules.config.php       # Module configuration
│   └── autoload/                # Auto-loaded configuration files
├── data/                         # Application data
│   ├── skilltree.json           # Skill tree data source
│   └── cache/                   # Runtime cache directory
├── module/
│   └── Application/             # Main application module
│       ├── config/              # Module-specific configuration
│       ├── src/
│       │   ├── Controller/      # Application controllers
│       │   └── Module.php       # Module bootstrap
│       ├── view/                # View templates (Phtml)
│       └── test/                # Unit tests
├── public/                       # Web-accessible directory
│   ├── index.php               # Application entry point
│   ├── css/                    # Stylesheets (Bootstrap + Custom)
│   ├── js/                     # JavaScript files (Bootstrap)
│   └── img/                    # Static images
├── composer.json               # Composer dependencies
├── docker-compose.yml          # Docker Compose configuration
├── Dockerfile                  # Docker image definition
├── phpunit.xml.dist            # PHPUnit testing configuration
├── psalm.xml                   # Static analysis configuration
├── phpcs.xml                   # Code style configuration
└── renovate.json              # Dependency update automation

```

## 📦 Key Dependencies

- **laminas/laminas-mvc**: MVC framework foundation
- **doctrine/orm**: Object-relational mapping
- **doctrine/dbal**: Database abstraction layer
- **laminas/laminas-router**: Request routing
- **laminas/laminas-view**: Template rendering
- **phpunit/phpunit**: Testing framework
- **psalm/psalm**: Static analysis tool
- **slevomat/coding-standard**: PHP code standards

## 🎮 Controllers

### Application Module

- **IndexController**: Homepage and main entry point
- **SkillTreeController**: Skill tree visualization and management

## 📄 Configuration

### Environment Configuration

Create local configuration files:

```bash
cp config/autoload/local.php.dist config/autoload/local.php
cp config/autoload/development.local.php.dist config/autoload/development.local.php
```

### Database Connection

Configure your database connection in `config/autoload/local.php`:

```php
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => 'password',
                    'dbname'   => 'skilltree',
                ]
            ]
        ]
    ]
];
```

## 🧪 Testing

Run the test suite using PHPUnit:

```bash
# Run all tests
composer test

# Run tests for specific module
vendor/bin/phpunit module/Application/test/

# Run with coverage report
vendor/bin/phpunit --coverage-html=coverage/
```

## 🔍 Code Quality

### Static Analysis

Run Psalm for type checking:

```bash
vendor/bin/psalm
```

### Code Style

Check PHP code standards:

```bash
vendor/bin/phpcs
```

Auto-fix code style issues:

```bash
vendor/bin/phpcbf
```

## 🚀 Running the Application

### Development Server

```bash
# Using PHP's built-in server
php -S localhost:8080 -t public

# Or with Docker
docker-compose up
# App will be available at http://localhost:8080
```

### Docker

```bash
# Build and run
docker-compose up --build

# Attach to application container
docker-compose exec app bash

# View logs
docker-compose logs -f app
```

## 📊 Data Source

The application fetches skill tree data from:
- **Remote**: https://raw.githubusercontent.com/grindinggear/skilltree-export/refs/heads/master/data.json
- **Local**: `data/skilltree.json`

## 🔐 Security Considerations

- Use environment variables for sensitive configuration
- Keep dependencies updated (Renovate is configured)
- Run security audits: `composer audit`
- Enable HTTPS in production
- Validate and sanitize all user input

## 📝 Development Workflow

1. Create a feature branch: `git checkout -b feature/your-feature`
2. Make your changes and write tests
3. Run code quality checks
4. Commit with descriptive messages
5. Push and create a pull request
6. Ensure all checks pass before merging

## 🤝 Contributing

Contributions are welcome! Please:

1. Follow the existing code style (PHPCS configuration)
2. Add tests for new features
3. Update documentation as needed
4. Run static analysis before submitting

## 📖 Resources

- [Laminas Documentation](https://docs.laminas.dev/)
- [Doctrine Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/)
- [PHP Best Practices](https://www.php-fig.org/)

## 📜 License

This project is licensed under the BSD 3-Clause License. See LICENSE file for details.

---

## Original Project Notes

This is a sample project meant to render data from https://raw.githubusercontent.com/grindinggear/skilltree-export/refs/heads/master/data.json

todos:
 - incorporate group information to determine node positioning
 - determine "viewing window" cordinates
 - render each group within cordinates as well as attached edges within the "viewing window".
 - re-render on "viewing window" move or resize
 - come up with better name than "viewing window"
 - add images?
 - allow allocation/ unallocation of nodes

<img width="956" height="474" alt="image" src="https://github.com/user-attachments/assets/1585035d-bac4-4f58-81cf-c9b50855b6eb" />
