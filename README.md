ELMO - Easy Library Management Online
==============
A software to manage a library, especially books, other material, users, emails and opening hours. Also the tracking of working hours is possible. The program is written and maintained by Julian-Samuel Gebühr.

## Requirements
This code requires PHP version 5.6.38 or higher and an SQL-Database (best results with MariaDB). 

For the tracking of workin hours you can use an RasperryPi with a RFID-Chip and display (128x64 prefered) with the following software:
Python3
SPI-Py from: https://github.com/lthiery/SPI-Py<br/>
MFRC522-Python from: https://github.com/mxgxw/MFRC522-python/ (Attention: not maintained, I made manual changes that will be published soon)<br/>
Request from http://docs.python-requests.org/en/master/<br/>
Adafruit from: https://github.com/adafruit/Adafruit_SSD13<br/>

## Installation
Clone the repository and make manual adjustments to the following files/directories
- config/
- images/
- language/ (only mail.php and library_information.php)
Also create a database. A database stub (only necesary data, for the installation of a production enviroment) and a database example (for testing purposes) is provided.

## Using the software
This software is Open-Source so you are invited to use it for free. But prehaps you need some help to adjust the software to your library or want some new features? Feel free to contact me!

## Bugs and Security
You found an error in the code, want to suggest an improvement etc..? Just put it on the Issue Tracker, I will read it!
For security issues please contact me directly, adress see below.
## Contact
You have any questions or problems concernig the software? Contact me!
E-Mail: julian-samuel@gebuehr.net



## License
This code and examples are licensed under the GNU Lesser General Public License 3.0.
