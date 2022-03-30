# Laravel server 

The server for parking booking app


## Useful commands


Run migration

```bash
docker-compose run --rm -T artisan migrate
```

Run tests

```bash
docker-compose run --rm -T artisan test # all tests
```

```bash
docker-compose run --rm -T artisan test --testsuite={{Feature|Unit}} --stop-on-failure # only specific test suites
```


Access database

```bash
docker-compose exec postgres bash -c 'psql -d parking_database -U parking_root -W'

password: Test12345!
```