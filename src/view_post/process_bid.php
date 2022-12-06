<?php

require_once __DIR__.'/../global/php/common_libs.php';

function display_error($error_message) {
    echo $error_message;
    echo "<br><a href='view_post.php?id=".$_REQUEST['post-id']."'> Back </a>";
    exit;
}

function validate() {    
    // sanitize and validate each field

    //post-id
    if(isset($_REQUEST['post-id']))
    {
        $pid= filter_var( $_REQUEST['post-id'], FILTER_SANITIZE_NUMBER_INT );
        $pid= filter_var( $pid, FILTER_VALIDATE_INT );
        if($pid == false)
            display_error('Invalid post ID');
        $form['post-id']=$pid;
    }
    else
        display_error('Invalid post ID');
    
    //freelancer username
    if(isset($_REQUEST['freelancer-name']))
    {
        $uname= filter_var( $_REQUEST['freelancer-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if($uname === '')
            display_error('Invalid Username');

        if(!user_exists($uname,'freelancer'))
            display_error('Invalid Username');
        
        $form['freelancer-name']=$uname;
    }
    else
        display_error('Invalid Username');

    //amount
    if(isset($_REQUEST['bid-amount']))
    {
        $bid= filter_var( $_REQUEST['bid-amount'], FILTER_SANITIZE_NUMBER_INT );
        $bid= filter_var( $bid, FILTER_VALIDATE_INT );
        if($bid == false)
            display_error('Invalid bid');
        $form['bid-amount']=$bid;
    }
    else
        display_error('Please provide bid amount');
    
    return $form;
}

function entry_database($formdata) {
    $db = connect_db();

    $query= sprintf("INSERT INTO BIDS_FOR VALUES('%s',%d,%d) ON DUPLICATE KEY UPDATE AMOUNT=%d",
                    $db->real_escape_string($formdata['freelancer-name']),
                    $db->real_escape_string($formdata['post-id']),
                    $db->real_escape_string($formdata['bid-amount']),
                    $db->real_escape_string($formdata['bid-amount'])
        );
    
    if(!$db->query($query))
        die('Query Error');
    //successfully inserted
}

$formdata=validate();
entry_database($formdata);

header('Location: view_post.php?id='.$formdata['post-id'],true);
exit;
