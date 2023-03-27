import requests

headers = {
 'content-type': 'application/json',
 'x-auth-token': 'c3RlZjpleHRyZW1l'
}

r = requests.get("HTTPS://httpbin.org/get", headers=headers)

print("Headers sent: ", r.request.headers)
print("\nHeaders received: ", r.headers)