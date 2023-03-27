import paramiko
import json

# Set the IP address, username, and password of the switch
ip = '10.181.2.210'
username = 'admin'
password = '123123'

# Create an SSH client object and connect to the switch
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect(ip, username=username, password=password)

data = json.load(open("C:/Users/POPOV/Desktop/This_is_for_my_practice-main/python/data.json"))
jtopy=json.dumps(data) #json.dumps take a dictionary as input and returns a string as output.
dict_json=json.loads(jtopy)

vlan = dict_json["vlan"]
tag = dict_json["tag"]
# Send the reboot command to the switch
stdin, stdout, stderr = client.exec_command("show vlan")

# Wait for the command to finish executing
#stdout.channel.recv_exit_status()

# Close the SSH connection
client.close()

print('Success.')
