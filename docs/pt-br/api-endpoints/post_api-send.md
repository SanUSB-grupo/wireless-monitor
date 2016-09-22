# `POST` `/api/send`

Endpoint para envio de dados capturados pelo dispositivo IOT.

Para cada plugin há um JSON Schema de como os dados deve ser enviados, entretanto
existe apenas o atributo `data`, que deve conter uma representação JSON.

## Parâmetros

| Atributo      | Descrição                      | Tipo
| ------------- | ------------------------------ | -------
| `data`        | Representação JSON da medição  | `String`

## Headers

| Atributo        | Valor
| --------------- | -----------------
| `Authorization` | `Bearer <token>`

## Resposta de Sucesso `HTTP 200`

| Atributo      | Descrição                      | Tipo
| ------------- | ------------------------------ | -------
| `data`        | Os próprios dados enviados     | `JSON`

### Headers

```
HTTP/1.1 200 OK
Host: localhost:8000
Connection: close
X-Powered-By: PHP/5.5.9-1ubuntu4.19
Cache-Control: no-cache
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
Date: Sun, 18 Sep 2016 19:35:58 GMT
Set-Cookie: laravel_session=eyJpdiI6IkJTaysxRWNwclVoM3ZvY0dlcldBRHc9PSIsInZhbHVlIjoiNk5OcStDZXVsZmdGYk9CZGhNQ0xEWWdzRzhReU1RS3JcL3ZoV3QwNkh5dGdnWHJBaUlGOEpxQ0JlVVNnVEJpZmZxdTQxZis4aUNtTTRmRFhzYjRcL3pwQT09IiwibWFjIjoiNzI0ZmZlNmQ2Y2MxYzBjZmQ0YjcwZDc2NjBkODE2ZTYyOWQ5N2RlMjJmYWM4ZGNjOGQ1Yzk2NWRkMWUxYTM3OCJ9; expires=Sun, 18-Sep-2016 21:35:58 GMT; Max-Age=7200; path=/; httponly
```

### Body

```json
{
    "data": {
        "value": 35
    }
}
```

### Exemplo

```bash
curl -i -X POST -H 'Content-Type: application/json' \
    -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtb25pdG9yX2tleSI6ImVjY2ViOTY4LTZhMDAtNDg0Yi04ZDY0LWNhNjY0ZjcwYmE0YyIsInN1YiI6NCwiaXNzIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2FwaVwvYXV0aGVudGljYXRlIiwiaWF0IjoxNDc0MjI1NTQ3LCJleHAiOjE0NzQyMjkxNDcsIm5iZiI6MTQ3NDIyNTU0NywianRpIjoiYjIxYTNhNjZiYWI2N2QxMTgyZThiM2ZiMTVkOTY5ZjUifQ.SiNRSXufHQNrqWC2_NbnSRrS0qtDyzlrQvWxBem10RZ' \
    -d '{"data":{"value":35}}' \
    http://localhost:8000/api/send
```

## Resposta de Erro `HTTP 400`

`monitor_key` não encontrada. Pode acontecer no caso de ter um dispositivo usando
a `monitor_key` em questão e você ter apagado o Monitor no sistema.

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
    "error_code": 10,
    "errors": [
        {
            "message": "Monitor Key '99999999-9999-9999-9999-999999999999' not found."
        }
    ]
}
```

## Resposta de Erro `HTTP 400`

Tipo do Monitor não suportado ainda. Pode acontecer quando um monitor existente
é removido do projeto, ou simplesmente não foi implementado.

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
    "error_code": 11,
    "errors": [
        {
            "message": "Monitor type 'Unknow' not supported yet."
        }
    ]
}
```

## Resposta de Erro `HTTP 400`

Conteúdo dos dados não condiz com o JSON Schema do Monitor. Cada Monitor
possui um JSON Schema que define como os dados devem ser enviados.

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
    "error_code": 12,
    "errors": [
        {
            /* ... */
        }
    ],
    "data": {
        /* ... */
    }
}
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
