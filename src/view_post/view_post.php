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


          if($row['ALLOW_BIDS'])
          {
              $bid_query= sprintf("SELECT BIDS_FOR.*,NAME,EMAIL FROM
 BIDS_FOR JOIN FREELANCER ON BIDS_FOR.FREELANCER_USERNAME=FREELANCER.USERNAME WHERE
 POST_ID=%d ORDER BY AMOUNT;",
                                  $db->real_escape_string($row['ID']) );

              $bid_result= $db->query($bid_query);
              if(!$bid_result)
                  die('Query Error');
              
              if($bid_result->num_rows > 0)
                  $bids_present=true;
              else
                  $bids_present=false;
          }

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
          </div>

          <div class="post-interactive-section card" >    

             <!-- TODO: following view should change for employer and freelancers differently -->
            <?php if( $ACCOUNT_TYPE == 'freelancer' ) : ?>
              <!-- freelancer is viewing -->
              <?php if($row['ALLOW_BIDS']) : ?>
              <!-- show bids -->
                <?php if($bids_present) : ?>
                  <table class="bid-table" id="freelancer-bid-table" >
                  <th>Bidder</th><th>Amount</th>
                  <!-- Show all bids -->
                  <?php while($brow=$bid_result->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo $brow['NAME'] ?></td>
                      <td><?php echo $brow['AMOUNT'] ?></td>
                    </tr>
                  <?php endwhile; ?> 
                  </table>
                <?php else: ?>
                  <p id="no-bids-message" >There are No bids yet! Start bidding </p>
                <?php endif; ?>
                       
              <!-- input for bids -->
              <form action="process_bid.php" method="post">
                <label for="bid-amount-input" >Bid Amount</label>
                <input type="number" min="1" name="bid-amount" id="bid-amount-input" required>
                <input type="text" name="freelancer-name" hidden value=<?php echo $USERNAME ?>>
                <input type="text" name="post-id" hidden value=<?php echo $id ?>>
                <button type="submit" >Bid</button>
              </form>
              <?php else: ?>
                <a href="<?php echo $mail ?>" class="contact-button" id="contact-to-employer">
                  Contact
                </a>
              <?php endif; ?>
            <?php else: ?>
              <!-- employer is viewing -->
              <!-- TODO: Make sure other employers can not see this -->
              <!-- Bids are enabled and OP is viewing -->              
              <?php if($row['ALLOW_BIDS'] && $row['CREATED_BY']==$USERNAME ) : ?>
              <!-- show bids -->
                <?php if($bids_present) : ?>
                  <table class="bid-table" id="freelancer-bid-table" >
                  <th>Bidder</th><th>Amount</th><th>Contact</th>
                  <!-- Show all bids -->
                  <?php while($brow=$bid_result->fetch_assoc()): ?>
                    <tr>
                      <td><a href="/profile_page/profile_page.php?user=<?php echo urlencode($brow['FREELANCER_USERNAME']) ?>"><?php echo $brow['NAME'] ?></a></td>
                      <td><?php echo $brow['AMOUNT'] ?></td>
                      <?php
                        $subject= "Response to bid for ".$row['PROJECT_NAME']." as ".$row['REQUIRED_SKILL'];
                        $message="This is in regard to $url\n";
                        $mail=sprintf("mailto:%s?subject=%s&body=%s",$brow['EMAIL'],$subject,$message);
                      ?>
                      <td>
                        <a href="<?php echo $mail ?>" class="contact-button freelancer-contact-button" >
                          Contact
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?> 
                  </table>
                <?php else: ?>
                  <p id="no-bids-message" >There are No Bids yet </p>
                <?php endif; ?>
              <?php else: ?>
                <p id="no-bids-message">Freelancers can directly Contact you, Check your Inbox!</p>
              <?php endif; ?>
            <?php endif; ?>

          </div>    
<?php endif; ?>
          
	    
    </main>
  </body>
</html>
