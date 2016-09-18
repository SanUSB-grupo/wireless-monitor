# `GET` `/api/authenticate`

Endpoint de testes, apenas recebe um token e confirma que o usuário está
autenticado.

## Parâmetros

Nenhum.

## Headers

| Atributo        | Valor
| --------------- | -----------------
| `Authorization` | `Bearer <token>`

Substitua `<token>` pelo valor recebido em
[POST - /api/authenticate](api-endpoints/post_api-authenticate.md).

## Resposta de Sucesso `HTTP 200`

| Atributo      | Descrição                      | Tipo
| ------------- | ------------------------------ | -------
| `ok?`         | Valor `true` indicando que tudo está _ok_. | `Boolean`
| `monitor_key` | UUID | `String`

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
Date: Sun, 18 Sep 2016 19:06:30 GMT
Set-Cookie: laravel_session=eyJpdiI6IlU5Z2kwM09TVWNxU2JqYm8xMUJzaHc9PSIsInZhbHVlIjoialJ5ZnUzYUQ2c1FIRGIzQXo3ZVc0YzZEaU5sRWJnaWc1MG5Ea05Qanh1RWlqTmtWUElVdDc1OU1ucllPSWhpMmxwbklub3hiUTNUZ2hKWTM2TWdhbnc9PSIsIm1hYyI6IjYwODI5NzUxNzdiYzIwMWZhN2ZhODdjMDI5OTEyNDI2MWQ0YzIwZTI0MDBjNTgzYjg1YjEwZGUwMjA2MzEyZDAifQ%3D%3D; expires=Sun, 18-Sep-2016 21:06:30 GMT; Max-Age=7200; path=/; httponly
```

### Body

```json
{
    "ok?": true,
    "monitor_key": "ecceb968-6a00-484b-8d64-ca664f70ba4c"
}
```

### Exemplo

```bash
curl -i -X GET \
    -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtb25pdG9yX2tleSI6ImVjY2ViOTY4LTZhMDAtNDg0Yi04ZDY0LWNhNjY0ZjcwYmE0YyIsInN1YiI6NCwiaXNzIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2FwaVwvYXV0aGVudGljYXRlIiwiaWF0IjoxNDc0MjI1NTQ3LCJleHAiOjE0NzQyMjkxNDcsIm5iZiI6MTQ3NDIyNTU0NywianRpIjoiYjIxYTNhNjZiYWI2N2QxMTgyZThiM2ZiMTVkOTY5ZjUifQ.SiNRSXufHQNrqWC2_NbnSRrS0qtDyzlrQvWxBem10RY' \
    http://localhost:8000/api/authenticate
```

## Resposta de Erro `HTTP 400`

Token inválido ou mal-formado.

### Headers

```
HTTP/1.1 400 Bad Request
Host: localhost:8000
Connection: close
X-Powered-By: PHP/5.5.9-1ubuntu4.19
Cache-Control: no-cache
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 57
Date: Sun, 18 Sep 2016 19:08:48 GMT
Set-Cookie: laravel_session=eyJpdiI6Imppd0J3Z1RsSnlPTUlIUGpTTEJDNlE9PSIsInZhbHVlIjoiT0UxSW9xVThcL01tN0VlWXNlNFZ3S3VlZHFzbndwYlM5VzJtTTlReDN4bGt6WUN2Z25BVjAwbUM3clU5dlhPQnpnNWgzK0FnbEtxUHV3YnBKUE5RTkpnPT0iLCJtYWMiOiIyNjU4NzdhYzIxODg0NDdiNTRkZWQyOWQwZmRlYjk3NTlkNDIwZGRjZDFhYmJlNDU4YjQ3OWJjNjJiMDI3ODU2In0%3D; expires=Sun, 18-Sep-2016 21:08:48 GMT; Max-Age=7200; path=/; httponly
```

### Body

```json
{
    "error":"token_invalid"
}
```

## Resposta de Erro `HTTP 400`

Token não informado.

### Headers

```
HTTP/1.1 400 Bad Request
Host: localhost:8000
Connection: close
X-Powered-By: PHP/5.5.9-1ubuntu4.19
Cache-Control: no-cache
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Date: Sun, 18 Sep 2016 19:11:42 GMT
Set-Cookie: laravel_session=eyJpdiI6ImVFRFVWYk42UW5TQ3hXa01ZV3IrWnc9PSIsInZhbHVlIjoiQ3c2M1NGU1cxNTA3YkthYUNFTUNCMXlYcHVveFwvTndFZEhaTmhLZE10VnBiTXhVbExuVkZQUUltMTQ0Q3FKeHhWYTVPbnpkNEM0VzNrWTk1YlZvdlNBPT0iLCJtYWMiOiI3YTU4NjhjOWE5MTM1NmY4MzU0YWQxODMwM2Q1YzM5N2EyNDU3Y2I4ZTFmZTYzYTdhNDkzNThjNzU5Mzg5NTQwIn0%3D; expires=Sun, 18-Sep-2016 21:11:42 GMT; Max-Age=7200; path=/; httponly
```

### Body

```json
{
    "error":"token_not_provided"
}
```

## Resposta de Erro `HTTP 429`

Limite máximo de requisições por intervalo de tempo.

São `60` requisições a cada `1` minuto no máximo.

### Headers

```
HTTP/1.1 429 Too Many Requests
Host: localhost:8000
Connection: close
X-Powered-By: PHP/5.5.9-1ubuntu4.19
Cache-Control: no-cache
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 0
Retry-After: 25
Content-Type: text/html; charset=UTF-8
Date: Sun, 18 Sep 2016 19:16:55 GMT
Set-Cookie: laravel_session=eyJpdiI6ImZXZmcyNUxVaFBsOGdNSkZhR3ZTM1E9PSIsInZhbHVlIjoiS2dMREoweEhLQTBXbnpycW5rNTA2WUhra0tCRTZNZ3FLRmVvSnB4SHdlZTlHeGxYazRMaTRWNlRCN29jWXJMbmQrcmY5VVhzbWhNMHA0RWg5bmxVVmc9PSIsIm1hYyI6IjEwNWZhMDdhM2VkY2E4MDg4NDlkMTExNzYxODY4N2RiZjg1MDk2NzZkN2IxYmU5NjdlMjNmYWY4ZmJmZjE5NDUifQ%3D%3D; expires=Sun, 18-Sep-2016 21:16:55 GMT; Max-Age=7200; path=/; httponly
```

### Body

```
Too Many Attempts.
```

## Resposta de Erro `HTTP 401`

Token expirado.

### Headers

```
HTTP/1.1 401 Unauthorized
Host: localhost:8000
Connection: close
X-Powered-By: PHP/5.5.9-1ubuntu4.19
Cache-Control: no-cache
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Date: Sun, 18 Sep 2016 21:38:13 GMT
Set-Cookie: laravel_session=eyJpdiI6IjBnNGJjVmNNOW1cLzNVT1pWbUZ5NHFnPT0iLCJ2YWx1ZSI6IksxQk5EVllGUU8razBaXC9GK0tTSG02SnZvN1JXT29rTUdyZG9yVjh5N0ZFSzZSeDRyRFhUSExuZUtMSFo4TUFuRncrcWY1bUtZVkk5Slp2R1I5Snp4dz09IiwibWFjIjoiZjcwOGRlNThlODQ4YzFlZTMzN2I1NDRlOTFkNjlmOWE2MmZjMDk3MzUwZDRmYjBmY2NhYjk3ZTQzNTlhY2RkMyJ9; expires=Sun, 18-Sep-2016 23:38:13 GMT; Max-Age=7200; path=/; httponly
```

### Body

```json
{
    "error": "token_expired"
}
```
