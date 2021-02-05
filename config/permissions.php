<?php

/*
 * Permission stages
 * 0 Not logged in
 * 1 Logged in, not approved
 * 2 Approved user
 * 3 Moderator
 * 4 Admin
 */

$roles = array(
    0 => 'LOGGED_OUT',
    1 => 'USER',
    2 => 'ADMIN'
);

$permissions = array(
    'REGISTER' => array(0),
    'LOGIN' => array(0),
    'SAVE_USER' => array(2),
    'SHOW_USER' => array(2),
    'SHOW_LOANS' => array(2),
    'DELETE_SELF' => array(1, 2),
    'PROMOTE_ADMIN' => array(2),
    'SHOW_SELF' => array(1, 2),
    'SAVE_BOOK' => array(2),
    'SAVE_MATERIAL' => array(2)
);
?>

