# User.club

Get all id clubs from a user linked with token.

**URL** : `/api/user.club/`

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
    "result": [
        {
            "club_id": "1"
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