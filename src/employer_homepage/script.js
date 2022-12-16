const suggestionButton=document.querySelectorAll(".suggestion-button");
for(i=0; i<suggestionButton.length; i++)
{
   suggestionButton[i].addEventListener('click',
    function(e)
    {
        const searchField=document.querySelector("#search-field");
        searchField.value=e.target.textContent;
        document.getElementById("employer-search-form").submit();

    } );                  
}