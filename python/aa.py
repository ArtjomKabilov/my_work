import argparse


def getParams():
    parser = argparse.ArgumentParser(prog='param')
    parser.add_argument('-i', '--remote_address',
                        help='Remote IP address to ping',
                        action='append',
                        required=True)
    parser.add_argument('-p', '--policy',
                        help='Name of ACL policy',
                        required=True)
    parser.add_argument('-f', '--from_address',
                        help="'From' IP address in ping command")
    parser.add_argument('-r', '--virtual_router',
                        help='Virtual Router used for ping')

    args = parser.parse_args()
    return args

if __name__ == '__main__':
    try:
        print (getParams())
    except SystemExit:
         pass