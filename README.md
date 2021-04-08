# dbproject



**Info for peer review**

*What is implemented:*

(Endpoint design tabell)

*What is not working*

- Unit test that updates a value, i.e. sets an orders state to open. (works with Postman but how to write test for it?)
- Currently working on adding new order. Not yet working.

*What I plan to implement / improve*

- Separate some of the code in APIController.php into files for each endpiont and a resourceController.php
- Improve endpoint validation and payload validation
- A way to separate the different users with tokens
- The different the types of customers. Now it is only 'Customer'.
- Get total price for orders, based on price of the skis. Move msrp to ski relation?
- (The other requirements in the project case)



*misc*

- Production plans are for the months of the year (from 2021-01 to 2021-04 in the test DB)

