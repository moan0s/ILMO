ILMO - Intelligent Library Management Online
==============
A software to manage a library, especially books, other material, users, emails and opening hours. Also the tracking of working hours is possible. The program is written and maintained by Julian-Samuel Gebühr.

## Requirements
This code requires PHP version 5.6.38 or higher and an SQL-Database (best results with MariaDB). PHP-mbstring has to be available.

For the tracking of workin hours you can use an RasperryPi with a RFID-Chip and display (128x64 prefered) with the following software:
Python3
SPI-Py from: https://github.com/lthiery/SPI-Py<br/>
MFRC522-Python from: https://github.com/mxgxw/MFRC522-python/ (Attention: not maintained, I made manual changes that will be published soon)<br/>
Request from http://docs.python-requests.org/en/master/<br/>
Adafruit from: https://github.com/adafruit/Adafruit_SSD13<br/>

## Installation

1. Download the newest release
2. Move the files to your server's document root
3. Open your browser and visit your domain
4. You should now see a form where you insert your database credentials and some more information.
If your installation shall be in a subfolder, add this in module path. E.g. if your installation is on https://example.com/ILMO type in "/ILMO".
Make sure that the database user is allowed to create a database or has priviliges to work with the given database.
5. Add your first user (has to be an admin to add more users later!)
6. Delete the folder "install/" from your server.
7. Have fun! Add user and books etc..

You will also want to make manual adjustments to the following files/directories
- config/settings.ini
- images/
- language/ (only mail.php and library_information.php)

## Using the software

This software is Open-Source so you are invited to use it for free. But prehaps you need some help to adjust the software to your library or want some new features? Feel free to contact me!

## Bugs and Security
You found an error in the code, want to suggest an improvement etc..? Just put it on the Issue Tracker, I will read it!
For security issues please contact me directly, adress see below.

## Contact
You have any questions or problems concernig the software? Contact me!
E-Mail: julian-samuel@gebuehr.net



## License
This code and examples are licensed under the GNU General Public License 3.0.
