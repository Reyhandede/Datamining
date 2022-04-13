import http.client
from csv import DictWriter
import json

conn = http.client.HTTPSConnection("api.collectapi.com")

headers = {
    'content-type': "application/json",
    'authorization': "apikey 7GiUiA1JW1F8AIm2LQr9Oe:2ksOFvyKlrhY4bZAzrixOn"
    }

with open('haber.csv','w') as outfile:
    writer = DictWriter(outfile, ('key','url','description','image','name','source','date'))
    writer.writeheader()
    for i in range(1,51):
        pg="&padding=%s" % i
        conn.request("GET", "/news/getNews?country=tr&tag=general%s"%pg, headers=headers)
        res = conn.getresponse()
        data = res.read()
        data=data.decode("utf-8")  
        data=json.loads(data)
        data=data["result"]
        writer.writerows(data)
with open('haber.csv') as inputfile, open('haber_edit.csv', 'w') as outputfile:
    for line in inputfile:
        if not line.strip():
            continue
        outputfile.write(line)
