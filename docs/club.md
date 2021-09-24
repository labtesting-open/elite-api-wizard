# Club

Used to get information about user.

**URL** : `/api/club/`

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
    "result": {
        "id": "1",
        "name": "Boca Juniors",
        "logo": "imgs/clubs_logo/1.svg",
        "stadium": "La Bombonera",
        "since": "1905-04-03",
        "country_code": "AR",
        "players_cant": "24",
        "teams_cant": "4"
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