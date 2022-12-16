<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

$db=connect_db();
$db_query_for_post=sprintf("SELECT*FROM POST WHERE CREATED_BY='%s'",$USERNAME);

$db_post_result=$db->query($db_query_for_post);
if(!$db_post_result)
  die('Query Error');

$db_query_for_suggestion=sprintf("SELECT PROFESSION FROM FREELANCER ORDER BY RAND() LIMIT 3");

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
    <script src="script.js" defer></script> 
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
        <?php
            for($i=0;
                $i < $db_suggestion_result->num_rows;
                $i++):
            $suggestion_row= $db_suggestion_result->fetch_assoc(); ?>
          <button class="suggestion-button"><?php echo $suggestion_row['PROFESSION'] ?></button>
                      
        <?php endfor ?>
        </div>

        <p id='seperator'>OR</p>                         

        <div id="post-a-job-message">                       
          <a href="/create_post/create_post.php">Post a Job</a>
        </div>

        <?php if($db_post_result->num_rows > 0): ?>
          <div id="previous-posts-section" class="card">
           <p>Posted by You</p>
           <ul id="previous-posts">
           <?php for($i=0;
                      $i < $db_post_result->num_rows;
                      $i++): ?>
            <?php $post_row= $db_post_result->fetch_assoc();
            ?>
            <li class="previous-post-list-item">
              <a class="previous-post-link" href="/view_post/view_post.php?id=<?php echo urlencode($post_row['ID']) ?>"> <?php echo $post_row['PROJECT_NAME'].' : '.$post_row['REQUIRED_SKILL'] ?> </a>
            </li>

            <?php endfor ?>
           </ul>
          </div>

        <?php endif; ?> 

      </div>  
	    
    </main>
  </body>
</html>
