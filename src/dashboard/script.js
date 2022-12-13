function loadStats()
{
    const url="getStatData.php?"+"start-date="+startDate.value+"&"+"end-date="+endDate.value;
    
    fetch(url).then(
	(response) => {
	    if(!response.ok) {
		throw new Error('HTTP error: '+response.status);
	    }
	    return response.json();
	} )
	.then((json)=>{
	    //load into document
	    console.log(json);

	    const empAccCount= document.querySelector('#employer-account-count .stat-data');
	    empAccCount.textContent=json['employer-account-count'];

	    const freeAccCount= document.querySelector('#freelancer-account-count .stat-data');
	    freeAccCount.textContent=json['freelancer-account-count'];

	    const postCount= document.querySelector('#post-count .stat-data');
	    postCount.textContent=json['post-count'];

	    const bidCount= document.querySelector('#bid-count .stat-data');
	    bidCount.textContent=json['bid-count'];
	    
	    
	} )
	.catch((e)=>{
	    console.log('Fetch error:'+e.message);
	} );
    
}

let tabs = new Tabs({
    elem: 'tabs',
    open: 0
} );


const startDate= document.querySelector('#stat-period-selector>input[name="start-date"]');
const endDate= document.querySelector('#stat-period-selector>input[name="end-date"]');
//today
endDate.value=new Date().toISOString().slice(0,10);
// 1 year before
startDate.value=new Date().getFullYear()-1 + new Date().toISOString().slice(4,10);

startDate.addEventListener('change',loadStats);
endDate.addEventListener('change',loadStats);

loadStats();
