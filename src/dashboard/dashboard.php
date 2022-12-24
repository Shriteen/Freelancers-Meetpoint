<?php

require_once __DIR__.'/../global/php/common_libs.php';

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Dashboard - Freelancers-Meetpoint</title>
    <!-- favicon in tab -->
    <link href="../global/assets/favicon.png" rel="icon">
    <link href="../global/style.css" rel="stylesheet">
    <link href="../global/form_common_styles.css" rel="stylesheet">
    <link href="../global/table_common_styles.css" rel="stylesheet">     
    <link href="../libs/eins-modal.min.css" rel="stylesheet">
    <link href="../libs/vanilla-js-tabs.css" rel="stylesheet">
    <link href="../libs/billboard.min.css" rel="stylesheet">     
    <link href="style.css" rel="stylesheet">
    <script src="../libs/eins-modal.min.js" ></script>
    <script src="../libs/vanilla-js-tabs.min.js" ></script>
    <script src="../libs/d3.min.js" ></script>
    <script src="../libs/billboard.min.js" ></script>
    <script src="script.js" defer></script>
     
  </head>

<?php
     if($_SERVER['REQUEST_METHOD'] == 'GET'):
         require_once __DIR__.'/authentication_prompt.php';
     else:
         require_once __DIR__.'/authenticate_admin.php';
         
?>
   <main>  
     <div class="js-tabs" id="tabs">
       <ul class="js-tabs__header">
         <li><a href="#" class="js-tabs__title">Statistics</a></li>
         <li><a href="#" class="js-tabs__title">Manage Users</a></li>
         <li><a href="#" class="js-tabs__title">Settings</a></li>
       </ul>
      
       <div class="js-tabs__content" id="stat-page">
       <?php
           require_once __DIR__.'/statistics.php';
           present();
       ?>
       </div>

       <div class="js-tabs__content" id="manage-page">
       <?php
           require_once __DIR__.'/manage_users.php';
           present_manage();
       ?>
       </div>

       <div class="js-tabs__content" id="settings-page">
         <form id="change-password-form" action="change_pass.php" method="post" class="card">
           <legend>Change Password</legend>    
           <ul>      
             <li>
               <!-- Current Password -->
	           <label for="current-password">Current Password</label>
  	           <input type="password" id="current-password" name="current-password" maxlength="100" required>
             </li>
             <li>
               <!-- New Password -->
	           <label for="new-password">New Password</label>
  	           <input type="password" id="new-password" name="new-password" maxlength="100" required>
             </li>
             <li class="submit-button-box">
               <button type="submit" id="change-password-submit-button">Change</button>
             </li>
           </ul>
         </form>
       </div>
     </div>
   </main>  
<?php endif; ?>
     
</html>
