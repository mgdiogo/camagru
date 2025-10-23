all: build up

build:
	mkdir -p ./data/mysql
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

clean:
	docker-compose down -v
	docker container prune --force
	docker image prune -a --force
	docker volume prune -a --force
	docker builder prune -a --force
	sudo rm -rf ./data/mysql

re: clean all