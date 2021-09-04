*****************
API Documentation
*****************

ILMOs API serves two different purposes. The first is to make data available to the public. The seconde is to track working hours and opening status.


Make Data Publicly Available
============================

Example Use-Case:
-----------------

You have a department/club/etc.. homepage that is run by a Content Management System like Wordpress
and want to show which books are in the library available. ILMO is hosted on a different Website.
One line of plain html code is enough to do what you want!

Simply include

.. code::

        <iframe src="https://example.com/index.php?ac=open_show_small_plain" width="100%" height="270"></iframe>

Show all books
--------------

Show all material
-----------------

Track Working Hours and Opening Status
======================================

This part of the API offers the possibility to track working hours via a suitable IoT Device (e.g.
a Raspberry Pi with NFC Reader.

.. hint::
   This part of the API has to be activated in the settings!

Example Use Case
----------------

You have a library in your that is run by two students that need to track the hours they worked.
Writing this down is way too easy and you want a live update when they are present so ILMO shows
that someone is there. ILMO offers the possibility to checkin someone via an API. You therefore
adapt the provided example script, so the students can use their student ID and a NFC reader that
is connected to a Raspberry Pi to identify and checkin themselves.
