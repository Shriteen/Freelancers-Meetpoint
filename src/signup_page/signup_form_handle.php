<?php

require_once __DIR__.'/../global/php/common_libs.php';

function display_error($error_message) {
    echo $error_message;
    echo "<br><a href='signup_page.php'> Back to Signup Form</a>";
    exit;
}

function validate() {    
    // sanitize and validate each field

    //account name
    if(isset($_REQUEST['account-name']))
    {
        $name= filter_var( $_REQUEST['account-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($name === '')
            display_error('Invalid Name');

        //valid name
        $form['account-name']=$name;
    }
    else
        display_error('Please provide Name');

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
    if(isset($_REQUEST['account-username']))
    {
        $uname= filter_var( $_REQUEST['account-username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($uname === '')
            display_error('Invalid Username');

        if(user_exists($uname,$form['account-type']))
            display_error('User already exists! Please use another Username');
        
        //valid username
        $form['account-username']=$uname;
    }
    else
        display_error('Please provide Username');

    //email
    if(isset($_REQUEST['account-email']))
    {
        $mail= filter_var( $_REQUEST['account-email'], FILTER_SANITIZE_EMAIL );
        
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
            display_error('Invalid Email ID');

        //valid email
        $form['account-email']=$mail;
    }
    else
        display_error('Please provide Email Id');

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

    //account location
    if(isset($_REQUEST['account-location']))
    {
        $loc= filter_var( $_REQUEST['account-location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($loc === '')
            display_error('Invalid location');

        //valid location
        $form['account-location']=$loc;
    }
    else
        display_error('Please provide location');    
    
    //account profile picture
    if(isset($_FILES['account-profile-picture']))
    {
        $picname= filter_var( $_FILES['account-profile-picture']['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($picname === '')
            display_error('Invalid Filename of Profile Picture');
        if(!filter_var( $picname,
                       FILTER_VALIDATE_REGEXP,
                       array("options"=>array("regexp"=>'/(\.jpg|\.jpeg|\.png)$/')) ))
            display_error('Profile Picture should be in jpg or png format');
            
        
        //valid profile picture
        $form['account-profile-picture-name']=$picname;
        $form['account-profile-picture-tmpname']=$_FILES['account-profile-picture']['tmp_name'];
    }
    else
        display_error('Please provide profile picture');

    if($form['account-type']=='freelancer')
    {
        //account profession
        if(isset($_REQUEST['account-profession']))
        {
            $prof= filter_var( $_REQUEST['account-profession'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            if($prof === '')
                display_error('Invalid profession');

            //valid profession
            $form['account-profession']=$prof;
        }
        else
            display_error('Please provide profession');

        //account tagline
        if(isset($_REQUEST['account-tagline']))
        {
            $tagline= filter_var( $_REQUEST['account-tagline'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            if($tagline === '')
                display_error('Invalid Description');

            //valid tagline
            $form['account-tagline']=$tagline;
        }
        else
            display_error('Please provide description');

        //account min charges
        if(isset($_REQUEST['account-min-charges']))
        {
            $min= filter_var( $_REQUEST['account-min-charges'], FILTER_SANITIZE_NUMBER_INT );
            $min= filter_var( $min,
                              FILTER_VALIDATE_INT,
                              array("options" => array("min_range"=>1)) );
            
            if($min == false)
                display_error('Please provide valid minimum charges');

            //valid minimum charges
            $form['account-min-charges']=$min;
        }
        else
            display_error('Please provide minimum charges');

        //account max charges
        if(isset($_REQUEST['account-max-charges']))
        {
            $max= filter_var( $_REQUEST['account-max-charges'], FILTER_SANITIZE_NUMBER_INT );
            $max= filter_var( $max,
                              FILTER_VALIDATE_INT,
                              array("options" => array("min_range"=>2)) );
            
            if($max == false)
                display_error('Please provide valid maximum charges');

            //valid maximum charges
            $form['account-max-charges']=$max;
        }
        else
            display_error('Please provide maximum charges');

        //TODO: Experience validation
        
    }
    
    return $form;
}

function entry_database($formdata) {
    $db = connect_db();

    //determine table type and use correct query
    switch($formdata['account-type'])
    {
    case 'employer':
        $query= sprintf("INSERT INTO EMPLOYER VALUES('%s','%s','%s','%s','%s','%s')",
                        $db->real_escape_string($formdata['account-username']),
                        $db->real_escape_string($formdata['account-name']),
                        $db->real_escape_string($formdata['account-email']),
                        $db->real_escape_string( password_hash($formdata['account-password'],
                                                               PASSWORD_BCRYPT)),
                        $db->real_escape_string($formdata['account-location']),
                        $db->real_escape_string($formdata['account-profile-picture-name'])
            );
        if(!$db->query($query))
            die('Query Error');
        //successfully inserted
        break;
    case 'freelancer':
        $query= sprintf("INSERT INTO FREELANCER VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%d','%d')",
                        $db->real_escape_string($formdata['account-username']),
                        $db->real_escape_string($formdata['account-name']),
                        $db->real_escape_string($formdata['account-email']),
                        $db->real_escape_string( password_hash($formdata['account-password'],
                                                               PASSWORD_BCRYPT)),
                        $db->real_escape_string($formdata['account-location']),
                        $db->real_escape_string($formdata['account-profile-picture-name']),
                        $db->real_escape_string($formdata['account-profession']),
                        $db->real_escape_string($formdata['account-tagline']),
                        $db->real_escape_string($formdata['account-min-charges']),
                        $db->real_escape_string($formdata['account-max-charges'])
            );
        if(!$db->query($query))
            die('Query Error');
        //successfully inserted
        break;
    default:
        die('Invalid account type');
    }
}


$formdata=validate();
entry_database($formdata);
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

?>
