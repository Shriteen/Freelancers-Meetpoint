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
      <a href="../index.html">
	<picture alt="logo">
	  <source media="(max-width:600px)" srcset="../global/assets/logo_with_name_initials.svg">
	  <source media="(min-width:601px)" srcset="../global/assets/logo_with_name.svg">
	  <img src="../global/assets/logo_with_name_initials.svg" height="45px" id="header-logo">
	</picture>
      </a>
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
	      <textarea id="create-post-description" name="project-description" required>
            </textarea>
          </li>

          <li id="post-type-selector">
            <input type="radio" id="bidable-true" name="bidable" value="true" required checked>
            <label for="bidable-true">Require Bids</label>
	      <span>or</span>
	      <input type="radio" id="bidable-false" name="direct-contact" value="false" required>
	      <label for="bidable-false">Allow Direct Contact</label>
          </li>

          <li>
            <button type="submit" id="post-project-button">Post</button>
          </li>

        </ul>
      </form>
    </main>
  </body>
</html>