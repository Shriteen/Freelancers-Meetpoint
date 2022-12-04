<?php

require_once __DIR__.'/../global/php/common_libs.php';

function display_error($error_message) {
    echo $error_message;
    echo "<br><a href='create_post.php'> Back to Create Post</a>";
    exit;
}

function validate() {    
    // sanitize and validate each field

    //project name
    if(isset($_REQUEST['project-name']))
    {
        $pname= filter_var( $_REQUEST['project-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($pname === '')
            display_error('Invalid Project Name');

        //valid project name
        $form['project-name']=$pname;
    }
    else
        display_error('Please provide Project Name');

    // skill required
    if(isset($_REQUEST['skill-required']))
    {
        $skill= filter_var( $_REQUEST['skill-required'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($skill === '')
            display_error('Invalid Skill Requirement');
        
        //valid skill required
        $form['skill-required']=$skill;
    }
    else
        display_error('Please provide Requirement');

    // description
    if(isset($_REQUEST['project-description']))
    {
        $description= filter_var( $_REQUEST['project-description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($description === '')
            display_error('Invalid Description');
        
        //valid description
        $form['project-description']=$description;
    }
    else
        display_error('Please provide Description');

    // bidable
    if(isset($_REQUEST['bidable']))
    {        
        if($_REQUEST['bidable']!=='true' && $_REQUEST['bidable']!=='false')
            display_error('Invalid Bid state');
        
        //valid bid state
        $form['bidable']=$_REQUEST['bidable'];
    }
    else
        display_error('Please select Bid state');

    // TODO: feature to provide offer charges per hour
    
    return $form;
}

// inserts post into database and returns auto generated post id
function entry_database($formdata) {
    $db = connect_db();
    
    $query= sprintf( "INSERT INTO POST(CREATED_BY,PROJECT_NAME,REQUIRED_SKILL,DESCRIPTION,ALLOW_BIDS) VALUES('%s','%s','%s','%s',%s)",
                     $db->real_escape_string( get_from_cookie()['username'] ),
                     $db->real_escape_string($formdata['project-name']),
                     $db->real_escape_string($formdata['skill-required']),
                     $db->real_escape_string($formdata['project-description']),
                     $db->real_escape_string($formdata['bidable'])
        );
    if(!$db->query($query))
        die('Query Error');
    
    //successfully inserted
    return $db->insert_id;
}


$formdata=validate();
$post_id=entry_database($formdata);

//redirect
$redirect_url= "Location: ../view_post/view_post.php?id=$post_id";
header($redirect_url,true);
exit;

?>
