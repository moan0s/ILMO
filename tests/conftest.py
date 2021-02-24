import pytest
import mysql.connector
import requests

import credentials

@pytest.fixture
def cursor():
    db = mysql.connector.connect(
            host=credentials.mysql['host'],
            user=credentials.mysql['user'],
            password=credentials.mysql['password'],
            database="ilmo"
            )
    cursor = db.cursor()
    yield cursor
    cursor.close()
    db.close()

@pytest.fixture
def admin_ses():
    s = requests.Session()
    payload = credentials.ilmo_admin
    payload["ac"] = "login"
    r = s.post('https://ilmo.hyteck.de/index.php', payload)
    yield s
