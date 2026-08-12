lint: ## Lint le code
	php ./vendor/bin/phpstan analyse --memory-limit=2G

test: ## Test le code
	php ./vendor/bin/phpunit tests

