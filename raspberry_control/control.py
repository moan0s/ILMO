
import json
import requests
import MFRC522
import Adafruit_GPIO.SPI as SPI
import Adafruit_SSD1306

import RPi.GPIO as GPIO
import signal
import time

from PIL import Image
try:
    from StringIO import StringIO
except ImportError:
    from io import StringIO

continue_reading = True

GPIO.setmode(GPIO.BCM)

# Raspberry Pi pin configuration:
RST = 24
# Note the following are only used with SPI:
DC = 23
SPI_PORT = 0
SPI_DEVICE = 0

key = [0xFF, 0xFF,0xFF, 0xFF, 0xFF, 0xFF]

disp = Adafruit_SSD1306.SSD1306_128_64(rst=RST)
disp.begin()
disp.clear()
library_link = "https://fs-medtech.de/bib/index.php"
image = Image.open('images/library_monochrome_small64.png').convert('1')
disp.image(image)
disp.display()

# Capture SIGINT for cleanup when the script is aborted
def end_read(signal,frame):
    global continue_reading
    print ("Ctrl+C captured, ending read.")
    continue_reading = False
    GPIO.cleanup()

# Hook the SIGINT
signal.signal(signal.SIGINT, end_read)

# Create an object of the class MFRC522
MIFAREReader = MFRC522.MFRC522()

# This loop keeps checking for chips. If one is near it will get the UID and authenticate
while continue_reading:
    
    # Scan for cards    
    (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)

    # If a card is found
    if status == MIFAREReader.MI_OK:
        print ("Card detected")
        # Get the UID of the card
        (status,uid) = MIFAREReader.MFRC522_Anticoll()

        # Clear display.
        disp.clear()
        disp.display()
        try: 
            print("Request Status")
            payload = {'ac': 'get_UID_status_bot', 'UID': str(uid)}
            r = requests.get(library_link, params=payload)
            if (r.status_code == requests.codes.ok):
                jResponse = r.json()
                print("Connection ok")
                if (jResponse['registered']):
                    if not(jResponse['present']):
                        payload = {'ac': 'presence_checkin_bot', 'UID': str(uid)}
                        r = requests.get(library_link, params=payload)
                        message = 'welcome'
                    else:
                        payload = {'ac': 'presence_checkout_bot', 'UID': str(uid)}
                        message = 'goodbye'
                        r = requests.get(library_link, params=payload)
                    print(message)
                    if message == 'welcome':
                        #image_link = "http://juli.gebuehr.net/bib/images/%s%s%s%s_monochrome_small.png"%(uid[0], uid[1], uid[2], uid[3])
                       # print ("Vor Link")
                       # image_link = "http://juli.gebuehr.net/bib/images/leander_monochrome_small.png"
                       # print("Vor Request")
                       # r = requests.get(image_link)
                       # print("Vor image op")
                       # image = Image.open(StringIO(r.content))
                        image = Image.open('images/welcome_monochrome_small.png').convert('1')
                        #print("Vor image disp")
                        disp.image(image)
                        #print("Vor disp disp")
                        disp.display()
                        time.sleep(2)
                    if message == 'goodbye':
                        image = Image.open('images/goodbye_monochrome_small.png').convert('1')
                        disp.image(image)
                        disp.display()
                        time.sleep(2)
                else:
                    print("UID is not registered")
                    image = Image.open('images/error_monochrome_small.png').convert('1')
                    disp.image(image)
                    disp.display()
                    time.sleep(2)
                    print(str(uid))
            else:
                print ("Connection Error ")
        except:
            image = Image.open('error_monochrome_small.png').convert('1')
            disp.image(image)
            disp.display()
            time.sleep(2)
        finally:
            MIFAREReader.MFRC522_StopCrypto1()
            image = Image.open('library_monochrome_small64.png').convert('1')
            disp.image(image)
            disp.display()
            time.sleep(3)
