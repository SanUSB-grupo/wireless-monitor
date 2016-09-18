# `POST` `/api/authenticate`

Endpoint de autenticação, deve ser sempre chamado antes de qualquer iteração.

## Parâmetros

| Atributo      | Descrição                      | Tipo
| ------------- | ------------------------------ | -------
| `api_key`     | UUID que identifica o usuário  | `String`
| `monitor_key` | UUID que identifica o monitor  | `String`

## Resposta de Sucesso `HTTP 200`

| Atributo      | Descrição                      | Tipo
| ------------- | ------------------------------ | -------
| `token`       | Token JWT, a ser usado nas próximas requisições | `String`

### Headers

```
HTTP/1.1 200 OK
Host: localhost:8000
Connection: close
X-Powered-By: PHP/5.5.9-1ubuntu4.19
Cache-Control: no-cache
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Date: Sun, 18 Sep 2016 18:17:04 GMT
Set-Cookie: laravel_session=eyJpdiI6IlwvZnE1cmpmS2FaQzkyZXArdVg0VVBRPT0iLCJ2YWx1ZSI6IklDUzI2VHRaWVBlczlOUHozeHdVZXRodFptdXk5V1FUUTBHajA3V0MwNG5XdFRhS3RGZWZKeVdKWGZoaVpFSFBINWgwR2oxeDZ3QVUyK0VqUkRUSWZRPT0iLCJtYWMiOiI3ZTc3OTcwNTg0MWY0MzY3MWI2ODI4ODk3ZDBkMWZhNjI5ZjlmMzFhNDQzZThjYzczMzQxYjA2NGIxMDU2YjczIn0%3D; expires=Sun, 18-Sep-2016 20:17:04 GMT; Max-Age=7200; path=/; httponly
```

### Body

```json
{
    "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtb25pdG9yX2tleSI6ImVjY2ViOTY4LTZhMDAtNDg0Yi04ZDY0LWNhNjY0ZjcwYmE0YyIsInN1YiI6NCwiaXNzIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2FwaVwvYXV0aGVudGljYXRlIiwiaWF0IjoxNDc0MjIyNjI0LCJleHAiOjE0NzQyMjYyMjQsIm5iZiI6MTQ3NDIyMjYyNCwianRpIjoiNzc3M2JiNzEyMWE1MzYzNzVjZDJhMzNjYzk3MzFmOWMifQ.D8uoI5HK69WWseaUCep-BA_rf813uD-QGmeFLcCfupU"
}
```

### Exemplo

```bash
curl -i -X POST -F 'api_key=9f974bd3-8377-436f-a6f2-62b6f03a65e4' \
    -F 'monitor_key=ecceb968-6a00-484b-8d64-ca664f70ba4c' \
    http://localhost:8000/api/authenticate
```

## Resposta de Erro `HTTP 401`

Usuário não autorizado, provavelmente erro em suas credenciais, seja `api_key` ou
`monitor_key`.

### Headers

```
HTTP/1.1 401 Unauthorized
Host: localhost:8000
Connection: close
X-Powered-By: PHP/5.5.9-1ubuntu4.19
Cache-Control: no-cache
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
Date: Sun, 18 Sep 2016 18:39:19 GMT
Set-Cookie: laravel_session=eyJpdiI6InlDUmJBckc4NEgzVzVEc0MxSjVJTUE9PSIsInZhbHVlIjoiK2lxMkdoT01EMFZNK2JCdUFcLzQ0ZEVMWTRSeXFOWlFpUVhXZkw5VXBpUzdwcm1KV00zcndha25tNkpINVBwd1NGblJjb3NtK1BENXE5NFVxZzJYamd3PT0iLCJtYWMiOiJiZjY0MWUxNmZmZWYwYzU5ZjA0MzUxNjgxOWQzYWE3MjcxZTg5ZWI2MzRhOTcyYjg1NmZhNzBkNzA1MjA3MGFkIn0%3D; expires=Sun, 18-Sep-2016 20:39:19 GMT; Max-Age=7200; path=/; httponly
```

### Body

```json
{
    "error":"invalid_credentials"
}
```
