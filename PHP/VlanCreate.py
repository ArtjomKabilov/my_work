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
password = '123123123'

# Create an SSH client object and connect to the switch
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect(ip, username=username, password=password)

data = json.load(open("C:/Users/artem/Desktop/my_work-main/python/data.json"))
jtopy=json.dumps(data) #json.dumps take a dictionary as input and returns a string as output.
dict_json=json.loads(jtopy)

vlan = dict_json["vlan"]
tag = dict_json["tag"]
ip = dict_json["ip"]
mask = dict_json["mask"]
port = dict_json["port"]
# Send the reboot command to the switch
stdin, stdout, stderr = client.exec_command("create vlan "+ str(vlan) +" tag "+ str(tag) +" ")
stdin, stdout, stderr = client.exec_command("configure vlan "+ str(vlan) +" add ports "+ str(port) +" tagged")
stdin, stdout, stderr = client.exec_command("configure vlan "+ str(vlan) +" ipaddress "+ str(ip) +"/"+ str(mask) +"")
stdin, stdout, stderr = client.exec_command("show vlan")
# Wait for the command to finish executing
#stdout.channel.recv_exit_status()
output = stdout.read().decode()
print(output)
# Close the SSH connection
client.close()

print('Success.')
