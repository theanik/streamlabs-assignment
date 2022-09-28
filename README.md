# Advanced Stream Stats


## Installation
```bash
  sh build.sh
```

##### You can change your NGINX and PHPMYADMIN PORT in .env and Set username and password for database. Make sure you have restart docker compose after change .env value

### Implemented API ENDPOINTS

```bash
   - Auth
        1. [POST] 
            /api/v1/login
        2. [POST] 
            /api/v1/register
        3. [POST]  
            /api/v1/logout
   - User
        1. [POST] 
            /api/v1/profile
  - Plans
        1. [GET] 
            /api/v1/plans
        2. [GET]  
            /api/v1/plan/{prlan:id}
            
  - Payment and subscription
        1. [GET] 
            /api/v1/braintree-token
        2. [GET]  
            /api/v1/checkout
        3. [GET] 
            /api/v1/user-subscription
        4. [POST]  
            /api/v1/cancel-subscription
            
```

### Browse Application

```bash
    http://127.0.0.1:8080
```

### Browse phpmyadmin
```bash
    http://127.0.0.1:9090
```
