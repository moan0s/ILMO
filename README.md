# ifs-library
==============
A software to manage a library, especially books, other material, users, emails and opening hours. Also the tracking of working hours is possible.

## Requirements
This code requires a PHP version higher than 5.6.38 and an SQL-Database (best results with MAriaDB). 

For the tracking of workin hours you need an RasperryPi with an RFID-Chip and display (128x64 prefered) with the following software:
Python3
SPI-Py from: https://github.com/lthiery/SPI-Py
MFRC522-Python from: https://github.com/mxgxw/MFRC522-python/ (Attention: not maintained, I made manual changes that will be published soon)
Request from http://docs.python-requests.org/en/master/
Adafruit from: https://github.com/adafruit/Adafruit_SSD13

## Installation
Clone the repository and make manual adjustments to the following files/directories
- config/
- settings.ini
- images/
- language/english/mail.php
Also create a database. A database stub (only necesary data, for the installation of a production enviroment) and a database example (for testing purposes) is provided


## License
This code and examples are licensed under the GNU Lesser General Public License 3.0.
