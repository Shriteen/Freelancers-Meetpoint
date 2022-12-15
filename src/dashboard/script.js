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

function loadUsers(pattern)
{
    fetch('getUserData.php?pattern='+pattern).then(
	(response) => {
	    if(!response.ok) {
		throw new Error('HTTP error: '+response.status);
	    }
	    return response.json();
	} )
	.then((json)=>{
	    // data fetched

	    const table= document.querySelector('#user-table-body');
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

    //TODO: confirm working backend
    fetch("deleteUser.php", {
	method: "post",
	body: data
    })
	.then((res) => { return res.text(); })
	.then((txt) => {
	    console.log(txt);
	    loadUsers('');
	    document.querySelector('#notification-message').textContent=txt;
	    window.einsModal.open('notification');
	})
	.catch((err) => {
	    console.log(err);
	    document.querySelector('#notification-message').textContent="Failed";
	});

    
    e.preventDefault();
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
loadUsers('');

const userFilter= document.querySelector('#user-search');
userFilter.addEventListener('change',()=> loadUsers(userFilter.value));

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


