<?php

require_once __DIR__.'/../global/php/common_libs.php';

function set_admin($pass) {
        
$db = connect_db();
    
$query= sprintf("INSERT INTO ADMIN VALUES('ADMIN','%s') ON DUPLICATE KEY UPDATE PASSWORD='%s'",
                $db->real_escape_string( password_hash($pass, PASSWORD_BCRYPT)),
                $db->real_escape_string( password_hash($pass, PASSWORD_BCRYPT)),            
    );

if(!$db->query($query))
    die('Query Error');

}

?>
