<?php

require_once __DIR__.'/../global/php/common_libs.php';

function display_error($error_message) {
    echo $error_message;
    echo "<br><a href='dashboard.php'> Back to Login Page</a>";
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

//admin password
if(isset($_REQUEST['admin-password']))
{
    $pass= filter_var( $_REQUEST['admin-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    if($pass === '')
        display_error('Invalid characters used in password');
    //valid password
    $form['admin-password']=$pass;
}
else
    display_error('Please provide Password');

if(!authenticate_admin($pass))
{    
    display_error("Authentication Failed!!");   
}


?>
