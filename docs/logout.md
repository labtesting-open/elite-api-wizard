# Logout

Used to logout user or disable user token.

**URL** : `/api/logout/`

**Method** : `POST`

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
        "token": "disabled"
    }
}
```

## Error Response

**Condition** : If 'token' is wrong or already disabled.

**Code** : `200 OK`

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