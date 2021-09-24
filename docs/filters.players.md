# Filters Players

Get filters available of players.

**URL** : `/api/filters.players/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

**Parameters required** :`target`

**Parameters optional** : `continent_code`, `country_code`, `category_id`,`division_id`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "status": "ok",
    "result": {
        "continents": [
            {
                "continent_code": "AF",
                "name": "Africa"
            },
            {
                "continent_code": "AS",
                "name": "Asia"
            },
            {
                "continent_code": "EU",
                "name": "Europe"
            },
            {
                "continent_code": "OC",
                "name": "Oceania"
            },
            {
                "continent_code": "SA",
                "name": "South america"
            }
        ],
        "countries": [
            {
                "country_code": "DE",
                "name": "Alemania",
                "country_flag": "imgs/svg/DE.svg",
                "continent_code": "EU"
            },
            {
                "country_code": "AR",
                "name": "Argentina",
                "country_flag": "imgs/svg/AR.svg",
                "continent_code": "SA"
            },
            {
                "country_code": "GB",
                "name": "Reino Unido",
                "country_flag": "imgs/svg/GB.svg",
                "continent_code": "EU"
            }
        ],
        "categories": [
            {
                "id": "1",
                "name": "Profesional"
            },
            {
                "id": "4",
                "name": "Profesional F"
            },
            {
                "id": "3",
                "name": "U21/Juvenil"
            }
        ],
        "divisions": [
            {
                "division_id": "12",
                "name": "A-League",
                "country_code": "AU",
                "category_id": "1"
            },
            {
                "division_id": "4",
                "name": "Bundesliga",
                "country_code": "DE",
                "category_id": "1"
            },
            {
                "division_id": "9",
                "name": "Championship",
                "country_code": "GB",
                "category_id": "1"
            },
            {
                "division_id": "7",
                "name": "Division de Honor",
                "country_code": "ES",
                "category_id": "3"
            }
        ]
    }
}
```

## Error Response


**Condition** : if authorization not found.

**Code** : `401 not authorised`

**Content** :

```json
{
    "status": "error",
    "result": {
        "error_id": "401",
        "error_msg": "not authorised"
    }
}
```

*Condition** : if token is wrong.

**Code** : `401 not authorised`

**Content** :

```json
{
    "status": "error",
    "result": {
        "error_id": "401",
        "error_msg": "Token invalid or expired"
    }
}
```

**Condition** : if any of these parameters are not found.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
     "status": "error",
    "result": {
        "error_id": "400",
        "error_msg": "Bad Request"
    }
}
```