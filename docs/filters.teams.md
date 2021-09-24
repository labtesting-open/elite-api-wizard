# Filters Teams

Get filters available of teams.

**URL** : `/api/filters.teams/`

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
    "result": [
        {
            "team_id": "29",
            "club_id": "1",
            "team_name": "First Team",
            "club_name": "Boca Juniors",
            "logo": "imgs/clubs_logo/1.svg",
            "category_name": "Profesional F",
            "division_name": "Primera División F",
            "country_name": "Argentina",
            "country_flag": "imgs/svg/AR.svg",
            "squad": "10"
        },
        {
            "team_id": "28",
            "club_id": "24",
            "team_name": "First Team",
            "club_name": "Nasarawa United",
            "logo": "imgs/clubs_logo/24.png",
            "category_name": "Profesional",
            "division_name": "NPFL",
            "country_name": "Nigeria",
            "country_flag": "imgs/svg/NG.svg",
            "squad": "0"
        }
    ]
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