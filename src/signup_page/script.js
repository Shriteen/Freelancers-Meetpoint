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

					    const pass = document.querySelector("#signup-account-password");
					    const confirmPass = document.querySelector("#signup-account-confirm-password");
					    console.log(pass.value+"  "+confirmPass.value);
					    if(pass.value!==confirmPass.value)
					    {
						
						confirmPass.setCustomValidity('Password do not match');
						confirmPass.reportValidity();
						confirmPass.setCustomValidity('');						
						return;
					    }
					    else
						confirmPass.setCustomValidity('');						

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

const addExperienceTextButton= document.querySelector('#add-experience-text');
const addExperienceLinkButton= document.querySelector('#add-experience-url');
const addExperienceImageButton= document.querySelector('#add-experience-file');
const experienceInputList= document.querySelector('#experience-input-list');

let textInputCount=0;
let linkInputCount=0;
let imageInputCount=0;

addExperienceTextButton.addEventListener('click',
					 function()
					 {
					     const newListItem = document.createElement('li');
					     newListItem.setAttribute('class','experience-list-item');					     
					     
					     const newContentField = document.createElement('input');
					     newContentField.setAttribute('type','text');
					     newContentField.setAttribute('class','text-or-link');
					     newContentField.setAttribute('name','account-experience-text-'+ textInputCount );
					     newContentField.setAttribute('id','account-experience-text-'+ textInputCount );
					     newContentField.setAttribute('maxlength','100');
					     newContentField.setAttribute('required','true' );

					     const newContentLabel = document.createElement('label');
					     newContentLabel.textContent='Describe';
					     newContentLabel.setAttribute('for',newContentField.id);

					     newListItem.appendChild(newContentLabel);
					     newListItem.appendChild(newContentField);
					     experienceInputList.appendChild(newListItem);
					     textInputCount++;
					 });

addExperienceLinkButton.addEventListener('click',
					 function()
					 {
					     const newListItem = document.createElement('li');
					     newListItem.setAttribute('class','experience-list-item');					     
					     
					     const newContentField = document.createElement('input');
					     newContentField.setAttribute('type','url');
					     newContentField.setAttribute('class','text-or-link');
					     newContentField.setAttribute('name','account-experience-link-'+ linkInputCount );
					     newContentField.setAttribute('id','account-experience-link-'+ linkInputCount );
					     newContentField.setAttribute('maxlength','100');
					     newContentField.setAttribute('required','true' );

					     const newContentLabel = document.createElement('label');
					     newContentLabel.textContent='Link';
					     newContentLabel.setAttribute('for',newContentField.id);

					     const newCaptionField = document.createElement('input');
					     newCaptionField.setAttribute('type','text');
					     newCaptionField.setAttribute('class','text-or-link');
					     newCaptionField.setAttribute('name','account-experience-link-caption'+ linkInputCount );
					     newCaptionField.setAttribute('id','account-experience-link-caption'+ linkInputCount );
					     newCaptionField.setAttribute('maxlength','100');
					     newCaptionField.setAttribute('required','true' );

					     const newCaptionLabel = document.createElement('label');
					     newCaptionLabel.textContent='Caption';
					     newCaptionLabel.setAttribute('for',newCaptionField.id);
					     
					     newListItem.appendChild(newContentLabel);
					     newListItem.appendChild(newContentField);
					     newListItem.appendChild(newCaptionLabel);
					     newListItem.appendChild(newCaptionField);
					     experienceInputList.appendChild(newListItem);
					     linkInputCount++;
					 });

addExperienceImageButton.addEventListener('click',
					 function()
					 {
					     const newListItem = document.createElement('li');
					     newListItem.setAttribute('class','experience-list-item');					     
					     
					     const newContentField = document.createElement('input');
					     newContentField.setAttribute('type','file');
					     newContentField.setAttribute('class','file');
					     newContentField.setAttribute('name','account-experience-image-'+ imageInputCount );
					     newContentField.setAttribute('id','account-experience-image-'+ imageInputCount );
					     newContentField.setAttribute('accept','.jpg, .jpeg, .png' );					     
					     newContentField.setAttribute('required','true' );

					     const newContentLabel = document.createElement('label');
					     newContentLabel.textContent='Image';
					     newContentLabel.setAttribute('for',newContentField.id);

					     const newCaptionField = document.createElement('input');
					     newCaptionField.setAttribute('type','text');
					     newCaptionField.setAttribute('class','text-or-link');
					     newCaptionField.setAttribute('name','account-experience-link-caption'+ imageInputCount );
					     newCaptionField.setAttribute('id','account-experience-link-caption'+ imageInputCount );
					     newCaptionField.setAttribute('maxlength','100');
					     newCaptionField.setAttribute('required','true' );

					     const newCaptionLabel = document.createElement('label');
					     newCaptionLabel.textContent='Caption';
					     newCaptionLabel.setAttribute('for',newCaptionField.id);

					     const filePickerButton = document.createElement('label');
					     filePickerButton.textContent='Pick a file [ jpg/png ]';
					     filePickerButton.setAttribute('for',newContentField.id);
					     filePickerButton.setAttribute('class','filepicker-button');					     
					     
					     newListItem.appendChild(newContentLabel);
					     newListItem.appendChild(newContentField);
					     newListItem.appendChild(filePickerButton);
					     newListItem.appendChild(newCaptionLabel);
					     newListItem.appendChild(newCaptionField);
					     experienceInputList.appendChild(newListItem);
					     imageInputCount++;
					 });

