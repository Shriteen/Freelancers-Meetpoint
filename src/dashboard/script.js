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

function loadGraph()
{
    let list=getDateIntervalList();
    let promiseList=[];
    
    for(i=0; i<list.length-1; i++)
    {
	let url="getStatData.php?"+"start-date="+list[i]+"&"+"end-date="+list[i+1];
	promiseList.push(
	    fetch(url).then(
		(response)=>{
		    if(!response.ok) {
			throw new Error('HTTP error: '+response.status);
		    }
		    return response.json();   
		}
	    ));	
    }

    Promise.all(promiseList).then(
	(jsons) => {
	    let freelancerStatList=[];
	    let employerStatList=[];
	    let postStatList=[];
	    let bidStatList=[];
	    
	    for (const json of jsons) {
		freelancerStatList.push(json["freelancer-account-count"]);
		employerStatList.push(json["employer-account-count"]);
		postStatList.push(json["post-count"]);
		bidStatList.push(json["bid-count"]);		
	    }


	    let formatStr;
	    let period;
	    switch(list.length)
	    {
		case 6:
		period="Year";
		formatStr="%Y";
		break;
		case 13:
		period="Month";
		formatStr="%b";
		break;
		case 8:
		period="Day";
		formatStr="%d %b";
		break;
	    }
	    
	    //create the graphs
	    bb.generate({
		data: {
		    x: "x",
		    columns: [
			["x"].concat( (period==='Day') ?
				      list.slice(1)    :
				      list.slice(0,-1) ) ,
			[period].concat(freelancerStatList)
		    ],
		    types: {
			period: "line",
		    }
		},
		axis: {
		    x: {
			type: "timeseries",
			tick: {
			    format: formatStr
			}
		    }
		},
		bindto: "#stat-chart-freelancer"
	    });

	    bb.generate({
		data: {
		    x: "x",
		    columns: [
			["x"].concat( (period==='Day') ?
				      list.slice(1)    :
				      list.slice(0,-1) ),
			[period].concat(employerStatList)
		    ],
		    types: {
			period: "line",
		    }
		},
		axis: {
		    x: {
			type: "timeseries",
			tick: {
			    format: formatStr
			}
		    }
		},
		bindto: "#stat-chart-employer"
	    });

	    bb.generate({
		data: {
		    x: "x",
		    columns: [
			["x"].concat( (period==='Day') ?
				      list.slice(1)    :
				      list.slice(0,-1) ),
			[period].concat(postStatList)
		    ],
		    types: {
			period: "line",
		    }
		},
		axis: {
		    x: {
			type: "timeseries",
			tick: {
			    format: formatStr
			}
		    }
		},
		bindto: "#stat-chart-post"
	    });
	    
	    bb.generate({
		data: {
		    x: "x",
		    columns: [
			["x"].concat( (period==='Day') ?
				      list.slice(1)    :
				      list.slice(0,-1) ),
			[period].concat(bidStatList)
		    ],
		    types: {
			period: "line",
		    }
		},
		axis: {
		    x: {
			type: "timeseries",
			tick: {
			    format: formatStr
			}
		    }
		},
		bindto: "#stat-chart-bid"
	    });
	    
	}
    );
}

function loadUsers(pattern,actype)
{    
    fetch('getUserData.php?pattern='+pattern+'&type='+actype).then(
	(response) => {
	    if(!response.ok) {
		throw new Error('HTTP error: '+response.status);
	    }
	    return response.json();
	} )
	.then((json)=>{
	    // data fetched

	    const table= document.querySelector('#'+actype+'-table .user-table-body');
	    //clear previous data
	    while(table.firstChild)
		table.removeChild(table.firstChild);
	    
	    for(user of json)
	    {
		let row= document.createElement('tr');
		let type= document.createElement('td');
		let name= document.createElement('td');
		let uname= document.createElement('td');
		let btnbox= document.createElement('td');
		let btn= document.createElement('button');

		type.textContent=user['TYPE'];
		name.textContent=user['NAME'];
		uname.textContent=user['USERNAME'];
		btn.textContent= 'Delete';
		btn.setAttribute('id','del-btn~'+user['TYPE']+'~'+user['USERNAME']);
		btn.setAttribute('class','del-btn');
		btn.setAttribute('data-modal-id','confirm-prompt');
		
		btnbox.appendChild(btn);
		row.appendChild(type);
		row.appendChild(name);
		row.appendChild(uname);
		if(actype=='freelancer')
		{
		    let profession=document.createElement('td');
		    profession.textContent=user['PROFESSION'];
		    row.appendChild(profession);
		}
		row.appendChild(btnbox);
		table.appendChild(row);

		window.einsModal.addButton(btn.getAttribute('id'), 'confirm-prompt');
	    }
	    
	} )
	.catch((e)=>{
	    console.log('Fetch error:'+e.message);
	} );
    
}

function deleteUserPrompt(e)
{    
    const btn=e.relatedTarget;
    let type=btn.getAttribute('id').split('~')[1];
    let username=btn.getAttribute('id').split('~')[2];

    document.querySelector('input[name="account-type"]').value=type;
    document.querySelector('input[name="username"]').value=username;

    document.querySelector('#popup-username').textContent=username;    
}

function deleteUser(e)
{
    console.log(e.target);
    var data=new FormData(e.target);

    fetch("deleteUser.php", {
	method: "post",
	body: data
    })
	.then((res) => { return res.text(); })
	.then((txt) => {
	    console.log(txt);
	    loadUsers('',userTypeFilter.value);
	    document.querySelector('#notification-message').textContent=txt;
	    window.einsModal.open('notification');
	})
	.catch((err) => {
	    console.log(err);
	    document.querySelector('#notification-message').textContent="Failed";
	});

    
    e.preventDefault();
}

function updateTableVisibility()
{
    if(userTypeFilter.value==="employer")
    {
	document.querySelector('#employer-table').style.display="table";
	document.querySelector('#freelancer-table').style.display="none";
    }
    else
    {
	document.querySelector('#employer-table').style.display="none";
	document.querySelector('#freelancer-table').style.display="table";
    }
}

function getDateIntervalList()
{
    switch(periodSelector.value)
    {
	case 'years':
	//get last 5 years
	return [new Date().getFullYear()-4 + "-01-01",
		new Date().getFullYear()-3 + "-01-01",
		new Date().getFullYear()-2 + "-01-01",
		new Date().getFullYear()-1 + "-01-01",
		new Date().getFullYear() + "-01-01",
		new Date().getFullYear()+1 + "-01-01" ];
	case 'months':
	//get current year
	return [new Date().getFullYear() + "-01-01",
		new Date().getFullYear() + "-02-01" ,
		new Date().getFullYear() + "-03-01",
		new Date().getFullYear() + "-04-01" ,
		new Date().getFullYear() + "-05-01" ,
		new Date().getFullYear() + "-06-01" ,
		new Date().getFullYear() + "-07-01" ,
		new Date().getFullYear() + "-08-01" ,
		new Date().getFullYear() + "-09-01",
		new Date().getFullYear() + "-10-01" ,
		new Date().getFullYear() + "-11-01",
		new Date().getFullYear() + "-12-01",
		new Date().getFullYear()+1 + "-01-01" 
	       ];
	case 'days':
	let d=new Date();
	let li=[];
	d.setDate(d.getDate()-7);
	li.push(d.toISOString().slice(0,10));
	d.setDate(d.getDate()+1);
	li.push(d.toISOString().slice(0,10));
	d.setDate(d.getDate()+1);
	li.push(d.toISOString().slice(0,10));
	d.setDate(d.getDate()+1);
	li.push(d.toISOString().slice(0,10));
	d.setDate(d.getDate()+1);
	li.push(d.toISOString().slice(0,10));
	d.setDate(d.getDate()+1);
	li.push(d.toISOString().slice(0,10));
	d.setDate(d.getDate()+1);
	li.push(d.toISOString().slice(0,10));
	d.setDate(d.getDate()+1);
	li.push(d.toISOString().slice(0,10));
	return li;
    }    
}

let tabs = new Tabs({
    elem: 'tabs',
    open: 0
} );

const startDate= document.querySelector('#stat-period-start>input[name="start-date"]');
const endDate= document.querySelector('#stat-period-end>input[name="end-date"]');
//today
endDate.value=new Date().toISOString().slice(0,10);
// 1 year before
startDate.value=new Date().getFullYear()-1 + new Date().toISOString().slice(4,10);

startDate.addEventListener('change',loadStats);
endDate.addEventListener('change',loadStats);

const periodSelector= document.querySelector('#time-scale');
periodSelector.addEventListener('change',loadGraph);

const userFilter= document.querySelector('#user-search');
const userTypeFilter= document.querySelector('#user-type-select-menu');

loadStats();
loadGraph();
updateTableVisibility();
loadUsers('',userTypeFilter.value);

userFilter.addEventListener('change',()=> loadUsers(userFilter.value,userTypeFilter.value));
userTypeFilter.addEventListener('change',()=> loadUsers(userFilter.value,userTypeFilter.value));

userTypeFilter.addEventListener('change',updateTableVisibility);


const popupBox= document.querySelector('#confirm-prompt');
popupBox.addEventListener('shown.eins.modal',deleteUserPrompt);

const delUserForm= document.querySelector('#delete-user-form');
delUserForm.addEventListener('submit',deleteUser);

if(location.href.split('#')[1]=='stat-page'){
    tabs.open(0);
}else if(location.href.split('#')[1]=='manage-page'){
    tabs.open(1);
}else if(location.href.split('#')[1]=='settings-page'){
    tabs.open(2);
}


