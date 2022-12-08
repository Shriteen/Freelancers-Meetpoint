<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Home <?php echo $USERNAME ?> - Freelancers-Meetpoint</title>
    <!-- favicon in tab -->
    <link href="/global/assets/favicon.png" rel="icon">
    <link href="/global/style.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="/global/account_info_widget.js" defer></script> 
  </head>
  
  <body>
    <!-- Header -->
    <header>
      <a href="/index.php">
	    <picture alt="logo">
	      <source media="(max-width:600px)" srcset="/global/assets/logo_with_name_initials.svg">
	      <source media="(min-width:601px)" srcset="/global/assets/logo_with_name.svg">
	      <img src="/global/assets/logo_with_name_initials.svg" height="45px" id="header-logo">
	    </picture>
      </a>

      <?php require_once $_SERVER['DOCUMENT_ROOT'].'/global/php/account_info_widget.php' ?>
    </header> 

     
    <!-- Content -->
    <main>
      <div>
        <form id="employer-search-form" action="../employer_search/employer_search.php" method="get" >                  
          <div id="employer-search-widget" class="search-widget">               
            <input type="search" id="search-field" name="search-query" placeholder="Find what you are Looking for">
            <button type="submit" id="search-button"><img src="/global/assets/search_icon.png" width="25px" height="25px"></button>  
          </div>
        </form>

        <!--TODO:suggestions should be filled using php-->
        <div id="suggestions">               
        </div>

        <p id='seperator'>OR</p>                         

        <div id="post-a-job-message">                       
          <a href="/create_post/create_post.php">Post a Job</a>
        </div>

      </div>  
	    
    </main>
  </body>
</html>
