#!/usr/bin/env python
# -*- coding: iso-8859-1 -*- 

#import serial
import re
import sqlite3

# sqlite Einbindung 
conn = sqlite3.connect('/var/www/energie/test1.db')
cursor = conn.cursor()
#Vorbereitung Liste für Weitergabe Messwerte
extrakt = []
#mymist = []
with open ("Ausgabe-3-ElsterA1500") as fp:
	for line in fp:
		match = re.search(r'(0\.0\.0|1\.6\.1|1\.8\.1)\(([0-9\.]+)', line)
		if match: 
			version,value = match.groups() 
			extrakt.append(value)
#print extrakt
cursor.execute('INSERT INTO energielog (sernr, peak, kwh) values (?, ?, ?)', extrakt)
		
#for item in extrakt:
#	print item
#	cursor.executemany('INSERT INTO energielog values (?,?,?,?)', None, item, item, item)
#		mylist.append(value)
#		mymist.append(version)

#print extrakt
#for item in mylist:
#	cursor.execute('INSERT INTO energielog (sernr,peak,kwh) values (?,?,?)', (+ item))
#	t = (item)
#	print t
#	t = line
#	print t[0:3]
#print value
#	cursor.executemany('INSERT INTO energielog(sernr,peak,kwh) values (?,?,?)', [t,t,t])
#	cursor.execute('INSERT INTO energielog(sernr,peak,kwh) values (?,?,?)', [t])
#	cursor.execute('INSERT INTO energielog(sernr) values (?)', [t])
#	cursor.execute('INSERT INTO energielog(peak) values (?)', [t])
#	cursor.execute('INSERT INTO energielog(kwh) values (?)', [t])
#	cursor.execute('INSERT INTO energielog(kwh) values (?)', ((None,) +i)
#	cursor.execute('INSERT INTO energielog values (?,?,?,?)',(None,i))
#	cursor.executemany('INSERT INTO energielog values (?,?,?)', item)
#	cursor.execute("INSERT INTO energielog(sernr) values (?)",(t(0),));
#	cursor.execute("INSERT INTO energielog(peak) values (?)",(t(1),));
#	cursor.execute("INSERT INTO energielog(kwh) values (?)",(t(2),));


conn.commit()
cursor.close()
conn.close()
