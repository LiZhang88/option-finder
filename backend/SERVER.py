import socket
import MySQLdb
import string
from datetime import datetime

def store_data(array): # connection to mySQL   
    try:
	conn = MySQLdb.connect(host='localhost', user='lzhang',passwd='lzhangUNT',db='sensor')
	cur=conn.cursor()
	if array[4]=='':
		array[4]='0' 
        print("INSERT INTO sensor(local,co,no2,pm,temp)VALUES('m1','%s','%s','%s','%s')"%(array[0].strip(),array[1].strip(),array[4].strip(),array[2].strip()))
	cur.execute("INSERT INTO sensor(local,co,no2,pm,temp)VALUES('m1',%s,%s,%s,%s)"%(array[0],array[1],array[4],array[2]))
  	conn.commit()  
    except MySQLdb.Error, e:

	print "Error %d:%s" %(e.args[0],e.args[1])
	#sys.exit(1)

    finally:
	conn.close()
 
HOST, PORT = '', 8913 
listen_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
listen_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
listen_socket.bind((HOST, PORT))
listen_socket.listen(1)

while True:
    client_connection, client_address = listen_socket.accept()
    client_connection.settimeout(15)
    
    try:
    	request = client_connection.recv(1024)
    except socket.error as msg:
	client_connection.close()
	print 'abandon connection'
    	continue
    if not request:
	client_connection.close()
	continue
    f=open('serlog','a')
    f.write(str(datetime.now()))
    res_array=request.decode().split(",")
    store_data(res_array)
    #f.write(request.decode()+'\n') 
    f.close()
    http_response = """
	Received
	"""
    client_connection.sendall(http_response)
    client_connection.close()

