Release
-------------

What qualifies as release?
^^^^^^^^^^^^^^^^^^^^^^^^^^

A new release should be announced when a significant number functions, bugfixes or other improvements to the software is made. Usually this indicates a minor release. Major releases are yet to be determined.

What should be done before a release?
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Tested basic functions
######################

* Installation
* User, book and material management (create, view, change, delete)
* Logging (e.g. mail log)
* E-Mails
* Monitoring

Test upgrade on a copy of a production database
###############################################

.. WARNING::
        You have to prevent e-mails from beeing sent, otherwise users could recive duplicate e-mails!

* Ensure correct conversion if neccessary
* Views correct?

Release
^^^^^^^

Âfter testing everything you are good to go. Open the file :file:`config/settings.ini` with a text editor
you can adjust the version number:

.. code::
    ...
    "path_mail_log": "log/mail.log",
    "timezone": "Europe/Berlin",
    "version": "1.3"
    ...
Do a final commit on this change, and tag the commit as release with appropriate version number.

.. code::
    git tag -a v1.0.0 -m "Releasing version v1.0.0"
    git push origin v1.0.0

Make sure the tag is visible on GitHub and celebrate 🥳
