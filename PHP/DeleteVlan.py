#!/usr/bin/env python
import sys
import paramiko
import json
string = ''
for word in sys.argv[1:]:
    string += word + ' '

print (string)
data2 = json.load(open("pass.json"))
jtopy2=json.dumps(data2) #json.dumps take a dictionary as input and returns a string as output.
dict_json2=json.loads(jtopy2)
ip = dict_json2["ip"]
name = dict_json2["name"]
password2 = dict_json2["pass"]
# Set the IP address, username, and password of the switch
ip = str(ip)
username = str(name)
password = str(password2)

# Create an SSH client object and connect to the switch
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect(ip, username=username, password=password)

data = json.load(open("deletevlan.json"))
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
