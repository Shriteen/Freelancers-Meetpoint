<?php

require_once __DIR__.'/common_libs.php';

$cookiedata= get_from_cookie();
//if cookies contain anything, verify and set variables, else redirect to login page
if($cookiedata)
{
    if(login_authenticate($cookiedata['username'],
                          $cookiedata['password'],
                          $cookiedata['type']) )
    {
        global $LOGGED_IN,$USERNAME,$ACCOUNT_TYPE;
        $LOGGED_IN=true;
        $USERNAME=$cookiedata['username'];
        $ACCOUNT_TYPE=$cookiedata['type'];
    }
    else
    {
        header('Location: /global/php/logout.php',true);
        exit;
    }
}
else
{
    header('Location: /login_page/login_page.php',true);
    exit;
}


?>
