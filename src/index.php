<?php

require_once __DIR__.'global/php/common_libs.php';

$cookiedata= get_from_cookie();
//if cookies contain anything, verify and redirect
if($cookiedata)
{
    if(login_authenticate($cookiedata['username'],
                          $cookiedata['password'],
                          $cookiedata['type']) )
    {
        global $LOGGED_IN,$USERNAME,$ACCOUNT_TYPE;
        $LOGGED_IN=true;
        $USERNAME=$cookiedata['username'];
        $ACCOUNT_TYPE=$cookiedata['type'];
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Freelancers-Meetpoint Home</title>
    <!-- favicon in tab -->
    <link href="global/assets/favicon.png" rel="icon">
    <link href="global/style.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
  </head>
  
  <body>
    <!-- Header -->
    <header>
      <a href="index.html">
	<picture alt="logo">
	  <source media="(max-width:600px)" srcset="global/assets/logo_with_name_initials.svg">
	  <source media="(min-width:601px)" srcset="global/assets/logo_with_name.svg">
	  <img src="global/assets/logo_with_name_initials.svg" height="45px" id="header-logo">
	</picture>
      </a>

      <!-- TODO: The following name, picture and menu items will be filled and populated by javascript -->
      
      <!-- Account info widget button -->
      <button id="account-info-button" class="logged-out">
	<img id="account-info-profile-pic" src="global/assets/unknown_person_profile_icon.svg" height="30px">
	<!-- following is hidden when logged in -->
	<p>Sign In</p>
	<img id="hamburger-icon" src="global/assets/hamburger_menu_icon.svg" height="25px">
      </button>

      <!-- menu -->
      <div id="hamburger-menu" class="hidden">
	<div id="hamburger-menu-header">
	  <p id="hamburger-menu-account-name"></p>
	  <button id="hamburger-menu-close">
	    <img src="global/assets/close.svg" height="20px">
	  </button>
	</div>
	<ul>
	  <a>
	    <li class="menu-item">
	      <img height="20px">
	      <span></span>
	    </li>
	  </a>
      </div>
    </header>
    
    <!-- Content -->
    <main>
      <div class="info-quote" id="quote1">
	<p>
	  A Platform to bring Talent and Talent Seekers at One Place
	</p>
	<a href="login_page/login_page.php" class="logged-out">Log In</a>
	<a href="signup_page/signup_page.php" class="logged-out">Sign Up</a>
      </div>
      
      <div class="info-quote" id="quote2">
	<p>
	  Got a Project? Looking for People?
	  <br>
	  Talent is a Search away
	</p>
      </div>
	   
      <div class="info-quote" id="quote3">
	<p>
	  Creative Is What We Do.
	  <br>
          The Future's Bright. The Future's Freelance
	</p>
      </div>

      <div class="info-quote" id="quote4">
	<p>
	  Forget The Old Rules. You Can Have The Best People.
          <br>
	  Right Now. Right Here.
	</p>
      </div>

      <div class="info-quote" id="quote5">
	<p>
	 Opportunities don't happen, you Create them.
	 <br>
	 Opportunity doesn't knock, Build a Door.
	</p>
      </div>

      <div class="info-quote" id="quote6">
	<p>
	 In Demand Talent
	 <br>
	 On Demand
	</p>
      </div>
	    
    </main>
  </body>
</html>
