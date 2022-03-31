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




## Available endpoints

GET /api/bays - fetching list of bays

```
response object: 
Array {
  id: number, 
  name: string,
  location: string, 
  available: boolean
}

curl -XGET 'http://localhost:8080/api/bays' 


[
  {
    "id": 2,
    "name": "bay 2",
    "location": "location 2",
    "available": true
  },
  {
    "id": 3,
    "name": "bay 3",
    "location": "location 3",
    "available": true
  },
  {
    "id": 1,
    "name": "bay 1",
    "location": "location 1",
    "available": true
  }
]
```



POST /api/booking - create booking

```
request object: 
{
  bay_id: number,
  renter: string
}


response object: 
{
  id: number, 
  bay_id: number,
  renter: string, 
  code: string
}

curl -XPOST 'http://localhost:8080/api/booking' \
  -H 'Content-Type: application/json' \
  --data-raw '{"bay_id":"1","renter":"Example User"}' \
  --compressed

{
  "id":1,
  "bay_id":1,
  "renter":"Example User",
  "code":"OCRBM"
}
```

GET /api/booking/:booking_code - find booking by code

```
response object: 
{
  id: number, 
  bay_id: number,
  renter: string, 
  code: string
}


curl -XGET 'http://localhost:8080/api/booking/OCRBM'


{
  "id":1,
  "renter":"Example User",
  "code":"OCRBM",
  "paid":false,
  "hours":0.06,
  "price":0,
  "bay_id":1
}
```



POST /api/payment - pay booking 

```
request object: 
{
  bay_id: number,
  code: string
}


response object: 
{
  id: number, 
  booking_id: number,
  duration: float, 
  amount: number
}

curl -XPOST 'http://localhost:8080/api/payment' \
  -H 'Content-Type: application/json' \
  --data-raw '{"bay_id":1,"code":"OCRBM"}' \
  --compressed

{
  "id":1,
  "booking_id":1,
  "duration":0.1,
  "amount":0
}
```




