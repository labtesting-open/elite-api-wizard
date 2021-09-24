# Player Statics

Gat statics from player 

**URL** : `/api/players.statics/`

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
        "actions": [
            {
                "name": "Goal",
                "items": [
                    {
                        "match_date": "2021-02-27",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "10",
                        "url_video": "https://www.youtube.com/watch?v=2NAcTq_kUDM&ab_channel=PasionBoquense"
                    },
                    {
                        "match_date": "2021-02-27",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "60",
                        "url_video": null
                    },
                    {
                        "match_date": "2019-10-23",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "37",
                        "url_video": null
                    }
                ]
            },
            {
                "name": "Shot Success",
                "items": [
                    {
                        "match_date": "2019-10-23",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "10",
                        "url_video": null
                    },
                    {
                        "match_date": "2019-10-23",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "11",
                        "url_video": null
                    }
                ]
            },
            {
                "name": "Dribbling Success",
                "items": [
                    {
                        "match_date": "2019-10-23",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "15",
                        "url_video": null
                    },
                    {
                        "match_date": "2019-10-23",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "17",
                        "url_video": null
                    },
                    {
                        "match_date": "2019-10-23",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "20",
                        "url_video": null
                    },
                    {
                        "match_date": "2019-10-23",
                        "club_home_name": "Boca Juniors",
                        "club_visitor_name": "River Plate",
                        "minute": "15",
                        "url_video": null
                    }
                ]
            },
            {
                "name": "Yellow Card",
                "items": []
            },
            {
                "name": "Red Card",
                "items": []
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