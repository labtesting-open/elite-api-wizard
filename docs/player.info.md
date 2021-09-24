# Player Info

Get info from player 

**URL** : `/api/players.info/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

**Parameters required** : `id`

**Parameters optional** : `country_code`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "status": "ok",
    "result": {
        "perfil": {
            "player_id": "47",
            "name": "Stéphane",
            "surname": "Emaná",
            "height": "181",
            "weight": "81",
            "birthdate": "1994-06-17",
            "img_profile_url": null,
            "img_header_url": null,
            "jersey_nro": "14",
            "club_name": "Valencia CF",
            "logo": "imgs/clubs_logo/5.png",
            "nacionalities_names": "Camerún",
            "nacionalities_flags": "imgs/svg/CM.svg",
            "outfitter_name": "none",
            "main_foot": "Izquierda",
            "name_main_position": "Delantero",
            "map_main_position": "DC"
        },
        "history_injuries": [],
        "map_secondary_position": [
            {
                "position_code": "ED",
                "description": "Extremo Derecho"
            },
            {
                "position_code": "EI",
                "description": "Extremo Izquierdo"
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