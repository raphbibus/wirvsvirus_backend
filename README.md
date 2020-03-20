# backend for stayathome

## base url

```
https://wirvsvirus.agile-punks.com/
```
## get user stats

```
GET users/<username>/stats
```

```javascript
//response
{
    "seconds": 124513235,
    "points": 1341
}
```

## get user

```
GET users/<username>
```

```javascript
//response
{
    "seconds": 124513235,
    "points": 1341,
    "username": "<some username>",
    "display_name": "<some display name>"
}
```

## create user

```
POST users
```

```javascript
// payload
{
    "username": "<unique username>",
    "display_name": "<some display name>"
}
//response
{
    "seconds": 0,
    "points": 0,
    "username": "<some username>",
    "display_name": "<some display name>"
}
```
