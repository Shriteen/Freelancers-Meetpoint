<?php
// present to user, data is queried by javascript
function present() { ?>
    <div id="stat-period-selector">
        <label for="start-date" >Start Date</label>  
        <input type="date" name="start-date" >
        <label for="end-date" >End Date</label>   
        <input type="date" name="end-date" >
    </div>
    <div id="statistics-data-section">
      <div id="freelancer-account-count">
        <p class="stat-title"> New Freelancer Accounts </p>
        <p class="stat-data"></p>
      </div>
      <div id="employer-account-count">
        <p class="stat-title"> New Employer Accounts </p>
        <p class="stat-data"></p>
      </div>
      <div id="post-count">
        <p class="stat-title"> New Posts </p>
        <p class="stat-data"></p>
      </div>
      <div id="bid-count">
        <p class="stat-title"> Bids Made </p>
        <p class="stat-data"></p>
      </div>
    </div>


    
<?php } ?>
