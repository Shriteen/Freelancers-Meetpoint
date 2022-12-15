<?php

require_once __DIR__.'/../global/php/common_libs.php';

if(isset($_GET['pattern']))
    $pattern=$_GET['pattern'];
else
    $pattern='';

$db= connect_db();

$accounts_res= $db->query(sprintf("SELECT USERNAME,NAME,CONCAT('EMPLOYER') AS TYPE FROM EMPLOYER
WHERE USERNAME LIKE '%%%s%%' OR NAME LIKE '%%%s%%' UNION
 SELECT USERNAME,NAME,CONCAT('FREELANCER') AS TYPE FROM FREELANCER
WHERE USERNAME LIKE '%%%s%%' OR NAME LIKE '%%%s%%' ",
                                  $db->real_escape_string($pattern),
                                  $db->real_escape_string($pattern),
                                  $db->real_escape_string($pattern),
                                  $db->real_escape_string($pattern)));

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
