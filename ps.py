import sys

from pypsexec.client import Client

host = sys.argv[1]
user = sys.argv[2]
pw = sys.argv[3]

print(len(sys.argv))

c = Client(host, username=user, password=pw)

c.connect()

try:
    c.create_service()

    stdout, stderr, rc = c.run_executable("cmd.exe",
                                          arguments="/c echo Hello World",
                                          interactive_session=True)
finally:
    c.remove_service()
    c.cleanup()
    c.disconnect()


