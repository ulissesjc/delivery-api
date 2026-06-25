#!/bin/sh
set -e

# Copia .env se não existir
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Instala dependências
composer install --no-interaction --prefer-dist

# Gera APP_KEY se necessário
if ! grep -q "^APP_KEY=.\+" /var/www/html/.env; then
    php artisan key:generate --no-interaction
fi

# Aguarda o banco
until php artisan db:show > /dev/null 2>&1
do
    echo "Aguardando banco..."
    sleep 2
done

# Executa migrations
php artisan migrate --force --no-interaction

# Ajusta permissões
chown -R www-data:www-data storage bootstrap/cache

# Inicia Apache
exec apache2-foreground
