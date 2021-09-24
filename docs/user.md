# User

Used to get information about user.

**URL** : `/api/user/`

**Method** : `GET`

**Auth required** : YES

**HEADER**

```json
Authorization Bearer Token
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "status": "ok",
    "result": {
        "userInfo": {
            "id": "elitesports17",
            "name": "john",
            "surname": "Doe",
            "img_perfil": "imgs/users/1/perfil.jpg"
        },
        "plan": {
            "id": "5",
            "name": "Club Manager Plus",
            "active": "true",
             "services": [
                {
                    "id": "1",
                    "name": "Streaming",
                    "active": "true",
                    "url": "/streaming"
                }
             ]

        }
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