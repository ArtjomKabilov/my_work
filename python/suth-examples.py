import os


username = os.environ.get('USERNAME')
password = os.environ.get('PASSWORD')

print("Username is: {}\nPassword is: {}".format(username, password))