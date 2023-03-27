import requests


headers = {"Accept": "application/json"}
try:
     r = requests.get('HTTPS://icanhazdadjoke.com/', headers=headers, timeout=3)
except requests.exceptions.Timeout:
     print("Service is currently unavailable, please try again later")
     exit(0)

if r.ok:
     joke = r.json()
     print(joke["joke"])
     data = r.json()
     print(data)
else:
     print("No joke today!")