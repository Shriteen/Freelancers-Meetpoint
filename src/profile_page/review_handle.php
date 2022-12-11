<?php

require_once __DIR__.'/../global/php/common_libs.php';

function display_error($error_message) {
    echo $error_message;
    echo "<br><a href='profile_page.php?user=".$_REQUEST['reviewee']."'> Back </a>";
    exit;
}

function validate() {    
    // sanitize and validate each field
    
    //reviewee username
    if(isset($_REQUEST['reviewee']))
    {
        $uname= filter_var( $_REQUEST['reviewee'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($uname === '')
            display_error('Invalid Username');

        if(!user_exists($uname,'freelancer'))
            display_error('Invalid Username');
        
        $form['reviewee']=$uname;
    }
    else
        display_error('Invalid Username');

    //reviewer username
    if(isset($_REQUEST['reviewer']))
    {
        $uname= filter_var( $_REQUEST['reviewer'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($uname === '')
            display_error('Invalid Username');

        if(!user_exists($uname,'employer'))
            display_error('Invalid Username');
        
        $form['reviewer']=$uname;
    }
    else
        display_error('Invalid Username');
    
    //rating
    if(isset($_REQUEST['rating']))
    {        
        $rate= filter_var( $_REQUEST['rating'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $rate= filter_var( $rate,
                           FILTER_VALIDATE_FLOAT,
                           array("options" => array("min_range"=>0,"max_range"=>5 )) );
        
        if($rate == false)
            display_error('Invalid Rating');
        $form['rating']=$rate;
    }
    else
        display_error('Please provide Rating');

    //description
    if(isset($_REQUEST['description']) && $_REQUEST['description']!=='')
    {
        $desc= filter_var( $_REQUEST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($desc === '')
            display_error('Invalid Description');
        
        $form['description']=$desc;
    }
    else
        $form['description']='';
    
    return $form;
}

function entry_database($formdata) {
    $db = connect_db();

    if($formdata['description']!=='')
    {
        $query= sprintf("INSERT INTO REVIEWS(REVIEWER,REVIEWEE,RATING,DESCRIPTION)
 VALUES('%s','%s',%f,'%s') ON DUPLICATE KEY UPDATE RATING=%f,DESCRIPTION='%s',TIME_STAMP=now()",
                        $db->real_escape_string($formdata['reviewer']),
                        $db->real_escape_string($formdata['reviewee']),
                        $db->real_escape_string($formdata['rating']),
                        $db->real_escape_string($formdata['description']),
                        $db->real_escape_string($formdata['rating']),
                        $db->real_escape_string($formdata['description'])
            );
    
        if(!$db->query($query))
            die('Query Error');
        
    }
    else
    {
        $query= sprintf("INSERT INTO REVIEWS(REVIEWER,REVIEWEE,RATING,DESCRIPTION)
 VALUES('%s','%s',%f,null) ON DUPLICATE KEY UPDATE RATING=%f,TIME_STAMP=now()",
                        $db->real_escape_string($formdata['reviewer']),
                        $db->real_escape_string($formdata['reviewee']),
                        $db->real_escape_string($formdata['rating']),
                        $db->real_escape_string($formdata['rating'])
            );
    
        if(!$db->query($query))
            die('Query Error');
    }
    //successfully inserted
}

$formdata=validate();
entry_database($formdata);

header('Location: profile_page.php?user='.$_REQUEST['reviewee'],true);
exit;
