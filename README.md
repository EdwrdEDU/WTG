# WTG

## Database Requirements

- **Framework**: [Laravel(PHP)]
- **Laravel Version**: ^10.x (or the minimum version your project supports)
- **Database**: [SQLite]
- **PHP Version:* [>= 8.1]
- **Storage**: [Minimum 10GB (depending on data volume)]
- **Memory**: [Minimum 512MB RAM (1GB recommended for development)]

## Installation

1. **Clone the project:**
   ```bash
   git clone https://github.com/EdwrdEDU/WTG.git
   cd anonymous

2. **Install dependencies:**
   ```bash
   composer install

3. **Set up your environment:**
   ```bash
   copy .env.example .env
   php artisan key:generate


4. **Configure your .env file:**
   ```bash
   go to .env
   change DB_CONNECTION=sqlite

5. **Run migrations:**
   ```bash
   php artisan migrate

6. **Run seeder:**
   ```bash
   php artisan db:seed

7. **Run storage link:**
   ```bash
   php artisan storage:link

8. **Generate the application key:**
   ```bash
   php artisan key:generate

9. **Start the server:**
   ```bash
   php artisan serve

## Running the Project

1. **Start the database service**
  ```bash
  [database start command]
  ```

2. **Run the application**
  ```bash
  [application start command]
  ```

3. **Access the application**
  - Open your browser and navigate to `http://localhost:[port]`