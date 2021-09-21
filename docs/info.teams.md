# Info Teams

Get clubs with filters.

**URL** : `/api/info.teams/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

**Parameters required** :

**Parameters optional** : `continent_code`, `country_code`, `category_id`,`division_id`, `order`,`ordersense`,`page`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "status": "ok",
    "result": [
        {
            "team_id": "2",
            "club_id": "2",
            "team_name": "First Team",
            "club_name": "River Plate",
            "logo": "imgs/clubs_logo/2.svg",
            "category_name": "Profesional",
            "division_name": "Primera División",
            "country_name": "Argentina",
            "country_flag": "imgs/svg/AR.svg",
            "squad": "0"
        },
        {
            "team_id": "1",
            "club_id": "1",
            "team_name": "First Team",
            "club_name": "Boca Juniors",
            "logo": "imgs/clubs_logo/1.svg",
            "category_name": "Profesional",
            "division_name": "Primera División",
            "country_name": "Argentina",
            "country_flag": "imgs/svg/AR.svg",
            "squad": "24"
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