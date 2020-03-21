# backend for [stayathome](https://github.com/raphbibus/wirvsvirus)

## table of contents

1. [base url](#base-url)
1. [api documentation](#api-documentation)
    1. [account management](#account-management)
        1. [get user stats](#get-user-stats)

## base url

[wirvsvirus.agile-punks.com](https://wirvsvirus.agile-punks.com/)
```
https://wirvsvirus.agile-punks.com/
```

## headers

required on post requests.
```
content-type: application/json
```

## api documentation

### account management

#### get user stats

```
GET users/<username>/stats
```

```json5
//response
{
    "seconds": 124513235,
    "points": 1341
}
```

#### create entered home event

```
POST users/<username>/home-enter
```

```json5
// payload
{
    "timestamp": "2020-03-21T10:50:22.000000Z"
}
```

```json5
//response
{
    "entered": "2020-03-21 10:50:22",
    "token": "9ce46249294e220f06434d57911a7c4a", //used for home-leave reference
    "updated_at": "2020-03-21T11:33:36.000000Z",
    "created_at": "2020-03-21T11:33:36.000000Z"
}
```

#### get user

```
GET users/<username>
```

```json5
//response
{
    "seconds": 124513235,
    "points": 1341,
    "username": "<some username>",
    "display_name": "<some display name>"
}
```

#### create user

```
POST users
```

```json5
// payload
{
    "username": "<unique username>",
    "display_name": "<some display name>"
}
```

```json5
//response
{
    "seconds": 0,
    "points": 0,
    "username": "<some username>",
    "display_name": "<some display name>"
}
```
