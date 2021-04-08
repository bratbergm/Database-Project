##### Definitions of implemented test cases



## Unit Test Cases

### Successful Operations

##### Order Endpoint

- Tests if GET order number 1 is a valid endpoint
- Tests if order number 1 exists
- Tests how many orders have state 'new'. 2 does.
- Tests if possible to create new order

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

### API Test Cases

#### Successful Operations

- Get orders with state = new
- Response code OK/200
- Response code is Json
- Json array contains number => 1, state => new
- Json array contains number => 2, state => open