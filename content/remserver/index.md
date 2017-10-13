REM Server API
===========================================

API {#api}
-------------------------------------------

###Get dataset {#all}

```text
GET /api/[dataset]
GET /api/users
```

Resultat

```json
{
    "data": [],
    "offset": 0,
    "limit": 25,
    "total": 0
}

{
    "data": [
        {
            "id": "1",
            "firstName": "Phuong",
            "lastName": "Allison"
        },
        ...
    ],
    "offset": 0,
    "limit": 25,
    "total": 12
}
```

Optional query string parameters.

* `offset` defaults to 0.
* `limit` defaults to 25.

```text
GET /api/users?offset=0&limit=25
```



###Get ett speciellt id {#one}

```text
GET /api/users/7
```

Resultat

```json
{
    "id": "7",
    "firstName": "Etha",
    "lastName": "Nolley"
}
```



###Skapa nytt


```text
POST /api/[dataset]
{"some": "thing"}

POST /api/users
{"firstName": "Mikael", "lastName": "Roos"}
```

Resultat

```json
{
    "some": "thing",
    "id": 1
}

{
    "firstName": "Mikael",
    "lastName": "Roos",
    "id": 13
}
```



###Uppdatera/ersätt

Upsert (insert/update) or replace a entry, create the dataset if it does not exists.

```text
PUT /api/[dataset]/1
{"id": 1, "other": "thing"}

PUT /api/users/13
{"id": 13, "firstName": "MegaMic", "lastName": "Roos"}
```
Resultat

```json
{
    "other": "thing",
    "id": 1
}

{
    "id": 13,
    "firstName": "MegaMic",
    "lastName": "Roos"
}
```



###Ta bort

Delete a entry.

```text
DELETE /api/[dataset]/1

DELETE /api/users/13
```

Resultatet kommer bli `NULL`



Source {#source}
-------------------------------------------

The source is on GitHub in [dbwebb-se/rem-server](https://github.com/dbwebb-se/rem-server).
