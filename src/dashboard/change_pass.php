<?php

require_once __DIR__.'/../global/php/common_libs.php';
require_once __DIR__.'/set_admin.php';

function display_error($error_message) {
    echo $error_message;
    echo "<br><a href='dashboard.php'> Back </a>";
    exit;
}

function authenticate_admin($password) {
    $db= connect_db();
    
    $result= $db->query("SELECT PASSWORD FROM ADMIN WHERE ADMIN='ADMIN'");
    if($result)
    {
        if($result->num_rows == 1)
        {            
            if($row = $result->fetch_assoc())
            {
                //query valid       
                if(password_verify($password, $row['PASSWORD']))
                    return true;
                else
                    return false;
            }
            else
                die('Error');
        }
        else
            die("Critical Problem: No Admin; Run reset.php ");
    }
    else
        die('Query Error');
}

//current password
if(isset($_REQUEST['current-password']))
{
    $pass= filter_var( $_REQUEST['current-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    if($pass === '')
        display_error('Invalid characters used in password');
    $form['current-password']=$pass;
}
else
    display_error('Please provide Current Password');

//new password
if(isset($_REQUEST['new-password']))
{
    $pass= filter_var( $_REQUEST['new-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    if($pass === '')
        display_error('Invalid characters used in password');
    $form['new-password']=$pass;
}
else
    display_error('Please provide New Password');


if(authenticate_admin($form['current-password']))
{    
    // change password
    set_admin($form['new-password']);
    header('Location: dashboard.php',true);
}
else
{
    display_error('Incorrect Password');
}


?>
