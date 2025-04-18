#!/bin/bash
# setup.sh

# Create necessary directories
mkdir -p nginx/conf.d
mkdir -p php
mkdir -p mysql

# Copy configuration files
echo "Copying configuration files..."
echo '
upload_max_filesize=40M
post_max_size=40M
max_execution_time=600
memory_limit=512M' > php/local.ini

echo '
[mysqld]
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

[client]
default-character-set=utf8mb4' > mysql/my.cnf

echo 'server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;

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
        fastcgi_pass app:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}' > nginx/conf.d/app.conf

# Make the setup script executable
chmod +x setup.sh

echo "Setup completed. You can now run 'docker-compose up -d' to start the containers."