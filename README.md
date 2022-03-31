# Simple Parking App

## Prerequisite
make sure the development environment have **docker** & **docker-compose** installed. 


## First time setup (notes: do this in /server directory)

- navigate to `/server` directory

- build the images
```
sudo docker-compose build
```

- run the service 
```
docker-compose up -d    # spawn container

(optional)
docker-compose logs -f    # show container logs
```

- run migration
```
docker-compose run --rm -T artisan migrate
```

after running the setup above you can continue to run client apps.


- (more) stop the service 
```
docker-compose down
```



## Running client apps (notes: do this in /client directory)

- navigate to `/client` directory

- install dependencies
```
yarn install
```

- start the app
```
yarn start
```





