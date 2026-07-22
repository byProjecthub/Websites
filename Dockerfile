FROM php:8.3-cli

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Set working directory
WORKDIR /app

# Copy all project files
COPY . /app/

# Expose port (Railway sets $PORT)
EXPOSE 8080

# Start PHP built-in server
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t . router.php"]
