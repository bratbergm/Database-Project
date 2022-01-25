# dbproject


**This is a single student project**

### Setup

1. Clone the repo

2. .htaccess file:

   Add the line for my project in your xampp/htdocs/.htaccess

   ```
   RewriteRule dbproject/(.*)$ dbproject/api.php?request=$1 [QSA,NC,L]
   ```

3. Folders 'controller' and 'db', and the files 'api.php' and 'RESTConstraints.php' must be in xampp/htdocs/dbproject

4. Install composer from https://getcomposer.org/download/ (if not already installed)

5. Install libraries in the code/ directory (This is for Linux)

   ```
   composer require --dev "codeception/codeception"
   composer require --dev "codeception/module-asserts"
   composer require --dev "codeception/module-db"
   composer require --dev "codeception/module-rest"
   composer require --dev "codeception/module-phpbrowser"
   ```

6. Create a Database in phpMyAdmin and name it 'dbproject' 

7. Import the Database setup from: code/db/dbinit.sql



### **Token**

The different users of the system are authenticated by tokens. The correct token needs to be in the request for it to be successful.

Public users: `efa1f375d76194fa51a3556a97e641e61685f914d446979da50a551a4333ffd7`

Storekeeper: `d5367aea1c17343b6c380f774b81a8d7d5e33c43dc445fdc8a6f884723694f3d`

Customer rep: `fbecd91f02f99f3d896f387283921118375de5624d0a4b5eb614d248479dfef4`

Customer: `b6c45863875e34487ca3c155ed145efe12a74581e27befec5aa661b8ee8ca6dd`



### **Endpoints**

#### *Public Endpoint*

```
TOKEN_PUBLIC = efa1f375d76194fa51a3556a97e641e61685f914d446979da50a551a4333ffd7
```

 URI Examples - GET requests

```
http://127.0.0.1/dbproject/skitypes
http://127.0.0.1/dbproject/skitypes/Active
```



| Endpoint | URI (http://server/API) | Methods | Description                    |
| -------- | ----------------------- | ------- | ------------------------------ |
| Skitypes | /skitypes               | GET     | GET skitypes                   |
| Skitypes | /skitypes/{model}       | GET     | GET skitypes with model filter |



#### *Storekeeper Endpoint*

```
TOKEN_STOREKEEPER = d5367aea1c17343b6c380f774b81a8d7d5e33c43dc445fdc8a6f884723694f3d
```

URI Examples - GET requests

```
http://127.0.0.1/dbproject/skis/date/'2021-03-01'
```

| Endpoint | URI (http://server/API) | Methods | Description                                          |
| -------- | ----------------------- | ------- | ---------------------------------------------------- |
| Skis     | /skis/date/’*date*’     | GET     | Get skis that are produced on or  after a given date |



#### *Customer rep Endpoint*

```
TOKEN_CUSTOMERREP = fbecd91f02f99f3d896f387283921118375de5624d0a4b5eb614d248479dfef4
```

URI Example - GET requests

```
http://127.0.0.1/dbproject/orders
http://127.0.0.1/dbproject/orders/1
http://127.0.0.1/dbproject/orders/new

```

URI Example - PUT request

```
http://127.0.0.1/dbproject/orders/1/test
```

| Endpoint | URI (http://server/API)  | Methods | Description                             |
| -------- | ------------------------ | ------- | --------------------------------------- |
| Orders   | /orders                  | GET     | Get basic information about all  orders |
| Orders   | /orders/{number}         | GET     | Get info about one specific order       |
| Orders   | /orders/{state}          | GET     | Get info about orders based on  state   |
| Orders   | /orders/{number}/{state} | PUT     | Change a specific orders state          |



#### *Customer Endpoint* 

```
TOKEN_CUSTOMER = b6c45863875e34487ca3c155ed145efe12a74581e27befec5aa661b8ee8ca6dd
```

URI Examples - GET

```
http://127.0.0.1/dbproject/orders
http://127.0.0.1/dbproject/orders/1
http://127.0.0.1/dbproject/plans/2021-02
```

URI example - DELETE

```
http://127.0.0.1/dbproject/orders/1
```

URI Examples - POST

```
http://127.0.0.1/dbproject/orders

// JSON payload example:
{
        "totalPrice": "5555",
        "offLargeOrder": null,
        "state": "new test",
        "customerId": "1"
    }
```

| Endpoint | URI (http://server/API) | Methods | Description                                        |
| -------- | ----------------------- | ------- | -------------------------------------------------- |
| Orders   | /orders                 | GET     | Get basic information about all  orders            |
| Orders   | /orders/{number}        | GET     | Get info about one specific order                  |
| Orders   | /orders                 | POST    | Create new order, with a payload  (auto increment) |
| Orders   | /orders/{number}        | DELETE  | Deletes the given order                            |
| Plans    | /plans/{period}         | GET     | Retrieve a four-week production plan summary       |





### **Miscellaneous**

- Production plans are for the months of the year (from 2021-01 to 2021-04 in the test DB)

- Use ' ' around the date to get skis produced after a give date when using Postman. Example:

  ```
  http://127.0.0.1/dbproject/skis/date/'2021-03-01'
  ```

- The only user that is implemented is root, and dbCredentials.php is part of the repo.

