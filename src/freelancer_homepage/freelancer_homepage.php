<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

$db=connect_db();
$db_query_for_suggestion=sprintf("SELECT POST.*,NAME,PROFILE_PIC FROM
POST JOIN EMPLOYER ON POST.CREATED_BY=EMPLOYER.USERNAME ORDER BY RAND() LIMIT 3");

$db_suggestion_result=$db->query($db_query_for_suggestion);
if(!$db_suggestion_result)
  die('Query Error');

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Home <?php echo $USERNAME ?> - Freelancers-Meetpoint</title>
    <!-- favicon in tab -->
    <link href="/global/assets/favicon.png" rel="icon">
    <link href="/global/style.css" rel="stylesheet">
    <link href="/global/search_common_styles.css" rel="stylesheet">
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
        <form id="freelancer-search-form" action="../freelancer_search/freelancer_search.php" method="get" >                  
          <div id="freelancer-search-widget" class="search-widget">               
            <input type="search" id="search-field" name="search-query" placeholder="Find what you are Looking for">
            <button type="submit" id="search-button"><img src="/global/assets/search_icon.png" width="25px" height="25px"></button>  
          </div>
        </form>

        <!--TODO: suggestions should be filled using php-->
        <?php if($db_suggestion_result->num_rows > 0): ?>
          
         <div id="suggestions">   
          <p id="suggestion-message"> Suggested For You </p> 
          <?php for($i=0;
                      $i < $db_suggestion_result->num_rows;
                      $i++): ?>
          <?php $suggestion_row= $db_suggestion_result->fetch_assoc();
          ?>
            <a href="/view_post/view_post.php?id=<?php echo urlencode($suggestion_row['ID']) ?>">
              <div class="card search-result-card freelancer-search-result-card" >
                <p class="freelancer-search-result-project-name result-title">
                <?php echo $suggestion_row['PROJECT_NAME'] ?>
                </p>
                <p class="freelancer-search-result-requirement result-subtitle">
                <?php echo $suggestion_row['REQUIRED_SKILL'] ?>
                </p>
                <p class="freelancer-search-employer-line result-subsubtitle">
                By <img src='<?php echo $pic ?>' width="30px" height="30px" > <?php echo $suggestion_row['NAME'] ?>
                </p>
                <p class="freelancer-search-result-description">
                <?php echo $suggestion_row['DESCRIPTION'] ?>
                </p>
              </div>
            </a>
         <?php endfor; ?>     
         </div>
        <?php endif; ?>

      </div>  
	    
    </main>
  </body>
</html>
