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
docker-compose exec --user=application web bash
php bin/console doctrine:schema:update --force

```