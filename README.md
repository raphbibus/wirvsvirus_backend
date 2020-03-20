# backend for [stayathome](https://github.com/raphbibus/wirvsvirus)

## table of contents

1. [base url](#base-url)
1. [api documentation](#api-documentation)
    1. [account management](#account-management)
        1. [get user stats](#get-user-stats)

## base url

[wirvsvirus.agile-punks.com](https://wirvsvirus.agile-punks.com/)

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
