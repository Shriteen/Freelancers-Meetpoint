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
    <title>Signup - Freelancers-Meetpoint</title>
    <!-- favicon in tab -->
    <link href="../global/assets/favicon.png" rel="icon">
    <link href="../global/style.css" rel="stylesheet">
    <link href="../global/form_common_styles.css" rel="stylesheet">    
    <link href="style.css" rel="stylesheet">
    <script src="script.js" defer></script>
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
      
      <form id="signup-form" action="signup_form_handle.php" method="post" enctype="multipart/form-data" class="card">
	
	<!-- Common part for employer and freelancer -->
	<fieldset id="common-signup-data" class="signup-fieldset">
	  <legend>Enter your Details</legend>

	  <ul>
	    <li>
	      <!-- Name -->
	      <label for="signup-account-name">Name</label>
	      <input type="text" id="signup-account-name" name="account-name" maxlength="100" required>
	    </li>
	    <li>
	      <!-- Username -->
	      <label for="signup-account-username">Pick a Username</label>
	      <input type="text" id="signup-account-username" name="account-username" maxlength="100" required>
	    </li>
	    <li>
	      <!-- Email -->
	      <label for="signup-account-email">Email</label>
	      <input type="email" id="signup-account-email" name="account-email" maxlength="100" required>
	    </li>
	    <li>
	      <!-- Password -->
	      <label for="signup-account-password">Set a Password</label>
	      <input type="password" id="signup-account-password" name="account-password" maxlength="100" required>
	    </li>
	    <li>
	      <!-- Confirm Password -->
	      <label for="signup-account-confirm-password">Confirm Password</label>
	      <input type="password" id="signup-account-confirm-password" maxlength="100" required>
	    </li>
	    <li id="account-type-selector">
	      <!-- Account type -->
	      <fieldset id="account-type-selector-fieldset">
		<legend>You are here to</legend>
		<input type="radio" id="signup-account-type-employer" name="account-type" value="freelancer" required checked>
		<label for="signup-account-type-employer">Find Work</label>
		<input type="radio" id="signup-account-type-freelancer" name="account-type" value="employer" required>
		<label for="signup-account-type-freelancer">Find Talent</label>
	      </fieldset>
	    </li>
	    <li>
	      <!-- Submit -->
	      <button type="button" id="signup-account-common-submit-button">Next</button>
	    </li>
	  </ul>
	  
	</fieldset>

	<!-- Employer part -->
	<fieldset id="employer-signup-data" class="signup-fieldset" disabled>
	  <!-- TODO: Insert Name -->
	  <legend><span class="name-label">TODO</span>, Tell us more about you</legend>

	  <ul>
	    <li>
	      <!-- Location -->
	      <label for="employer-signup-location">Location</label>
	      <input type="text" id="employer-signup-location" name="account-location" list="location-list" maxlength="100" required>
	    </li>  

	    <li>
	      <!-- Profile picture -->
	      <label for="employer-signup-profile-picture">Profile Picture</label>
	      <input type="file" id="employer-signup-profile-picture" name="account-profile-picture" accept=".jpg, .jpeg, .png" required>
	      <!-- TODO: Replace the following label with name of the file using js -->
	      <label for="employer-signup-profile-picture" class="filepicker-button" id="employer-signup-profile-picture-filepicker-button">Pick a file [ jpg/png ]</label>
	    </li>
	    
	    <li>
	      <button type="submit" class="submit-button" id="employer-submit-button">Start</button>
	    </li>
	  </ul>
	</fieldset>

	<!-- Freelancer part -->
	<fieldset id="freelancer-signup-data" class="signup-fieldset" disabled>
	  <!-- TODO: Insert Name -->
	  <legend><span class="name-label">TODO</span>, Tell us more about you</legend>

	  <ul>
	    <li>
	      <!-- Profession -->
	      <label for="freelancer-signup-profession">Profession</label>
	      <input type="text" id="freelancer-signup-profession" name="account-profession" list="profession-list" maxlength="100" required>
	    </li>

	    <li>
	      <!-- Profile picture -->
	      <label for="freelancer-signup-profile-picture">Profile Picture</label>
	      <input type="file" id="freelancer-signup-profile-picture" name="account-profile-picture" accept=".jpg, .jpeg, .png" required>
	      <!-- TODO: Replace the following label with name of the file using js -->
	      <label for="freelancer-signup-profile-picture" class="filepicker-button" id="freelancer-signup-profile-picture-filepicker-button">Pick a file [ jpg/png ]</label>
	    </li>

	    <li>
	      <!-- Location -->
	      <label for="freelancer-signup-location">Location</label>
	      <input type="text" id="freelancer-signup-location" name="account-location" list="location-list" maxlength="100" required>
	    </li>  

	    <li>
	      <!-- One line description -->
	      <label for="freelancer-signup-tagline">Describe Yourself In One Line</label>
	      <input type="text" id="freelancer-signup-tagline" name="account-tagline" maxlength="250" required>
	    </li>

	    <li>
	      <!-- Charges -->
	      <fieldset id="freelancer-signup-charges">
		<legend>What Amount Do You Charge Per Hour?</legend>
		<label for="freelancer-signup-min-charges">Minimum</label>
		<input type="number" id="freelancer-signup-min-charges" name="account-min-charges" min="1" required>
		<label for="freelancer-signup-max-charges">Maximum</label>
		<input type="number" id="freelancer-signup-max-charges" name="account-max-charges" min="2" required>
		<label id="assurance-label-for-maximum" for="freelancer-signup-max-charges">This is just Expected Maximum Value, we won't be limiting Maximum Charges</label>
	      </fieldset> 
	    </li>

	    <li>
	      <!-- Experience -->
	      <!-- TODO: Add the experience inputs interactively -->
	      <!-- The text and url should have class text-or-link and files should have file -->
	      <fieldset id="freelancer-signup-experience">
		<legend>Showcase Your Experience. Put Up Description, Images And Links Of Your Work And Achievements</legend>
		<ul id="experience-innput-list">
		  <!-- Filled interactively using JS -->
		</ul>
		<div id="add-experience-buttons">
		  <button class="add-experience-button" id="add-experience-text" type="button">Describe</button>
		  <button class="add-experience-button" id="add-experience-url" type="button">Link</button>
		  <button class="add-experience-button" id="add-experience-file" type="button">Image</button>
		</div>
	      </fieldset>
	    </li>
	    
	    <li>
	      <!-- Submit -->
	      <button type="submit" class="submit-button" id="freelancer-submit-button">Start</button>
	    </li>
	  </ul>
	  
	</fieldset>

	<!-- Datalist for location shared between employer and freelancer -->
	<datalist id="location-list">
	  <!-- TODO: fill datalist using js -->
	</datalist>
	<!-- Datalist for profession used for freelancer -->
	<datalist id="profession-list">
	  <!-- TODO: fill datalist using js -->
	</datalist>
	
      </form>
    </main>
  </body>
</html>
