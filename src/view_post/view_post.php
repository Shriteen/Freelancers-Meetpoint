<?php

require_once __DIR__.'/../global/php/login_from_cookie.php';

?>

<?php

$id=$_GET['id'];

require_once __DIR__.'/../global/php/common_libs.php';

$db=connect_db();

if($id)
{
    // get from database
    $post_data= sprintf("SELECT POST.*,NAME,PROFILE_PIC,EMAIL FROM
 POST JOIN EMPLOYER ON POST.CREATED_BY=EMPLOYER.USERNAME WHERE
 ID=%d ;",
                        $db->real_escape_string($id) );

    $post_result= $db->query($post_data);
    if(!$post_result)
        die('Query Error');

    //if post of given id does not exist
    if($post_result->num_rows == 0)
        $invalid_id=true;
}
else
    $invalid_id=true;


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

      <!-- TODO: The following name, picture and menu items will be filled and populated by javascript -->
      <?php require_once $_SERVER['DOCUMENT_ROOT'].'/global/php/account_info_widget.php' ?>
    </header>
     
    
    <!-- Content -->
    <main>
<?php if($invalid_id): ?>
          <p class="error-message" id="invalid-id">No Job with This ID exists</p>
<?php else:
          $row= $post_result->fetch_assoc();

          //check if profile pic is there in database
          if( $row['PROFILE_PIC'] )
              $pic='/datadir/'.$row['PROFILE_PIC'];
          else
              $pic='/global/assets/unknown_person_profile_icon_grey.svg';

          //create mailto url

          //create current page url
          if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
              $url = "https://";   
          else  
              $url = "http://";
          $url.= $_SERVER['HTTP_HOST'];
          $url.= $_SERVER['REQUEST_URI'];

          $subject= "Application for ".$row['PROJECT_NAME']." as ".$row['REQUIRED_SKILL'];
          $message="This is in regard to $url\n";
          $mail=sprintf("mailto:%s?subject=%s&body=%s",$row['EMAIL'],$subject,$message);
?>
          <!-- details card -->
          <div class="card" id="post-details" >
            <p id="project-name" ><?php echo $row['PROJECT_NAME'] ?></p>
            <p id="employer-line">
              Posted By
              <span id="employer-pic-name">
                <img src='<?php echo $pic ?>' width="30px" height="30px" > <?php echo $row['NAME'] ?>
              </span>
            </p>
            <p id="requirement-line">
              Looking for <?php echo $row['REQUIRED_SKILL'] ?>
            </p>
              <p id="description-line">
              Details
              <p id="description">
                <?php echo $row['DESCRIPTION'] ?>
              </p>
            </p>
              
              <!-- TODO: following view should change for employer and freelancers differently --> 
            <?php if($row['ALLOW_BIDS']) : ?>
              <!-- TODO: Bids -->
            <?php else: ?>
              <a href="<?php echo $mail ?>" class="contact-button" id="contact-to-employer">
                Contact
              </a>
            <?php endif; ?>
          </div>
<?php endif; ?>
          
	    
    </main>
  </body>
</html>
