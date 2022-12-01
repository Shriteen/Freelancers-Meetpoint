<?php

require_once __DIR__.'/../global/php/common_libs.php';

function display_error($error_message) {
    echo $error_message;
    echo "<br><a href='login_page.php'> Back to Login Page</a>";
    exit;
}

function validate() {
    // sanitize and validate each field

    //account type
    if(isset($_REQUEST['account-type']))
    {
        if($_REQUEST['account-type']!='employer' && $_REQUEST['account-type']!='freelancer')
            display_error('Invalid account type');
        
        //valid account type
        $form['account-type']=$_REQUEST['account-type'];
    }
    else
        display_error('Please select account type');

    //account username
    if(isset($_REQUEST['account-name']))
    {
        $uname= filter_var( $_REQUEST['account-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($uname === '')
            display_error('Invalid Username');

        if(!user_exists($uname,$form['account-type']))
            display_error('User Does not exist! Please Enter valid Username');
        
        //valid username
        $form['account-username']=$uname;
    }
    else
        display_error('Please provide Username');

    //account password
    if(isset($_REQUEST['account-password']))
    {
        $pass= filter_var( $_REQUEST['account-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($pass === '')
            display_error('Invalid characters used in password');

        //valid password
        $form['account-password']=$pass;
    }
    else
        display_error('Please provide Password');


    return $form;    
}

$formdata=validate();

//if valid store in cookie and redirect
if(login_authenticate($formdata['account-username'],
                      $formdata['account-password'],
                      $formdata['account-type']) )
{
    store_in_cookie($formdata['account-username'],
                    $formdata['account-password'],
                    $formdata['account-type']);
    //redirect
    switch($formdata['account-type'])
    {
    case 'employer':
        header('Location: ../employer_homepage/employer_homepage.php',true);
        exit;
        break;
    case 'freelancer':
        header('Location: ../freelancer_homepage/freelancer_homepage.php',true);
        exit;
        break;
    default:
        die('Invalid account type');
    }
}
else
{
    display_error('Invalid Username or Password');
}

?>
