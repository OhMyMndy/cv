build:
	docker-compose run --rm php s6-setuidgid abc php src/generate.php

composer-install:
	docker-compose run --rm php s6-setuidgid abc composer install


dev-server:
	docker-compose up -d dev-server