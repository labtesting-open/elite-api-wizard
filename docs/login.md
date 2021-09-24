# Login

Used to collect a Token for a registered User.

**URL** : `/api/login/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "username": "[valid email address]",
    "password": "[password in plain text]"
}
```

**Data example**

```json
{
    "username": "iloveauth@example.com",
    "password": "abcd1234"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "token": "93144b288eb1fdccbe46d6fc0f241a51766ecd3d"
}
```

## Error Response

**Condition** : If 'username' and 'password' combination is wrong.

**Code** : `200 OK`

**Content** :

```json
{
   "status": "error",
    "result": {
        "error_id": "200",
        "error_msg": "Incorrect password"
    }
}
```

**Condition** : if any of these parameters are not found.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
     "status": "error",
    "result": {
        "error_id": "400",
        "error_msg": "Bad Request"
    }
}
```