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

$db=connect_db();

$db_query_for_location=sprintf("SELECT LOCATION FROM FREELANCER UNION SELECT LOCATION FROM EMPLOYER");

$db_location_result=$db->query($db_query_for_location);
if(!$db_location_result)
  die('Query Error');

$db_query_for_profession=sprintf("SELECT PROFESSION FROM FREELANCER");

$db_profession_result=$db->query($db_query_for_profession);
  if(!$db_profession_result)
	die('Query Error');

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
	    <li class="submit-button-box">
	      <!-- Submit -->
	      <button type="button" id="signup-account-common-submit-button" >Next</button>
	    </li>
	  </ul>
	  
	</fieldset>

	<!-- Employer part -->
	<fieldset id="employer-signup-data" class="signup-fieldset" disabled>
	  <legend><span class="name-label"></span>, Tell us more about you</legend>

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
	    
	    <li class="submit-button-box">
	      <button type="submit" class="submit-button"  id="employer-submit-button">Start</button>
	    </li>
	  </ul>
	</fieldset>

	<!-- Freelancer part -->
	<fieldset id="freelancer-signup-data" class="signup-fieldset" disabled>
	  <legend><span class="name-label"></span>, Tell us more about you</legend>

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
	      <fieldset id="freelancer-signup-experience">
		<legend>Showcase Your Experience. Put Up Description, Images And Links Of Your Work And Achievements</legend>
		<ul id="experience-input-list">
		  <!-- Filled interactively using JS -->
		</ul>
		<div id="add-experience-buttons">
		  <button class="add-experience-button" id="add-experience-text" type="button">Describe</button>
		  <button class="add-experience-button" id="add-experience-url" type="button">Link</button>
		  <button class="add-experience-button" id="add-experience-file" type="button">Image</button>
		</div>
	      </fieldset>
	    </li>
	    
	    <li class="submit-button-box">
	      <!-- Submit -->
	      <button type="submit" class="submit-button" id="freelancer-submit-button">Start</button>
	    </li>
	  </ul>
	  
	</fieldset>

	<!-- Datalist for location shared between employer and freelancer -->
	<datalist id="location-list">
	  
	  <?php 
		for($i=0;$i < $db_location_result->num_rows;$i++)
		{
			$location_row= $db_location_result->fetch_assoc();
			echo "<option value='".$location_row['LOCATION']."'>".$location_row['LOCATION']."</option>";
		}
	  ?>
	  
	</datalist>
	<!-- Datalist for profession used for freelancer -->
	<datalist id="profession-list">
	  
	  <?php 
		for($i=0;$i < $db_profession_result->num_rows;$i++)
		{
			$profession_row= $db_profession_result->fetch_assoc();
			echo "<option value='".$profession_row['PROFESSION']."'>".$profession_row['PROFESSION']."</option>";
		}
	  ?>

	</datalist>
	
      </form>
    </main>
  </body>
</html>
