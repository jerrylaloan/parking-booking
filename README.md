# Simple Parking App

## Prerequisite
make sure the development environment have **docker** & **docker-compose** installed. 


## Initial setup

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

- install required vendor packages 
```
docker-compose run --rm -T composer install 
```


- (more) stop the service 
```
docker-compose down
```
