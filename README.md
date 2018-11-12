# Banker

## Prerequisites

* Docker
* Docker-compose 
* make

## How to run

* Run this command : `docker volume create --name=postgres_database`
* Copy `.env.dist` and paste as `.env`. Change vars according to your needs
* Run `make` (or `docker-compose up --build`)

## How to stop

* Run `make down` (or `docker-compose down`)
