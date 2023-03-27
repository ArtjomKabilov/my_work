from urllib import request
resp = request.urlopen('HTTPS://www.ekool.ee')

print(resp.code)
print(resp.length)
data = resp.read()
print(type(data))
print(len(data))