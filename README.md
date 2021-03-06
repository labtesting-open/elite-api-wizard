<p align="center"><img src="https://blog.pleets.org/img/articles/easy-http-logo.png" height="150"></p>

<p align="center">
<a href="https://travis-ci.com/labtesting-open/elite-api-wizard"><img src="https://travis-ci.com/labtesting-open/elite-api-wizard.svg?branch=develop" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/labtesting-open/elite-api-wizard/?branch=develop"><img src="https://scrutinizer-ci.com/g/labtesting-open/elite-api-wizard/badges/quality-score.png?b=develop" alt="Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/labtesting-open/elite-api-wizard/?branch=develop"><img src="https://scrutinizer-ci.com/g/labtesting-open/elite-api-wizard/badges/coverage.png?b=develop" alt="Code Coverage"></a>
</p>

# ELITE-API FOR WIZARD

<a href="https://sonarcloud.io/dashboard?id=labtesting-open_elite-api-wizard"><img src="https://sonarcloud.io/api/project_badges/measure?project=labtesting-open_elite-api-wizard&metric=security_rating" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=labtesting-open_elite-api-wizard"><img src="https://sonarcloud.io/api/project_badges/measure?project=labtesting-open_elite-api-wizard&metric=bugs" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=labtesting-open_elite-api-wizard"><img src="https://sonarcloud.io/api/project_badges/measure?project=labtesting-open_elite-api-wizard&metric=code_smells&pullRequest=5" alt="Bugs"></a>

This project need the following requirements:
- Library elitelib/persistence v0.4 or higher
- EliteDB/wizard (private db)
- ver 7.4 or higher

# Installation

Use following command to install this library:

```bash
composer install
```

# Usage

## Open Endpoints
Require user Authentication

* [Login](docs/login.md) : `POST /elite-api-wizard/v1/login`

The POST need this credentials on the body of request
```php
{
    "user":"username",
    "password":"password"
}
```
The return from this endpoint is the TOKEN

## Closed Endpoints
Closed endpoints require a valid Token to be included in the body of the
request. A Token can be acquired from the Login view above.

### Current User related

Each endpoint manipulates or displays information related to the User whose
Token is provided with the request


### Account related

Endpoints for viewing and manipulating the Accounts that the Authenticated User
has permissions to access.

* [logout user](docs/logout.md) : `POST /elite-api-wizard/v1/logout`
* [Get user data](docs/user.md) : `GET /elite-api-wizard/v1/user`
* [Get club info](docs/club.md) : `GET /elite-api-wizard/v1/club`
* [Get club teams](docs/teams.md) : `GET /elite-api-wizard/v1/teams`
* [Get seasons](docs/seasons.md) : `GET /elite-api-wizard/v1/seasons`
* [Get user club](docs/user.club.md) : `GET /elite-api-wizard/v1/user.club`
* [Get team season players](docs/players.md) : `GET /elite-api-wizard/v1/players`
* [Search clubs and players](docs/user.search.md) : `GET /elite-api-wizard/v1/search`
* [Search players in team and season](docs/players.search.md) : `GET /elite-api-wizard/v1/players.search`
* [Get player statics](docs/players.statics.md) : `GET /elite-api-wizard/v1/players.statics`
* [Get player perfil info](docs/player.info.md) : `GET /elite-api-wizard/v1/player.info`
* [Get teams info with filters](docs/info.teams.md) : `GET /elite-api-wizard/v1/info.teams`
* [Get filters availables for teams](docs/filters.teams.md) : `GET /elite-api-wizard/v1/filters.teams`
* [Get filters availables for players](docs/filters.players.md) : `GET /elite-api-wizard/v1/filters.players`


