Customization
-------------

Settings
^^^^^^^^

When opening the file :file:`config/settings.ini` with a text editor
you can adjust the following:

- ``timezone = 'Europe/Berlin'``
   Timezone as supported by php see the `PHP documentation
   <https://www.php.net/manual/en/timezones.php>`_ e.g. `'Europe/Berlin``
- ``enable_status = 1``
   enable/disable status bar that indicates if the library is open
- ``enable_presence_API = 1``
   enable/disable presence API (used for tracking working hours)
- ``max_loan_time = 0``
   Maximum time of loan: Set to 0 for infinite
- ``mail_reminder_interval = 90``
   Interval of the e-mail reminder: Days after the user is reminded of a loan which is not returned
- ``default_langage = german``
   Default language. Pick between ``german`` and ``english``
- ``log_mail = 0``
   If the e-mails that are sent should be logged
- ``path_to_mail_log = "log/mail.log``
   The path to the logfile for sent mails
- ``opening_days[] = monday``
   For every day of the week where the library is open, add a line



Images
^^^^^^

To customize the images just replace the images in :file:`images/`.

E.g. if you want to replace the header image replace the file :file:`images/logo_library.png`.
