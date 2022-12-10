<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

?>

<?php

$user=$_GET['user'];

require_once __DIR__.'/../global/php/common_libs.php';

$db=connect_db();

//base info
if($user)
{
    // get from database
    $freelancer_data= sprintf("SELECT * FROM FREELANCER WHERE USERNAME='%s' ;",
                        $db->real_escape_string($user) );
    
    $freelancer_result= $db->query($freelancer_data);
    if(!$freelancer_result)
        die('Query Error');

    //if freelancer of given username does not exist
    if($freelancer_result->num_rows == 0)
        $invalid_user=true;
}
else
    $invalid_user=true;


if(!$invalid_user)
{
    // The freelancer with given username exists
    $baseinfo= $freelancer_result->fetch_assoc();
    
    //check if profile pic is there in database
    if( $baseinfo['PROFILE_PIC'] )
        $fpic='/datadir/'.$baseinfo['PROFILE_PIC'];
    else
        $fpic='/global/assets/unknown_person_profile_icon_grey.svg';

    
    //create mailto url
    //create current page url
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $url = "https://";   
    else  
        $url = "http://";
    $url.= $_SERVER['HTTP_HOST'];
    $url.= $_SERVER['REQUEST_URI'];
    
    $subject= "Work offer";
    $message="I am Impressed by your profile on freelancers-meetpoint and would like to offer you a project ";
    $mail=sprintf("mailto:%s?subject=%s&body=%s",$baseinfo['EMAIL'],$subject,$message);


    //get the reviews
    $review_data= sprintf("SELECT
 REVIEWS.*,
 EMPLOYER.NAME AS REVIEWER_NAME,
 EMPLOYER.PROFILE_PIC AS E_PICTURE
FROM REVIEWS JOIN EMPLOYER ON REVIEWS.REVIEWER=EMPLOYER.USERNAME
WHERE REVIEWEE='%s' ;",
                          $db->real_escape_string($user) );
    
    $review_result= $db->query($review_data);
    if(!$review_result)
        die('Query Error');

    //check if reviews exist in database
    if($review_result->num_rows > 0)
        $review_section=true;


    //get the experience
    // text experience
    $exp_text= sprintf("SELECT CONTENT FROM EXPERIENCE WHERE USERNAME='%s' AND TYPE='TEXT' ;",
                       $db->real_escape_string($user) );
    $exp_text_result= $db->query($exp_text);
    if(!$exp_text_result)
        die('Query Error');
    
    // link experience
    $exp_link= sprintf("SELECT CONTENT,CAPTION FROM EXPERIENCE WHERE USERNAME='%s' AND TYPE='LINK' ;",
                       $db->real_escape_string($user) );
    $exp_link_result= $db->query($exp_link);
    if(!$exp_link_result)
        die('Query Error');
    
    // image experience
    $exp_image= sprintf("SELECT CONTENT,CAPTION FROM EXPERIENCE WHERE USERNAME='%s' AND TYPE='IMAGE' ;",
                       $db->real_escape_string($user) );
    $exp_image_result= $db->query($exp_image);
    if(!$exp_image_result)
        die('Query Error');
    
    
}


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Find Talent - Freelancers-Meetpoint</title>
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
<?php if($invalid_user): ?>
          <p class="error-message" id="invalid-user">No Profile Found</p>
<?php else: ?>
      <div id="profile-page-outer-box" class="card">

        <div id="profile-heading-card">
        <!-- The Card with picture and main info -->
          <div id="profile-main-info">
            <!-- profile pic -->
            <div id="profile-pic-box">
              <img src='<?php echo $fpic ?>' width="175px" height="175px" >
            </div>
            <!-- Name, profession and tagline -->    
            <div id="profile-name-section" >
              <p class="profile-name result-title">
                <?php echo $baseinfo['NAME'] ?>
              </p>
              <p class="profile-profession result-subtitle">
                <?php echo $baseinfo['PROFESSION'] ?>
              </p>
              <p class="profile-description result-subsubtitle">
                <?php echo $baseinfo['DESCRIPTION'] ?>
              </p>
            </div>
          </div>                            

          <hr>

          <div id="profile-details">
            <!-- Rating, charges and location -->    
            <div id="profile-minor-details-box">
            <p id="profile-ratings-summary">
            <?php $rating=get_rating_of($user);
              if ($rating)
                echo $rating."/5 Stars";
              else
                  echo "No Reviews Yet";
            ?>
            </p>

              <p id="profile-charges">
                <?php echo "Charges ₹".$baseinfo['MIN_CHARGES']."-".$baseinfo['MAX_CHARGES']." Per Hour" ?>
              </p>
              <p class="profile-location">
                <?php echo $baseinfo['LOCATION'] ?>
              </p>
            </div>
            <!-- contact-button -->
            <div id="contact-button-box">
              <a href="<?php echo $mail ?>" class="contact-button freelancer-contact-button" > Contact </a>
            </div>    
          </div>
        </div>

        <?php if($review_section) : ?>
        <div id="review-display-section">
          <?php while( $rev=$review_result->fetch_assoc() ) : ?>
        
          <div class="review-box" >
            <img src='
                      <?php
                           if( $rev['E_PICTURE'] )
                               echo '/datadir/'.$rev['E_PICTURE'];
                           else
                               echo '/global/assets/unknown_person_profile_icon_grey.svg';
                      ?>
                     ' width="30px" height="30px" >
            <span class="reviewer-name" ><?php echo $rev['REVIEWER_NAME'] ?></span>           
            <p class="review-rating">
            <?php //TODO: convert to stars
              echo $rev['RATING']."/5 Stars";
            ?>
            </p>
            <p class="review-description">
              <?php echo $rev['DESCRIPTION'] ?>
            </p>
          </div>    
          <?php endwhile; ?>
        </div>
        <?php endif; ?>


        <?php if($ACCOUNT_TYPE=='employer') : ?>
        <!-- write review section -->
        <div class="review-create-section">
          <form action="review_handle.php" method="post">
          <ul>
            <li>
	          <label for="review-rating-input">Rating</label>
	          <input type="number" id="review-rating-input" name="rating" min="0.5" max="5" step="0.5" required>
            </li>
            <li>
              <button type="submit" id="review-submit-button">Post Review</button>
            </li>
            <li>
              <label for="review-description">Description</label>
	          <textarea id="review-description" name="description" ></textarea>
            </li>
	        <input type="text" name="reviewer" value="<?php echo $USERNAME ?>" hidden>
	        <input type="text" name="reviewee" value="<?php echo $user ?>" hidden>
          </ul>
          </form>
        </div>
        <?php endif; ?>

        <?php if(($exp_text_result->num_rows+$exp_link_result->num_rows+$exp_image_result->num_rows) > 0 ) :?>
          <!-- any experience data exists -->
          <p>Gallery</p>
          <div class="experience-gallery-section">

          <!-- any text type experience data exists -->          
          <?php if($exp_text_result->num_rows > 0 ) :?>
            <div class="experience-gallery-text-section">
    
              <?php while( $etrow=$exp_text_result->fetch_assoc() ) : ?>
              <div class="experience-box text-experience-box" >
                <p class="experience-text">
                  <?php echo $etrow['CONTENT']; ?>
                </p>
              </div>    
              <?php endwhile; ?>
    
            </div>
          <?php endif; ?>
    
          <!-- any link type experience data exists -->          
          <?php if($exp_link_result->num_rows > 0 ) :?>
            <div class="experience-gallery-link-section">
    
              <?php while( $elrow=$exp_link_result->fetch_assoc() ) : ?>
              <div class="experience-box link-experience-box" >
                <a href=<?php echo $elrow['CONTENT'] ?> class="experience-link" >
                  <?php echo $elrow['CAPTION']; ?>
                </a>
              </div>    
              <?php endwhile; ?>
    
            </div>
          <?php endif; ?>

          <!-- any image type experience data exists -->
          <?php if($exp_image_result->num_rows > 0 ) :?>
            <div class="experience-gallery-image-section">
    
              <?php while( $eirow=$exp_image_result->fetch_assoc() ) : ?>
              <div class="experience-box image-experience-box" >
                <figure class="experience-image-figure" >
                  <img src="<?php echo '/datadir/'.$eirow['CONTENT'] ?>" width="400px" >
                  <figcaption><?php echo $eirow['CAPTION']; ?></figcaption>
                </figure>
              </div>    
              <?php endwhile; ?>
    
            </div>
          <?php endif; ?>
    
          </div>    
        <?php endif; ?>
    
      </div>
<?php endif; ?>
          
	    
    </main>
  </body>
</html>
