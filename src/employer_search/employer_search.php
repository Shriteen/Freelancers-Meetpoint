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
      <div>
        <!-- TODO: employer_search remaining-->
        <form id="employer-search-form" method="get" >                  
          <div id="employer-search-widget">               
            <input type="search" id="search_field" name="search_query" placeholder="Find what you are Looking for">
            <button type="submit" id="search_button">Search</button>  
          </div>
        </form>

        <!--TODO:employer_search_results should be filled using php-->
        <div id="employer_search_results">               
        </div>

      </div>  
	    
    </main>
  </body>
</html>
