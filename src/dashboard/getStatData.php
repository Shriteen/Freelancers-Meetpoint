<?php

require_once __DIR__.'/../global/php/common_libs.php';

$start=$_GET['start-date'];
$end=$_GET['end-date'];

$db= connect_db();

$e_accounts_res= $db->query(sprintf("SELECT COUNT(USERNAME) as c FROM EMPLOYER WHERE DATE(CREATED_ON)>='%s' AND DATE(CREATED_ON)<='%s'",
                                    $db->real_escape_string($start),
                                    $db->real_escape_string($end) ) );

if($e_accounts_res)
{
    if($row=$e_accounts_res->fetch_assoc())
    {        
        $result['employer-account-count']=$row['c'];
    }
    else
        die('Query Error');
}
else
    die('Query Error');

$f_accounts_res= $db->query(sprintf("SELECT COUNT(USERNAME) as c FROM FREELANCER WHERE DATE(CREATED_ON)>='%s' AND DATE(CREATED_ON)<='%s'",
                                    $db->real_escape_string($start),
                                    $db->real_escape_string($end) ) );

if($f_accounts_res)
{
    if($row=$f_accounts_res->fetch_assoc())
    {        
        $result['freelancer-account-count']=$row['c'];
    }
    else
        die('Query Error');
}
else
    die('Query Error');

$post_res= $db->query(sprintf("SELECT COUNT(ID) as c FROM POST WHERE DATE(CREATED_ON)>='%s' AND DATE(CREATED_ON)<='%s'",
                              $db->real_escape_string($start),
                              $db->real_escape_string($end) ) );

if($post_res)
{
    if($row=$post_res->fetch_assoc())
    {        
        $result['post-count']=$row['c'];
    }
    else
        die('Query Error');
}
else
    die('Query Error');

$bid_res= $db->query(sprintf("SELECT COUNT(DISTINCT FREELANCER_USERNAME,POST_ID) as c FROM BIDS_FOR WHERE DATE(TIME_STAMP)>='%s' AND DATE(TIME_STAMP)<='%s'",
                             $db->real_escape_string($start),
                             $db->real_escape_string($end) ) );

if($bid_res)
{
    if($row=$bid_res->fetch_assoc())
    {        
        $result['bid-count']=$row['c'];
    }
    else
        die('Query Error');
}
else
    die('Query Error');


echo json_encode($result);


?>
