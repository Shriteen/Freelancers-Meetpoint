<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

?>

<?php

$search_query=$_GET['search-query'];


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Freelancers-Meetpoint Home</title>
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

      <!-- TODO: The following name, picture and menu items will be filled and populated by javascript -->
      <?php require_once $_SERVER['DOCUMENT_ROOT'].'/global/php/account_info_widget.php' ?>
    </header> 
    
    <!-- Content -->
    <main>
      <div>
        <!-- TODO: freelancers_search remaining-->
        <form id="freelancer-search-form" method="get" >                  
          <div id="freelancer-search-widget">               
            <input type="search" id="search-field" name="search-query" placeholder="Find what you are Looking for" value="<?php echo $search_query ?>">
            <button type="submit" id="search-button">Search</button>  
          </div>
        </form>

        <!--TODO:freelancers_search_results should be filled using php-->
        <div id="freelancer-search-results">               
        </div>

      </div>  
	    
    </main>
  </body>
</html>
