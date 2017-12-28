# RESTful API Slim CMS App

RESTful API customer management application built using [Slim Framework](https://slimframework.com), MySQL database, and PDO connection. Returns customers in JSON format.

## Usage

Get all customers
```
GET /api/customers/
```

Get a single customer
```
GET /api/customers/{id}
```

Add a customer
```
POST /api/customers/add
```

Update a customer
```
PUT /api/customers/update/{id}
```

Delete a customer
```
DELETE /api/customers/delete/{id}
```

