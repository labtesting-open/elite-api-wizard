# Players

get all players from a team on a season

**URL** : `/api/players/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

**Parameters required** : `club_id`, `team_id`

**Parameters optional** : `country_code`

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
                "players": [
                    {
                        "id": "26",
                        "name": "Manuel",
                        "surname": "Neuer",
                        "birthdate": "1986-03-27",
                        "img_profile_url": "imgs/players_profile/26.jpg",
                        "position": "Goalkeeper",
                        "nacionalities_names": "Alemania",
                        "nacionalities_flags": "imgs/svg/DE.svg",
                        "matches_played": "0",
                        "goals_received": "-",
                        "saves": "-",
                        "shots_received": "-",
                        "yellow_card": "-",
                        "red_card": "-",
                        "health_status": "ok",
                        "health_detail": null
                    }
                ]
            },
            {
                "name": "Defender",
                "players": [
                    {
                        "id": "27",
                        "name": "Lucas",
                        "surname": "Hernández",
                        "birthdate": "1996-02-14",
                        "img_profile_url": "imgs/players_profile/27.jpg",
                        "position": "Left Central Defender",
                        "nacionalities_names": "España,Francia",
                        "nacionalities_flags": "imgs/svg/ES.svg,imgs/svg/FR.svg",
                        "matches_played": "0",
                        "goals": "-",
                        "tackles_success": "-",
                        "fouls": "-",
                        "yellow_card": "-",
                        "red_card": "-",
                        "health_status": "ok",
                        "health_detail": null
                    }
                ]
            },
            {
                "name": "Midfielder",
                "players": [
                    {
                        "id": "28",
                        "name": "Joshua",
                        "surname": "Kimmich",
                        "birthdate": "1995-02-08",
                        "img_profile_url": "imgs/players_profile/28.jpg",
                        "position": "Midfielder",
                        "nacionalities_names": "Alemania",
                        "nacionalities_flags": "imgs/svg/DE.svg",
                        "matches_played": "0",
                        "goals": "-",
                        "shots_success": "-",
                        "Passes_success": "-",
                        "yellow_card": "-",
                        "red_card": "-",
                        "health_status": "ok",
                        "health_detail": null
                    }
                ]
            },
            {
                "name": "Striker",
                "players": [
                    {
                        "id": "29",
                        "name": "Robert",
                        "surname": "Lewandowski",
                        "birthdate": "1988-08-21",
                        "img_profile_url": "imgs/players_profile/29.jpg",
                        "position": "Central Forward",
                        "nacionalities_names": "Polonia",
                        "nacionalities_flags": "imgs/svg/PL.svg",
                        "matches_played": "0",
                        "goals": "-",
                        "shots_success": "-",
                        "dribbling_success": "-",
                        "yellow_card": "-",
                        "red_card": "-",
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