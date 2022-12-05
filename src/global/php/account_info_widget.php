<button id="account-info-button" class= <?php
     if($LOGGED_IN)
         echo '"logged-in"';
     else
         echo '"logged-out"'; ?> >
  <?php
 //get the profile picture if present
require_once __DIR__.'/common_libs.php';

if($LOGGED_IN)
{
    $db= connect_db();

    $query= sprintf("SELECT PROFILE_PIC,NAME FROM %s WHERE USERNAME='%s'",
                    get_table_of_type($ACCOUNT_TYPE),
                    $db->real_escape_string($USERNAME));
    $result= $db->query($query);
    if(!$result)
        die('Query Error');
    
    $row=$result->fetch_assoc();
    
    if(!$row)
        die('invalid username');
    
    // valid data in row

    //check if profile pic is there in database
    if( $row['PROFILE_PIC'] )
        $pic='/datadir/'.$row['PROFILE_PIC'];
    else
        $pic='/global/assets/unknown_person_profile_icon.svg';

    $name=$row['NAME'];

    
}
else
{
    $pic='/global/assets/unknown_person_profile_icon.svg';
}
    

  ?>
  <img id="account-info-profile-pic" src="<?php echo $pic ?>" height="30px">
  <!-- following is hidden when logged in -->
  <p>Sign In</p>
  <img id="hamburger-icon" src="/global/assets/hamburger_menu_icon.svg" height="25px">
</button>


<?php if($LOGGED_IN): ?>    
<!-- show menu if logged in -->
<div id="hamburger-menu" class="hidden">
  <div id="hamburger-menu-header">
    <p id="hamburger-menu-account-name"><?php echo $name ?></p>
    <button id="hamburger-menu-close">
      <img src="/global/assets/close.svg" height="20px">
    </button>
  </div>
    
  <ul>    
    <!-- home -->
    <?php
    if($ACCOUNT_TYPE == 'employer')
        $homepage='/employer_homepage/employer_homepage.php';
    else
        $homepage='/freelancer_homepage/freelancer_homepage.php';
    ?>
    <a href="<?php echo $homepage ?>">
      <li class="menu-item">
        <img src="/global/assets/home.svg" height="20px">
        <span>Home</span>
      </li>
    </a>

    <!-- logout -->
    <a href="/global/php/logout.php">
      <li class="menu-item">
        <img src="/global/assets/logout.svg" height="20px">
        <span>Logout</span>
      </li>
    </a>
    
    
<?php
    // call hook to add items to menu, they should be in above template format
    if(function_exists('add_to_menu_hook'))
        add_to_menu_hook();        
?>
  </ul>
</div>
<?php endif; ?>    

