const commonFormSubmitButton=document.querySelector("#signup-account-common-submit-button");

commonFormSubmitButton.addEventListener('click',
					function()
					{
					    // check for validity of each input
					    const inputs=document.querySelectorAll("#common-signup-data input");
					    for(i=0; i<inputs.length; i++)
					    {
						if(!inputs[i].reportValidity())
						    return;
					    }
					    console.log('All common part inputs valid');

					    //TODO: check if passwords identical using custom validity

					    //hide common part and display relevent part based on account type
					    const commonForm=document.querySelector("#common-signup-data");
					    commonForm.classList.add('hidden');
					    
					    switch(document.querySelector('input[name="account-type"]:checked').value)
					    {
						case "employer":
						console.log('employer');
						const employerForm=document.querySelector("#employer-signup-data");
						employerForm.disabled=false;
						break;
						
						case "freelancer":
						console.log('freelancer');
						const freelancerForm=document.querySelector("#freelancer-signup-data");
						freelancerForm.disabled=false;
						break;
					    }

					    //add name in second part
					    const nameLabel=document.querySelectorAll(".name-label");
					    for(i=0; i<nameLabel.length; i++)
					    {
						nameLabel[i].textContent = document.querySelector("#signup-account-name").value;
					    }
					});
