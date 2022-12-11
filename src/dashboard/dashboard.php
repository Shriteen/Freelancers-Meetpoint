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
  </head>

<?php
     if($_SERVER['REQUEST_METHOD'] == 'GET'):
         require_once __DIR__.'/authentication_prompt.php';
     else:
         require_once __DIR__.'/authenticate_admin.php';
         
?>
     
<?php endif; ?>
     
</html>
