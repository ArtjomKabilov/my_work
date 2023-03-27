import json

json_sample = '''
{
     "whisky": [
     {
     "name": "Hibiki",
     "type": "Blended",
     "age": 17
     },
     {
     "name": "Old Pulteney",
     "type": "Single Malt",
     "age": 21
     }
     ],
     "stock": null,
     "alcohol": true
}
'''
data = json.loads(json_sample)
print(type(data))
print(data)

new_data = json.dumps(data)
print(type(new_data))

print(new_data)