**Setup**



*Composer*

https://getcomposer.org/download/



*Codeception*

```bash
composer require --dev "codeception/codeception"
composer require --dev "codeception/module-asserts"
composer require --dev "codeception/module-db"
composer require --dev "codeception/module-rest"
composer require --dev "codeception/module-phpbrowser"
vendor/bin/codecept bootstrap
vendor/bin/codecept generate:test unit controller
vendor/bin/codecept generate:suite api
vendor/bin/codecept generate:cest api dbproject
```

*tests/unit.suite.yml*

```bash
actor: UnitTester
modules:
    enabled:
        - Asserts
        - \Helper\Unit
        - Db:
            dsn: 'mysql:host=127.0.0.1;dbname=dbproject'
            user: 'root'
            password: ''
            dump: 'tests/_data/testdb.sql'
            populate: true # run populator before all tests
            cleanup: true

```

