<?php

require_once __DIR__.'/../global/php/common_libs.php';

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
    {
        echo 'Failed';
        exit;
    }
    $form['admin-password']=$pass;
}
else
{
    echo 'Failed';
    exit;
}

// account type
if(isset($_REQUEST['account-type']))
{
    if($_REQUEST['account-type'] == 'EMPLOYER' || $_REQUEST['account-type'] == 'FREELANCER')
    {
        $form['account-type']=$_REQUEST['account-type'];
    }
    else
    {
        echo 'Failed';
        exit;
    }
}
else
{
    echo 'Failed';
    exit;
}

// username
if(isset($_REQUEST['username']))
{
    $uname= filter_var( $_REQUEST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    if($uname === '')
    {
        echo 'Failed';
        exit;
    }
    $form['username']=$uname;
    
}
else
{
    echo 'Failed';
    exit;
}


if(authenticate_admin($form['admin-password']))
{    
    // delete user
    $db = connect_db();

    switch($form['account-type'])
    {
    case 'EMPLOYER':
        $query= sprintf("DELETE FROM EMPLOYER WHERE USERNAME='%s'",
                        $db->real_escape_string($form['username']) );

        if(!$db->query($query))
            die('Query Error');
    case 'FREELANCER':
        $query= sprintf("DELETE FROM FREELANCER WHERE USERNAME='%s'",
                        $db->real_escape_string($form['username']) );
        if(!$db->query($query))
            die('Query Error');
    }
    
}
else
{
    echo 'Failed';
    exit;
}

echo "Success";

?>
