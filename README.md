# backend for [stayathome](https://github.com/raphbibus/wirvsvirus)

## table of contents

1. [base url](#base-url)
1. [api documentation](#api-documentation)
    1. [account management](#account-management)
        1. [get user stats](#get-user-stats)
        2. [create entered home event](#create-entered-home-event)
        3. [create left home event](#create-left-home-event)
        4. [get user](#get-user)
        5. [create user](#create-user)
    2. [leaderboard](#leaderboard)

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
GET users/<username>/stats | 200 OK | 404 on not found
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
POST users/<username>/home-enter | 201 Created | 422 on validation error | 404 on not found
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

#### create left home event

```
POST users/<username>/home-leave | 201 Created | 422 on validation error | 404 on not found
```

```json5
// payload
{
	"timestamp": "2020-03-21T15:50:22.000000Z",
	"token": "9ce46249294e220f06434d57911a7c4a"
}
```

```json5
//response
{
    "entered": "2020-03-21T10:50:22.000000Z",
    "left": "2020-03-21T15:50:22.000000Z",
    "token": "9ce46249294e220f06434d57911a7c4a",
    "created_at": "2020-03-21T14:43:30.000000Z",
    "updated_at": "2020-03-21T14:44:44.000000Z"
}
```

#### get user

```
GET users/<username> | 200 OK | 404 on not found
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
POST users | 201 Created | 422 on validation error
```

```json5
// payload
{
    "username": "<unique username>",
    "display_name": "<some display name>",
    "nation": "Deutschland", //optional
    "city": "Berlin" //optional
}
```

```json5
//response
{
    "username": "raphbibus204",
    "display_name": "Ralph",
    "points": 0,
    "seconds": 0,
    "nation": "Deutschland",
    "city": "Berlin",
    "updated_at": "2020-03-21T19:41:02.000000Z",
    "created_at": "2020-03-21T19:41:02.000000Z"
}
```

### leaderboard

#### get leaderboard

```
GET leaderboard | 200 OK
```

```json5
{
    "current_page": 1,
    "data": [
        {
            "username": "wehner.gregorio",
            "display_name": "Mrs. Rosalyn Bashirian",
            "created_at": "2020-03-21T19:27:40.000000Z",
            "updated_at": "2020-03-21T19:27:40.000000Z",
            "seconds": 34399,
            "points": 196153,
            "nation": "Indonesia",
            "city": "West Kaelynchester"
        },
        //further results...
        {
            "username": "luigi39",
            "display_name": "Katarina Feeney",
            "created_at": "2020-03-21T19:27:40.000000Z",
            "updated_at": "2020-03-21T19:27:40.000000Z",
            "seconds": 1242550,
            "points": 115899,
            "nation": "Brunei Darussalam",
            "city": "Caseyberg"
        }
    ],
    "first_page_url": "https://wirvsvirus.agile-punks.com/leaderboard?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "https://wirvsvirus.agile-punks.com/leaderboard?page=3",
    "next_page_url": "https://wirvsvirus.agile-punks.com/leaderboard?page=2",
    "path": "https://wirvsvirus.agile-punks.com/leaderboard",
    "per_page": 20,
    "prev_page_url": null,
    "to": 20,
    "total": 54
}
```
