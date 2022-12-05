<?php

require_once __DIR__.'/../global/php/common_libs.php';

$cookiedata= get_from_cookie();
//if cookies contain anything, verify and redirect
if($cookiedata)
{
    if(login_authenticate($cookiedata['username'],
                          $cookiedata['password'],
                          $cookiedata['type']) )
    {
        //redirect
        switch($cookiedata['type'])
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
    }
    else
    {
        header('Location: ../global/php/logout.php',true);
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login - Freelancers-Meetpoint</title>
    <!-- favicon in tab -->
    <link href="../global/assets/favicon.png" rel="icon">
    <link href="../global/style.css" rel="stylesheet">
    <link href="../global/form_common_styles.css" rel="stylesheet">    
    <link href="style.css" rel="stylesheet">
  </head>
  
  <body>
    <!-- Header -->
    <header>
      <a href="/index.php">
	<picture alt="logo">
	  <source media="(max-width:600px)" srcset="../global/assets/logo_with_name_initials.svg">
	  <source media="(min-width:601px)" srcset="../global/assets/logo_with_name.svg">
	  <img src="../global/assets/logo_with_name_initials.svg" height="45px" id="header-logo">
	</picture>
      </a>
    </header>
    
    <!-- Content -->
    <main>
      <form id="login-form" action="login_form_handle.php" method="post" class="card">
        <ul>
          <li id="account-type-selector">
            <input type="radio" id="login-account-type-employer" name="account-type" value="freelancer" required checked>
            <label for="login-account-type-employer">Find Work</label>
	    <span>or</span>
	    <input type="radio" id="login-account-type-freelancer" name="account-type" value="employer" required>
	    <label for="login-account-type-freelancer">Find Talent</label>
          </li>

          <li>
            <!-- Username -->
	    <label for="login-account-username">Username</label>
	    <input type="text" id="login-account-username" name="account-name" maxlength="100" required>
          </li>
    
          <li>
            <!-- Password -->
	    <label for="login-account-password">Password</label>
	    <input type="password" id="login-account-password" name="account-password" maxlength="100" required>
          </li>

          <li>
            <button type="submit" id="login-button">Log In</button>
          </li>

          <a href="../signup_page/signup_page.php">Don't have an account? Sign Up</a>
        </ul>
      </form>
    </main>
  </body>
</html>
