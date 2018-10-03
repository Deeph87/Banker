include .env

MAKEFLAGS += --no-print-directory

up:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	@make down
	@make up