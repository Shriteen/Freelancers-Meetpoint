<?php

unset($_COOKIE['username']);
unset($_COOKIE['password']);
unset($_COOKIE['type']);

setcookie("username",null,0,"/","",true,false);
setcookie("password",null,0,"/","",true,false);
setcookie("type",null,0,"/","",true,false);

header('Location: ./../../login_page/login_page.html',true);
exit;

?>
