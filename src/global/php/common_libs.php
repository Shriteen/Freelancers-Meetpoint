<?php

// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(E_ALL);


// connects to database and returns database context object
function connect_db() {
    static $db = new mysqli('localhost','root','','freelancers_meetpoint');
    
    if (!is_null($db->connect_error))
    {
        echo 'Connection failed<br>';
        die("$mysqli->connect_error");
    }

    return $db;
}

// accepts username and account type and return true if user exists
function user_exists($uname,$type) {
    $db= connect_db();

    //determine table type
    switch($type)
    {
    case 'employer':
        $table='EMPLOYER';
        break;
    case 'freelancer':
        $table='FREELANCER';
        break;
    default:
        die('Invalid account type');
    }
    
    $query= sprintf("SELECT USERNAME FROM %s WHERE USERNAME='%s'",$table, $db->real_escape_string($uname));
    $result= $db->query($query);
    if(!$result)
        die('Query Error');

    if($result->fetch_assoc())
    {
        //if user already exists
        return true;
    }
    else
    {
        //user doesn't already exist
        return false;
    }    
    
}

// accepts username,password and account type and store in cookie
function store_in_cookie($username,$password,$type)
{
    setcookie("username",$username,0,"","",true,false);
    setcookie("password",$password,0,"","",true,false);
    setcookie("type",$type,0,"","",true,false);
}


?>
