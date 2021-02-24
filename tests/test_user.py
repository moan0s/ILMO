import pytest
import requests
from time import sleep



def test_user(cursor, admin_ses):
    url = 'https://ilmo.hyteck.de/index.php'
    user = {"forename": "F1",
            "surname": "S1",
            "email": "test@hyteck.de"}

    # Check database for user
    query = (f"SELECT forename, surname, email FROM user WHERE forename='{user['forename']}' AND  surname='{user['surname']}' AND email='{user['email']}';")
    cursor.execute(query)
    num_user_begin = len(cursor.fetchall())
    print(num_user_begin)

    # Add user vie POST reqest
    payload = user
    payload['ac'] = 'user_save'
    x = admin_ses.post(url, data = payload)

    sleep(5)
    # Check database again for user
    cursor.execute(query)
    users = cursor.fetchall()
    num_user = len(users)
    print(users)
    assert(num_user > num_user_begin)

