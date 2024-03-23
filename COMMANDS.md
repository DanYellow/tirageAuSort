- npm run watch & symfony server:start
- clear cache : `php bin/console cache:clear --env=dev`
- start server : `symfony server:start`
- update db : `php bin/console doctrine:schema:update --force`
- php bin/console make:entity
- php bin/console make:admin:crud
- symfony console doctrine:database:drop --force
- symfony console doctrine:migrations:migrate
- php bin/console make:migration
- symfony console make:auth 

https://symfony.com/bundles/EasyAdminBundle/current/fields.html