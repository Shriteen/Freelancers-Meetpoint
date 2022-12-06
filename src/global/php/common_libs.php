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
    setcookie("username",$username,0,"/","",true,false);
    setcookie("password",$password,0,"/","",true,false);
    setcookie("type",$type,0,"/","",true,false);
}

// extract login info from cookie if present,
// returns associative array consisting of username,type,password if present, null if not present
function get_from_cookie() {
    if(isset($_COOKIE['username']))
    {
        $result['username'] = $_COOKIE['username'];
    }
    else    
        return null;
    
    if(isset($_COOKIE['type']))
    {
        $result['type'] = $_COOKIE['type'];
    }
    else
        return null;

    if(isset($_COOKIE['password']))
    {
        $result['password'] = $_COOKIE['password'];
    }
    else
        return null;
    
    return $result;
}

// accepts username,password and account type and returns true if password is valid
function login_authenticate($username,$password,$type) {
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

    if(user_exists($username,$type))
    {
        $query= sprintf("SELECT PASSWORD FROM %s WHERE USERNAME='%s'",$table, $db->real_escape_string($username));
        $result= $db->query($query);
        if($result)
        {
            if($row = $result->fetch_assoc())
            {
                //query valid       
                if(password_verify($password, $row['PASSWORD']))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
                die('Query Error');
        }
        else
            die('Query Error');
    }
    else
    {
        //user does not exists
        return false;
    }
}
    
// accept account type and returns table name for it
function get_table_of_type($type) {
    switch($type)
    {
    case 'employer':
        return 'EMPLOYER';
    case 'freelancer':
        return 'FREELANCER';
    default:
        die('Invalid account type');
    }
}

// checks whether post of given id exists in database and returns true if present
function post_exists($pid) {
    $db= connect_db();
    
    $query= sprintf("SELECT * FROM POST WHERE ID=%d", $db->real_escape_string($pid));
    $result= $db->query($query);
    if(!$result)
        die('Query Error');

    if($result->fetch_assoc())
    {
        //if post already exists
        return true;
    }
    else
    {
        //post doesn't already exist
        return false;
    }
}

?>


