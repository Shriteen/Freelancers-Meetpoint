<?php
// present to user, data is queried by javascript
function present() { ?>
    <div id="stat-period-selector">
      <div id="stat-period-start">  
        <label for="start-date" >Start Date</label>  
        <input type="date" name="start-date" >
      </div>                               
      <div id="stat-period-end">
        <label for="end-date" >End Date</label>   
        <input type="date" name="end-date" >
      </div>                             
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

    <div id="graph-range-selector">
      <label for="time-scale" >Select Period</label>  
      <select id="time-scale">
        <option value="years">Last 5 years</option>
        <option value="months">This Year</option>
        <option value="days" selected>Last week</option>  
      </select>
    </div>

    <div id="statistics-graph-section">
      <div id="freelancer-account-graph">
        <p class="stat-title"> Freelancer Accounts </p>
        <div class="stat-chart" id="stat-chart-freelancer"></div>
      </div>
      <div id="employer-account-graph">
        <p class="stat-title"> Employer Accounts </p>
        <div class="stat-chart" id="stat-chart-employer"></div>
      </div>
      <div id="post-graph">
        <p class="stat-title"> Posts </p>
        <div class="stat-chart" id="stat-chart-post"></div>
      </div>
      <div id="bid-graph">
        <p class="stat-title"> Bids Made </p>
        <div class="stat-chart" id="stat-chart-bid"></div>
      </div>
    </div>
    
<?php } ?>
