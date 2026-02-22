- ~~Display in realtime result of award on page~~
- Fix navigation problem (Update EA ?)

docker compose exec php php html/bin/console doctrine:database:create
docker compose exec php php html/bin/console doctrine:migrations:migrate

docker compose exec php php html/bin/console make:entity

docker compose down -v
docker compose run --rm composer install


# Install PHP dependencies
docker compose run --rm composer install

# Build frontend assets (if using Node)
docker compose run --rm node npm install
docker compose run --rm node npm run dev

# Clear Symfony cache
docker compose exec php php bin/console cache:clear

docker compose exec php bash