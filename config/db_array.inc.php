
<?php
require_once(__dir__."/config.inc.php");
$aData[TABLE_BOOKS] = array(
        'book_idx' => array(
            'type' => 'INT',
            'size' => 1,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL',
            'extra' => 'AUTO_INCREMENT PRIMARY KEY'
        ),

        'book_ID' => array(
            'type' => 'VARCHAR',
            'size' => 255,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL'
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

$aData[TABLE_LOAN] = array(
        'loan_idx' => array(
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

$aData[TABLE_LOG] = array(
        'log_idx' => array(
            'type' => 'INT',
            'size' => 1,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL',
            'extra' => 'AUTO_INCREMENT PRIMARY KEY'
        ),
        'issue' => array(
            'type' => 'VARCHAR',
            'size' => 255,
            'standard' => 'NOT NULL',
            'unique' => 'TRUE'
        ),
        'date' => array(
            'type' => 'DATE',
            'standard' => 'NOT NULL'
        )
    );

$aData[TABLE_MATERIAL] = array(
        'material_idx' => array(
            'type' => 'INT',
            'size' => 1,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL',
            'extra' => 'AUTO_INCREMENT PRIMARY KEY'
        ),
        'material_ID' => array(
            'type' => 'VARCHAR',
            'size' => 255,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL'
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
$aData[TABLE_OPEN] = array(
        'open_idx' => array(
            'type' => 'INT',
            'size' => 1,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL',
            'extra' => 'AUTO_INCREMENT PRIMARY KEY'
        ),
        'day' => array(
            'type' => 'VARCHAR',
            'size' => 255,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL'
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
$aData[TABLE_PRESENCE] = array(
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

$aData[TABLE_USER] = array(
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
        'password_hash' => array(
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
        //deprecated -> use role
        'admin' => array(
            'type' => 'TINYINT',
            'size' => 1,
            'standard' => 'NOT NULL',
            'extra' => 'DEFAULT 0'
        ),
        'role' => array(
            'type' => 'INT',
            'standard' => 'NOT NULL',
            'extra' => 'DEFAULT 0'
        )
    );

$aData[TABLE_TOKEN] = array(
        'token_ID' => array(
            'type' => 'INT',
            'size' => 11,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL',
            'extra' => 'AUTO_INCREMENT PRIMARY KEY'
        ),
        'user_ID' => array(
            'type' => 'INT',
            'size' => 11,
            'unique' => 'TRUE',
            'standard' => 'NOT NULL'
        ),
        'token_hash' => array(
            'type' => 'VARCHAR',
            'size' => 255,
            'standard' => 'NOT NULL'
         ),
        'creation_date' => array(
            'type' => 'DATETIME',
            'standard' => 'NOT NULL'),
        'used' => array(
            'type' => 'TINYINT',
            'size' => 1,
            'extra' => 'DEFAULT 0'
        )
    );

$aData[TABLE_API_TOKEN] = array(
        'token_ID' => array(
            'type' => 'INT',
            'unique' => 'TRUE',
            'standard' => 'NOT NULL',
            'extra' => 'AUTO_INCREMENT PRIMARY KEY'
        ),
        'user_ID' => array(
            'type' => 'INT',
            'unique' => 'TRUE',
            'standard' => 'NOT NULL'
        ),
        'name' => array(
            'type' => 'VARCHAR',
            'size' => 255,
            'standard' => 'NOT NULL'
         ),
        'token' => array(
            'type' => 'VARCHAR',
            'size' => 255,
            'standard' => 'NOT NULL'
         ),
        'creation_date' => array(
            'type' => 'DATETIME',
            'standard' => 'NOT NULL'),
        'active' => array(
            'type' => 'TINYINT',
            'size' => 1,
            'extra' => 'DEFAULT 1'
        )
    );
