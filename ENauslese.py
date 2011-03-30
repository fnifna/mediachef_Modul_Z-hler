#!/usr/bin/env python
# -*- coding: iso-8859-1 -*- 

import serial
import time
import re
import sqlite3

# serielle USB-Schnittstelle öffnen
ser = serial.Serial()
ser.baudrate = 300
ser.port = '/dev/ttyUSB0'     
ser.timeout = 20 #20
ser.parity = serial.PARITY_EVEN
ser.stopbits = serial.STOPBITS_ONE
ser.bytesize = serial.SEVENBITS
#ser = serial.Serial('/dev/ttyUSB0', 300, bytesize=serial.SEVENBITS, parity=serial.PARITY_EVEN, stopbits=serial.STOPBITS_ONE, timeout=2)
ser.open()
ser.isOpen()

# Zählerabfrage initiieren mit /?!
time.sleep(2)
ser.write("/?!")
#time.sleep(0.01)     #1ms = 0.001 war im cutecom eingestellt und hat funktioniert
ser.write("\r\n")       #CR LF? \r\n
time.sleep(2)

# sqlite Einbindung vorbereiten
connection = sqlite3.connect('/var/www/zaehler/test1.db')
cursor = connection.cursor()
extrakt = []

#line = ser.readline(eol='!')
#print line - would work   
#for line in ser.readline(eol='!'):
ser.readline(eol='!') = z
for line in z:
                match = re.search(r'(0\.0\.0|0\.9\.1|0\.9\.2|1\.6\.1|1\.8\.1)\(([0-9\.]+)', line)
                if match: 
                        version,value = match.groups() 
                        extrakt.append(value)
#print extrakt
cursor.execute('INSERT INTO energielog (sernr, time, date, peak, kwh) values (?, ?, ?, ?, ?)', extrakt)
# Save (commit) the changes
connection.commit()

ser.close()
cursor.close()
connection.close()
