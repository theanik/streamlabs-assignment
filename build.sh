echo "Setup staring..."
cp .env.example .env
sudo chmod -R 777 storage
# remove lock files
rm -rf package-lock.json
rm -rf composer.lock

# docker up
docker-compose up -d

## running docker command
# run composer install
docker exec streamlabs-application composer install
# run application key generate
docker exec streamlabs-application php artisan key:gen
# npm install
docker exec streamlabs-application npm install
docker exec streamlabs-application npm audit fix
docker exec streamlabs-application npm run dev
# run required
docker exec streamlabs-application php artisan migrate --seed
docker exec streamlabs-application php artisan passport:install

# run unit test
docker exec streamlabs-application php artisan test

echo "Setup Done!!!"


