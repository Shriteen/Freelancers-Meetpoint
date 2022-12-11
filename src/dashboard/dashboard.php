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
    <link href="style.css" rel="stylesheet">
    <link href="../libs/vanilla-js-tabs.css" rel="stylesheet">
    <script src="../libs/vanilla-js-tabs.min.js" ></script>
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
          
       </div>

       <div class="js-tabs__content" id="manage-page">
          
       </div>

       <div class="js-tabs__content" id="settings-page">
          
       </div>
     </div>
   </main>  
<?php endif; ?>
     
</html>
