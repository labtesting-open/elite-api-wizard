# Players Search

Search players from a team on a season 

**URL** : `/api/players.search/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

**Parameters required** : `club_id`, `team_id`, `season_id`

**Parameters optional** : `country_code`, `find`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "status": "ok",
    "result": {
        "categories": [
            {
                "name": "GoalKeeper",
                "players": []
            },
            {
                "name": "Defender",
                "players": []
            },
            {
                "name": "Midfielder",
                "players": []
            },
            {
                "name": "Striker",
                "players": [
                    {
                        "id": "1",
                        "name": "Carlos",
                        "surname": "Tevez",
                        "birthdate": "1984-01-01",
                        "img_profile_url": "imgs/players_profile/1.jpg",
                        "position": "Half Forward",
                        "nacionalities_names": "Argentina",
                        "nacionalities_flags": "imgs/svg/AR.svg",
                        "matches_played": "1",
                        "goals": "1",
                        "shots_success": "2",
                        "dribbling_success": "4",
                        "yellow_card": "0",
                        "red_card": "0",
                        "health_status": "ok",
                        "health_detail": null
                    }
                ]
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