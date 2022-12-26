<?php

require_once __DIR__.'/../global/php/common_libs.php';

if(isset($_GET['pattern']))
    $pattern=$_GET['pattern'];
else
    $pattern='';

if(isset($_GET['type']))
    $actype=$_GET['type'];
else
    exit;


$db= connect_db();

if($actype=='employer')
{
    $accounts_res= $db->query(sprintf("SELECT USERNAME,NAME,CONCAT('EMPLOYER') AS TYPE FROM EMPLOYER
WHERE USERNAME LIKE '%%%s%%' OR NAME LIKE '%%%s%%' ",
                                      $db->real_escape_string($pattern),
                                      $db->real_escape_string($pattern)));

}
else if($actype=='freelancer')
{
    $accounts_res= $db->query(sprintf("SELECT USERNAME,NAME,PROFESSION,CONCAT('FREELANCER') AS TYPE FROM FREELANCER
WHERE USERNAME LIKE '%%%s%%' OR NAME LIKE '%%%s%%' OR PROFESSION LIKE '%%%s%%' ",
                                      $db->real_escape_string($pattern),
                                      $db->real_escape_string($pattern),
                                      $db->real_escape_string($pattern)));
}
else
    exit;

if($accounts_res)
{
    while($row=$accounts_res->fetch_assoc())
    {        
        $result[]=$row;
    }
}
else
    die('Query Error');


echo json_encode($result);


?>
