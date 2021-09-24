# Teams

Used all teams from club.

**URL** : `/api/teams/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

**Parameters required** : `club_id`

**Parameters optional** : `country_code`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "status": "ok",
    "result": [
        {
            "team_id": "1",
            "team_name": "Boca Juniors",
            "category_name": "Profesional",
            "division_name": "Primera División",
            "players": "14",
            "age_average": "28",
            "img_team": "imgs/teams_profile/1.jpg"
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

*Condition** : club_id param not found.

**Code** : `200 error`

**Content** :

```json
{
    "status": "error",
    "result": {
        "error_id": "200",
        "error_msg": "Data incorrect or incomplete"
    }
}
```

*Condition** : club_id param is wrong.

**Code** : `200 ok`

**Content** :

```json
{
    "status": "ok",
    "result": null
}
```