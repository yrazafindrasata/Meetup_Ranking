Projet Meetup ranking
==============

# Installation

First, clone this repository:

```bash
$ git clone https://github.com/yrazafindrasata/meetup_ranking.git
```

### Init

```bash
cp .env.dist .env
docker-compose up -d
docker-compose exec --user=application web bash:
	composer install
	php bin/console doctrine:schema:update --force

```

ps: to create an admin, add ROLE_AMDIN to a user using phpmyadmin