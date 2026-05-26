# --- Conteneurs ---

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose down
	docker compose up -d

logs:
	docker compose logs -f app

ssh:
	docker compose exec app sh

# --- Symfony / cache / perms ---

cc:
	docker compose exec app php bin/console cache:clear

cc-fix:
	docker compose exec app php bin/console cache:clear
	docker compose exec app sh tools/fix-perms.sh

# --- Doctrine / migrations ---

migrate:
	docker compose exec app php bin/console doctrine:migrations:migrate -n

diff:
	docker compose exec app php bin/console doctrine:migrations:diff

schema-validate:
	docker compose exec app php bin/console doctrine:schema:validate

# --- Lint Symfony (YAML, Twig, container) ---

lint-yaml:
	docker compose exec app php bin/console lint:yaml config

lint-twig:
	docker compose exec app php bin/console lint:twig templates

lint-container:
	docker compose exec app php bin/console lint:container

lint:
	docker compose exec app php bin/console lint:yaml config
	docker compose exec app php bin/console lint:twig templates
	docker compose exec app php bin/console lint:container

# --- php-cs-fixer ---

cs-fix:
	docker compose exec app php vendor/bin/php-cs-fixer fix src/

# --- PHPStan ---

phpstan:
	docker compose exec app php -d memory_limit=512M vendor/bin/phpstan analyse src/ --level=5

# --- Vérifications complètes (CS, PHPStan, lint Symfony) ---

check: cs-fix phpstan lint
