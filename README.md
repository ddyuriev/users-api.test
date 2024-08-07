### Шаги по установке

    composer install
    php artisan migrate
    cp .env.example .env

### Тестирование
    php artisan config:clear
    php artisan test


### Документация
```bash
    php artisan l5-swagger:generate
```
#### будет доступна тут: http://localhost:8000/api/documentation



### Примеры запросов к API
#### GET /api/user?page=1&perPage=10

```bash
curl -X GET "http://localhost:8000/api/user?page=1&perPage=10"
```
```json
{
    "is_success": true,
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "johndoe@example.com",
            "email_verified_at": "2024-08-07T20:46:24.000000Z",
            "created_at": "2024-08-07T20:46:24.000000Z",
            "updated_at": "2024-08-07T20:46:24.000000Z"
        },
        ...
    ]
}
```

#### GET /api/user/{id}
```bash
curl -X GET "http://localhost:8000/api/user/1"
```
```json
{
    "is_success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "johndoe@example.com",
        "email_verified_at": "2024-08-07T20:46:24.000000Z",
        "created_at": "2024-08-07T20:46:24.000000Z",
        "updated_at": "2024-08-07T20:46:24.000000Z"
    }
}
```

#### POST /api/user
```bash
curl -X POST "http://localhost:8000/api/user" -H "Content-Type: application/json" -d "{\"name\": \"name8\", \"email\": \"name8@mail.ru\", \"password\": \"11111112\"}"
```
```json
{
    "is_success": true,
    "data": {
        "name": "name8",
        "email": "name8@mail.ru",
        "created_at": "2024-08-07T20:46:24.000000Z",
        "updated_at": "2024-08-07T20:46:24.000000Z",
        "id": 1530
    }
}
```

#### PUT /api/user/{id}
```bash
curl -X PUT "http://localhost:8000/api/user/155" -H "Content-Type: application/json" -d "{\"name\": \"name44\", \"email\": \"name441@mail.ru\", \"password\": \"11111112\"}"
```
```json
{
    "is_success": true,
    "data": {
        "id": 1,
        "name": "name44",
        "email": "name441@mail.ru",
        "created_at": "2024-08-07T20:46:24.000000Z",
        "updated_at": "2024-08-07T20:46:24.000000Z"
    }
}
```

#### DELETE /api/user/{id}
```bash
curl -X DELETE "http://localhost:8000/api/user/1"
```
```json
{
    "is_success": true
}
```
