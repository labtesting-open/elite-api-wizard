# Search

Search clubs and players.

**URL** : `/api/search/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

**Parameters required** : `find`

**Parameters optional** : `country_code`,`fast`, `limit`

## Success Response

**Code** : `200 OK`

**Content example** : 

**Case find with data** (find=`bo`)

```json
{
    "status": "ok",
    "result": {
        "players": [
            {
                "id": "17",
                "name": "Enrique",
                "surname": "Bologna",
                "birthdate": "1982-02-13",
                "img_profile_url": "imgs/players_profile/17.jpg",
                "club_name": "River Plate",
                "position": "Right Central Defender",
                "nacionalities_names": "Italia,Argentina",
                "nacionalities_flags": "imgs/svg/IT.svg,imgs/svg/AR.svg"
            }
        ],
        "clubs": [
            {
                "id": "1",
                "name": "Boca Juniors",
                "logo": "imgs/clubs_logo/1.svg",
                "stadium": "La Bombonera",
                "since": "1905-04-03",
                "nacionalities_names": "Argentina",
                "nacionalities_flags": "imgs/svg/AR.svg"
            }
        ]
    }
}
```

**Case find without data** (find=``)
```json
{
    "status": "ok",
    "result": {
        "players": [],
        "clubs": []
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

*Condition** : Any of required params not found or is not a number.

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