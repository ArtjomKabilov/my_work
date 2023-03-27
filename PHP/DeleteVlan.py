#!/usr/bin/env python
import sys
import paramiko
import json
string = ''
for word in sys.argv[1:]:
    string += word + ' '

print (string)
# Set the IP address, username, and password of the switch
ip = '10.181.2.210'
username = 'admin'
password = '123123'

# Create an SSH client object and connect to the switch
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect(ip, username=username, password=password)

data = json.load(open("C:/Users/POPOV/Desktop/This_is_for_my_practice-main/python/deletevlan.json"))
jtopy=json.dumps(data) #json.dumps take a dictionary as input and returns a string as output.
dict_json=json.loads(jtopy)

id = dict_json["id"]
# Send the reboot command to the switch
stdin, stdout, stderr = client.exec_command("delete vlan "+ str(id))
stdin, stdout, stderr = client.exec_command("show vlan")
# Wait for the command to finish executing
#stdout.channel.recv_exit_status()
output = stdout.read().decode()
print(output)
# Close the SSH connection
client.close()

print('Success.')
