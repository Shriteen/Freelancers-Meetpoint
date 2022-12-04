<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

?>

<?php

$search_query=$_GET['search-query'];

// TODO: Use more filters

$db=connect_db();

if($search_query)
{
    //TODO: sorting of results
    $db_query_for_search= sprintf("SELECT POST.*,NAME,PROFILE_PIC FROM
POST JOIN EMPLOYER ON POST.CREATED_BY=EMPLOYER.USERNAME WHERE
 NAME LIKE '%%%s%%' OR
 PROJECT_NAME LIKE '%%%s%%' OR
 REQUIRED_SKILL LIKE '%%%s%%' OR
 DESCRIPTION LIKE '%%%s%%' OR
 LOCATION LIKE '%%%s%%' ;",
                                  $db->real_escape_string($search_query),
                                  $db->real_escape_string($search_query),
                                  $db->real_escape_string($search_query),
                                  $db->real_escape_string($search_query),
                                  $db->real_escape_string($search_query));

    $db_search_result= $db->query($db_query_for_search);
    if(!$db_search_result)
        die('Query Error');
}


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Find Work - Freelancers-Meetpoint</title>
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
        <form id="freelancer-search-form" method="get" >                  
          <div id="freelancer-search-widget">               
            <input type="search" id="search-field" name="search-query" placeholder="Find what you are Looking for" value="<?php echo $search_query ?>">
            <button type="submit" id="search-button">Search</button>  
          </div>
        </form>

        <div id="freelancer-search-results">
        <!-- Search results -->
<?php if(!$search_query): ?>
          <p class="search-error-message" id="search-query-empty">Please Enter Some Query</p>
<?php elseif($db_search_result->num_rows == 0): ?>
          <p class="search-error-message" id="search-query-no-results">
          No Results Found for <span id="search-query-in-error"> <?php echo $search_query ?></span>
          </p>
<?php else: ?>
  <?php for($i=0;
            $i < $db_search_result->num_rows;
            $i++): ?>
    <?php
          $row= $db_search_result->fetch_assoc();
          //check if profile pic is there in database
          if( $row['PROFILE_PIC'] )
              $pic='/datadir/'.$row['PROFILE_PIC'];
          else
              $pic='/global/assets/unknown_person_profile_icon_grey.svg';
    ?>
    <!-- result card -->
    <a href="/view_post/view_post.php?id=<?php echo urlencode($row['ID']) ?>">
      <div class="card search-result-card freelancer-search-result-card" >
        <p class="freelancer-search-result-project-name result-title">
          <?php echo $row['PROJECT_NAME'] ?>
        </p>
        <p class="freelancer-search-result-requirement result-subtitle">
          <?php echo $row['REQUIRED_SKILL'] ?>
        </p>
        <p class="freelancer-search-employer-line result-subsubtitle">
          By <img src='<?php echo $pic ?>' width="30px" height="30px" > <?php echo $row['NAME'] ?>           
        </p>
        <p class="employer-search-result-description">
          <?php echo $row['DESCRIPTION'] ?>
        </p>
      </div>
    </a>              
  <?php endfor ?>
<?php endif; ?>

        </div>

      </div>  
	    
    </main>
  </body>
</html>
