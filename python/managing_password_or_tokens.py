import getpass
username = input("Username: ")

password = getpass.getpass()
print("\nYou entered:\nUsername: {} Password: {}".format(username, password))