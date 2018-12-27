

import importlib
import requests
import MFRC522
import Adafruit_GPIO.SPI as SPI
import Adafruit_SSD1306

import RPi.GPIO as GPIO
import signal
import time

from PIL import Image

continue_reading = True

GPIO.setmode(GPIO.BCM)

# Raspberry Pi pin configuration:
RST = 24
# Note the following are only used with SPI:
DC = 23
SPI_PORT = 0
SPI_DEVICE = 0

key = [0xFF, 0xFF,0xFF, 0xFF, 0xFF, 0xFF]
MedTech_online = [0x21, 0x4D, 0x65, 0x64, 0x54, 0x65, 0x63, 0x68, 0x5F, 0x6F, 0x6E, 0x6C, 0x69, 0x6E, 0x65, 0x21]
MedTech_offline = [0x21, 0x4D, 0x65, 0x64, 0x54, 0x65, 0x63, 0x68, 0x5F, 0x6F, 0x66, 0x66, 0x6C, 0x69, 0x6E, 0x65]

disp = Adafruit_SSD1306.SSD1306_128_64(rst=RST)
disp.begin()
disp.clear()
image = Image.open('library_monochrome_small64.png').convert('1')
#image = Image.open('library_monochrome_small64.png').convert('1')
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
                
            if status == MIFAREReader.MI_OK:
                MIFAREReader.MFRC522_SelectTag(uid)
                status = MIFAREReader.MFRC522_Auth(MIFAREReader.PICC_AUTHENT1A, 8, key, uid)
                
                if status == MIFAREReader.MI_OK:
                    #CurrentSector8
                    sector8 = MIFAREReader.MFRC522_Read(8)
                    if sector8 == MedTech_online: 
                        to_write = MedTech_offline
                        link = "http://juli.gebuehr.net/bib/index.php?ac=presence_checkout_bot&UID="+str(uid)
                        message = 'goodbye'
                    else:
                        to_write = MedTech_online
                        link = "http://juli.gebuehr.net/bib/index.php?ac=presence_checkin_bot&UID="+str(uid)
                        message = 'welcome'
                    if status == MIFAREReader.MI_OK:
                        if MIFAREReader.MFRC522_Write(8, to_write):
                            r = requests.get(link)
                            print(message)
                            if message == 'welcome':
                                image = Image.open('welcome_monochrome_small.png').convert('1')
                                disp.image(image)
                                disp.display()
                                time.sleep(2)
                            if message == 'goodbye':
                                image = Image.open('goodbye_monochrome_small.png').convert('1')
                                disp.image(image)
                                disp.display()
                                time.sleep(2)
                        else: 
                            raise Exception('The writing on the chip failed')
                else:
                    raise Exception('The xxx failed')
            else:
                raise Exception('The authentification failed')
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
