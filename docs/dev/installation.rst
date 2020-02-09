Installation
============

Requirements
------------

- A webserver (tested on Nginx)
- PHP version > 5.6.38
- SQL database (tested with MariaDB)
   As many hosting providers restrict the number of databases you can have, 
   it can be necessary to share a database with another project.
   To use this you have to set a table prefix during installation.
   
   .. warning::
      This is not recommended as other projects could influence your library!

Download the project
--------------------
You can download the newest release at `Github <https://github.com/GerJuli/ILMO/releases>`.

As an alternative you can clone the complete project from GitHub using::

   $ git clone https://github.com/GerJuli/ILMO/

Build the documentation
-----------------------
If you want to you can build the documentation. In order to do this
navigate in the folder docs/ and execute ::

   $ make

or on windows the make.bat file.

Move it to your server
----------------------

Now move the project to the servers document root (or any other directory that can be accessed by
your webserver). 

.. warning::
   Exclude the docs/ folder from the server copy. They are not needed for the project to work.

Basic configuration
-------------------
The basic configuration can be done in the browser.
Open https://yourdomain.com and follow the given instructions:

1. Configure database
2. Create first user
3. Delete the install/ directory
