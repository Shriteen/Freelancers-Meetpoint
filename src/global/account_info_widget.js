const accountWidgetMenu = document.querySelector('#hamburger-menu');

//if menu exists that means that logged in and we add further interactivity
if(accountWidgetMenu)
{
    // clicking on widget button shows menu, clicking on close hides it
    const accountWidgetButton = document.querySelector('#account-info-button');
    const accountWidgetMenuCloseButton = document.querySelector('#hamburger-menu-close');
    
    accountWidgetButton.addEventListener('click',
					 () => accountWidgetMenu.setAttribute('class','') );

    accountWidgetMenuCloseButton.addEventListener('click',
					 () => accountWidgetMenu.setAttribute('class','hidden') );
    
}
