# `GET` `/api/refresh-token`

Endpoint para obter novo token a partir de um existente e válido. Deve ser
chamado de tempos em tempos para continuar consultando a API visto
que tokens tem data de validade e limite de requisições.

**Obs.**: pode ser usado via parâmetro ou por Header, tanto faz.

## Parâmetros

| Atributo      | Descrição                      | Tipo
| ------------- | ------------------------------ | -------
| `token`       | Token JWT | `String`

## Headers

| Atributo        | Valor
| --------------- | -----------------
| `Authorization` | `Bearer <token>`

Substitua `<token>` pelo valor recebido em
[POST - /api/authenticate](post_api-authenticate.md).

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
curl -i -X GET -H 'Content-Type: application/json' \
    -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtb25pdG9yX2tleSI6ImVjY2ViOTY4LTZhMDAtNDg0Yi04ZDY0LWNhNjY0ZjcwYmE0YyIsInN1YiI6NCwiaXNzIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2FwaVwvYXV0aGVudGljYXRlIiwiaWF0IjoxNDc0MjI1NTQ3LCJleHAiOjE0NzQyMjkxNDcsIm5iZiI6MTQ3NDIyNTU0NywianRpIjoiYjIxYTNhNjZiYWI2N2QxMTgyZThiM2ZiMTVkOTY5ZjUifQ.SiNRSXufHQNrqWC2_NbnSRrS0qtDyzlrQvWxBem10RZ' \
    http://localhost:8000/api/refresh-token
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
