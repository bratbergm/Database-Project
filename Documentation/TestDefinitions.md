##### Definitions of implemented test cases



## Unit Test Cases

### Successful Operations

##### Order Endpoint

- Tests if GET order number 1 is a valid endpoint
- Tests if order number 1 exists
- Tests how many orders have state 'new'. 2 does.
- Tests if possible to delete order 1

##### Ski Endpoint

- Tests if possible to retrieve list of skis 
- Tests if possible to retrieve a given ski
- Tests retrieve record of produced skis since a date

##### SkiType Endpoint

- Tests if possible to retrieve list of ski types
- Tests if possible to retrieve a given skiType

### Failure Operations

##### Order Endpoint

- Tests if GET order number 999 is a valid endpoint
- Tests if order number 999 exists

## API Test Cases

#### Successful Operations

- Get list of orders
- Response code OK/200
- Response code is Json
- Json array contains number => 1, state => new
- Json array contains number => 2, state => open
- Put order number 1 state to test and check if it was successful
- Post new order and check if it was successful 



### Failure Operations

- Get order number 999
- 