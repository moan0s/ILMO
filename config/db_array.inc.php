
<?php
$aData['lib_books'] = array(
		'book_ID' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'unique' => 'TRUE',
			'standard' => 'NOT NULL',
			'extra' => 'PRIMARY KEY'
		),
		'title' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'author' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'location' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'lent' => array(
			'type' => 'TINYINT',
			'size' => 1,
			'standard' => 'NOT NULL'
		)
	);

$aData['lib_loan'] = array(
		'loan_ID' => array(
			'type' => 'INT',
			'size' => 11,
			'unique' => 'TRUE',
			'standard' => 'NOT NULL',
			'extra' => 'AUTO_INCREMENT PRIMARY KEY'
		),
		'type' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'ID' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'user_ID' => array(
			'type' => 'INT',
			'size' => 11,
			'standard' => 'NOT NULL'
		),
		'pickup_date' => array(
			'type' => 'DATE',
			'standard' => 'NOT NULL'
		),
		'return_date' => array(
			'type' => 'DATE',
			'standard' => 'NOT NULL'
		),
		'last_reminder' => array(
			'type' => 'DATE',
			'standard' => 'NOT NULL'
		),
		'returned' => array(
			'type' => 'TINYINT',
			'size' => 1,
			'standard' => 'NOT NULL'
		)
	);

$aData['lib_log'] = array(
		'issue' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL',
			'unique' => 'TRUE',
			'extra' => 'PRIMARY KEY'
		),
		'date' => array(
			'type' => 'DATE',
			'standard' => 'NOT NULL'
		)
	);

$aData['lib_material'] = array(
		'material_ID' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'unique' => 'TRUE',
			'standard' => 'NOT NULL',
			'extra' => 'PRIMARY KEY'
		),
		'name' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'location' => array(
			'type' => 'VARCHAR',
			'size' => 255,
		),
		'lent' => array(
			'type' => 'TINYINT',
			'size' => 1,
			'standard' => 'NOT NULL'
		)
	);
$aData['lib_open'] = array(
		'day' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'unique' => 'TRUE',
			'standard' => 'NOT NULL',
			'extra' => 'PRIMARY KEY'
		),
		'start' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'end' => array(
			'type' => 'VARCHAR',
			'size' => 255,
		),
		'notice' => array(
			'type' => 'VARCHAR',
			'size' => 255,
		)
	);
$aData['lib_presence'] = array(
		'presence_ID' => array(
			'type' => 'INT',
			'size' => 11,
			'unique' => 'TRUE',
			'standard' => 'NOT NULL',
			'extra' => 'AUTO_INCREMENT PRIMARY KEY'
		),
		'UID' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'checkin_time' => array(
			'type' => 'TIMESTAMP',
			'standard' => 'NOT NULL',
			'extra' => 'DEFAULT current_timestamp()'
		),
			'checkout_time' => array(
			'type' => 'TIMESTAMP',
			'standard' => 'NOT NULL',
			'extra' => "DEFAULT '0000-00-00 00:00:00'"
		)
	);




$aData['lib_user'] = array(
		'user_ID' => array(
			'type' => 'INT',
			'size' => 11,
			'unique' => 'TRUE',
			'standard' => 'NOT NULL',
			'extra' => 'AUTO_INCREMENT PRIMARY KEY'

		),
		'password' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'surname' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'forename' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'email' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'UID' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'language' => array(
			'type' => 'VARCHAR',
			'size' => 255,
			'standard' => 'NOT NULL'
		),
		'admin' => array(
			'type' => 'TINYINT',
			'size' => 1,
			'standard' => 'NOT NULL',
			'extra' => 'DEFAULT 0'
		)
	);





