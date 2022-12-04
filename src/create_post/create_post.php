<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Create Post - Freelancers-Meetpoint</title>
    <!-- favicon in tab -->
    <link href="/global/assets/favicon.png" rel="icon">
    <link href="/global/style.css" rel="stylesheet">
     <!-- TODO: uncomment while styling
     <link href="/global/form_common_styles.css" rel="stylesheet">
    -->
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
      <form id="create-post-form" action="create_post_handle.php" method="post" class="card">
        <ul>
          <li>
            <!-- Name of Project -->
	        <label for="create-post-project-name">Name of Project</label>
	        <input type="text" id="create-post-project-name" name="project-name" maxlength="100" required>
          </li>
    
          <li>
            <!-- Looking for -->
	        <label for="create-post-skill-required">Looking for</label>
	        <input type="text" id="create-post-skill-required" name="skill-required" maxlength="100" required>
          </li>

          <li>
            <!-- Description -->
	        <label for="create-post-description">description</label>
	        <textarea id="create-post-description" name="project-description" required> </textarea>
          </li>

          <li id="post-type-selector">
            <input type="radio" id="bidable-true" name="bidable" value="true" required checked>
            <label for="bidable-true">Require Bids</label>
	        <span>or</span>
	        <input type="radio" id="bidable-false" name="bidable" value="false" required>
	        <label for="bidable-false">Allow Direct Contact</label>
          </li>

          <li>
            <button type="submit" id="post-project-submit-button">Post</button>
          </li>
        </ul>
      </form>      	    
    </main>
  </body>
</html>
