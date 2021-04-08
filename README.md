# dbproject



### **Info for peer review**

*What is implemented:*

| Endpoint | URI (http://server/API)  | Methods | Description                                          |
| -------- | ------------------------ | ------- | ---------------------------------------------------- |
| Orders   | /orders                  | GET     | Get basic information about all  orders              |
| Orders   | /orders/{number}         | GET     | Get info about one specific order                    |
| Orders   | /orders/{state}          | GET     | Get info about orders based on  state                |
| Orders   | /orders/{number}/{state} | PUT     | Change a specific orders state                       |
| Skis     | /skis/date/’*date*’      | GET     | Get skis that are produced on or  after a given date |
| Skitypes | /skitypes                | GET     | GET all skitypes                                     |
| Skitypes | /skitypes/{model}        | GET     | GET skitype with model filter                        |
| …        |                          |         |                                                      |

*What is not working*

- Unit test that updates a value, i.e. sets an orders state to open. (works with Postman but how to write test for it?)
- Currently working on adding new order. Not yet working.

*What I plan to implement / improve*

- Separate some of the code in APIController.php into files for each endpiont and a resourceController.php
- Improve endpoint validation and payload validation
- A way to separate the different users with tokens
- The different the types of customers. Now it is only 'Customer'.
- Get total price for orders, based on price of the skis. Move msrp to ski relation?
- Error handling
- (The other requirements in the project case)



*misc.*

- Production plans are for the months of the year (from 2021-01 to 2021-04 in the test DB)

- Remember ' ' around the date when using Postman. Example:

  ```
  http://127.0.0.1/dbproject/skis/date/'2021-03-01'
  ```

  



##### Setup

1. Clone the repo

2. .htaccess file:

   Add the line for my project in your xampp/htdocs/.htaccess

   ```
   RewriteRule dbproject/(.*)$ dbproject/api.php?request=$1 [QSA,NC,L]
   ```

3. Install composer from https://getcomposer.org/download/ (if not already installed)

4. Install libraries in the code/ directory (This is for Linux users)

   ```
   composer require --dev "codeception/codeception"
   composer require --dev "codeception/module-asserts"
   composer require --dev "codeception/module-db"
   composer require --dev "codeception/module-rest"
   composer require --dev "codeception/module-phpbrowser"
   ```

   

5. Create a Database in phpMyAdmin and name it 'dbproject' 

6. Import the Database setup from: code/db/dbinit.sql



#### Who am I

Morten Bratberg BDIGSEC19 - Gjøvik

morterb@stud.ntnu.no

Discord: korg#8519