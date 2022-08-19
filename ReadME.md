## Tirtash

Please notice for first time it takes a bit longger than normal since it needs to download all images.
first build by run:
```` 
    docker-compose build
````

then you can run it in background by:
```
    chown -R 1000:1000 docker && docker-compose up -d
```

if you don't want to be in background you can remove the -d.

### application
http://localhost:8080/

```` 
    user: sa
    password: -+
````

### DB
use any mysql client on port 5306

```` 
    user: root
    password: root
````