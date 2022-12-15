<?php

function present_manage() { ?>

<input type="search" name="user-search" id="user-search" placeholder="search for a user">
<table id="user-table" >
  <thead>      
    <tr><th>Account Type</th><th>Name</th><th>Username</th><th>Delete</th></tr>
  </thead>
  <tbody id="user-table-body">

  </tbody>
</table>

<!-- popup -->
<div id="confirm-prompt" class="eins-modal">
  <div class="eins-modal-content">
    <div class="eins-modal-close"></div>
    <p>Are you sure you want to delete <span id="popup-username">TODO </span> ? Enter Admin Password to confirm</p>  
    <form id="delete-user-form">
      <input type="password" maxlength="100" name="admin-password" required>
      <input type="text" name="account-type" required hidden >
      <input type="text" name="username" required hidden >        
      <button type="submit" id="delete-user-submit" class="eins-modal-close-button">Delete</button>
    </form>    
  </div>
</div>

<!-- notification -->
<div id="notification" class="eins-modal">
  <div class="eins-modal-content">
    <div class="eins-modal-close"></div>
    <p id="notification-message"></p>    
  </div>
</div>
        
        
<?php } ?>
