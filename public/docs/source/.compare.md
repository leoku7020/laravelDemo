---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#User Register
Register New User
<!-- START_ab484852d4348050a5dc4e5ea987ed42 -->
## api/v1/member/register
> Example request:

```bash
curl -X POST "/api/v1/member/register" \
    -H "Content-Type: application/json" \
    -d '{"name":"quod","address":"ex","phone":"delectus","account":"et","password":"dolorem","mail":"est"}'

```

```javascript
const url = new URL("/api/v1/member/register");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "quod",
    "address": "ex",
    "phone": "delectus",
    "account": "et",
    "password": "dolorem",
    "mail": "est"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "url": "http:\/\/backend.test\/api\/v1\/member\/register",
    "method": "POST",
    "code": 100,
    "message": "Get something successful.",
    "data": {
        "name": "Eric",
        "address": "台北市一號",
        "phone": "0987123456",
        "account": "Eric.ku@gmail.com",
        "mail": "Eric.ku@gmail.com",
        "updated_at": "2019-06-28 02:23:12",
        "created_at": "2019-06-28 02:23:12",
        "id": 1
    }
}
```
> Example response (101):

```json
{
    "url": "http:\/\/backend.test\/api\/v1\/member\/register",
    "method": "POST",
    "code": 101,
    "message": "user is exist",
    "errors": []
}
```
> Example response (500):

```json
{
    "url": "http:\/\/backend.test\/api\/v1\/member\/register",
    "method": "POST",
    "code": 500,
    "message": "DB error",
    "errors": []
}
```

### HTTP Request
`POST api/v1/member/register`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Name
    address | string |  required  | Address
    phone | string |  required  | Number
    account | string |  required  | Account
    password | string |  required  | Password
    mail | string |  required  | Mail

<!-- END_ab484852d4348050a5dc4e5ea987ed42 -->


