import socket

HOST='localhost'
PORT=11111

message = "Hello World!"

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST,PORT))
s.send(message)
data = s.recv(1300)
s.close()
print data