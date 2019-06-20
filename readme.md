git clone https://github.com/esgras/bank_app .  
docker-compose up -d  
docker-compose exec webserver1 composer install  
docker-compose exec webserver1 chown -R www-data:www-data /var/www/storage  
cp .env.example .env  
docker-compose exec webserver1 ./artisan key:generate  
docker-compose exec webserver1 ./artisan migrate