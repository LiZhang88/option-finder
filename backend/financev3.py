import requests
import bs4
import string
import web
import MySQLdb
import time

root_url='http://finance.yahoo.com/q/op?s=' #first part of all url
STOCK_NAMES=[]
search_name=''
data_index=0
all_date_data=[]
def get_all_value(index_url):
    response=requests.get(index_url,allow_redirects=True)
    soup= bs4.BeautifulSoup(response.text) #Get HTML source code
    return [a.attrs.get('value') for a in soup.select('div.App-Bd option[value]')]
def get_all_data(all_value):
    global data_index
    global all_date_data
    all_date_data.append(date_data())
    response=requests.get(index_url+"&date="+all_value)
    #print index_url+"&data="+all_value
    soup=bs4.BeautifulSoup(response.text)
    #all_date_data[data_index].dates= soup.select('div.App-Bd option[value=%s]'%all_value)[0].get_text()
    # put date in array called dates
    #print all_date_data[data_index].dates
    #print data_index
    datas=soup.select('div.option_entry')
    #print datas[0].get_text()
    for i in range(0,len(datas),8): #put data in each array
        all_date_data[data_index].name.append(datas[i].get_text())
        all_date_data[data_index].last.append(datas[i+1].get_text())
        all_date_data[data_index].bid.append(datas[i+2].get_text())
        all_date_data[data_index].ask.append(datas[i+3].get_text())
        all_date_data[data_index].change.append(datas[i+4].get_text())
        all_date_data[data_index].changeR.append(datas[i+5].get_text())
        all_date_data[data_index].interest.append(datas[i+6].get_text())
        all_date_data[data_index].volatility.append(datas[i+7].get_text())
    datas=soup.select('strong') 
    for i in range(0,len(datas),2):
        all_date_data[data_index].strike.append(datas[i].get_text())
        all_date_data[data_index].volumn.append(datas[i+1].get_text())
    #print len(all_date_data[data_index].name)
    #print all_date_data[data_index].name
    data_index=data_index+1
def proccess(search_name):
     global index_url
     global data_index
     global all_date_data
     del all_date_data[:] #clean up the list
     data_index=0#reset index to 0
     index_url=root_url+search_name # set each url
     all_values=get_all_value(index_url)
     #print 'processing'
     for all_value in all_values:
         get_all_data(all_value)
         #print '.'
     print 'done\n'

class date_data: # each set of data sort by date
    dates=''
    
    def __init__(self):
        self.name=[]
        self.last=[]
        self.bid=[]
        self.ask=[]
        self.change=[]
        self.changeR=[]
        self.interest=[]
        self.volatility=[]
        self.strike=[]
        self.volumn=[]  

def store_data(all_date_data): # connection to mySQL
    name=search_name
    Rdate=time.strftime("%Y%m%d")
    len_name=len(name)    
    try:
	conn = MySQLdb.connect(host='localhost', user='lzhang',passwd='lzhangUNT',db='OptionTest')
	cur=conn.cursor()
	#cur.execute("DROP TABLE IF EXISTS %s"%name)
	cur.execute('CREATE TABLE IF NOT EXISTS %s(Rdate date,ExpDate date, Options varchar(2), Strike varchar(10), Cname varchar(25), Last varchar(10), Bid varchar(10), Ask varchar(10),Changes varchar(10),ChangeR varchar(10),OpenInt varchar(10), Vol varchar(10), IV varchar(10))'%name) 
	for i in range(0,len(all_date_data.name)):
        	ExpDate=all_date_data.name[i] [len_name:len_name+6]
    		Options='"'+all_date_data.name[i] [len_name+6]+'"'
   		Strike=all_date_data.strike[i]  
    		Cname='"'+all_date_data.name[i]+'"'
    		Last=all_date_data.last[i]
    		Bid=all_date_data.bid[i]
    		Ask=all_date_data.ask[i]
    		Changes=all_date_data.change[i]
   	 	ChangeR='"'+all_date_data.changeR[i]+'"'
    		Vol=all_date_data.volumn[i]
    		OpenInt=all_date_data.interest[i]
    		IV='"'+all_date_data.volatility[i]+'"'
		cur.execute("INSERT INTO %s(Rdate, ExpDate, Options, Strike, Cname, Last, Bid, Ask, Changes, ChangeR, Vol, OpenInt, IV) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"%(name,Rdate,ExpDate,Options,Strike,Cname,Last,Bid,Ask,Changes,ChangeR,Vol,OpenInt,IV))
  		conn.commit()  
    except MySQLdb.Error, e:

	print "Error %d:%s" %(e.args[0],e.args[1])
	#sys.exit(1)

    finally:
	conn.close()

def Read_Stock_Names():		#read StockList
	f=open('StockList.txt','r')
	line=''
	while 1:
    		line=f.readline()
    		if not line:
        		break
    		STOCK_NAMES.append(line.rstrip())
	f.close()


if __name__ == "__main__":
    Read_Stock_Names()
    for i in range (0,len(STOCK_NAMES)):
	search_name=STOCK_NAMES[i]
        print search_name
    	#proccess(search_name)
    	#for j in range (0,len(all_date_data)):
    		#store_data(all_date_data[j])
