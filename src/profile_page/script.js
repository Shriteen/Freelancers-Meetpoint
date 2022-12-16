raterJs({
    element:document.querySelector("#rater"),
    rateCallback:function rateCallback(rating, done) {
        this.setRating(rating);

	const ratingInput=document.querySelector('#review-rating-input');
	ratingInput.value=rating;
	
        done(); 
    },
    starSize:32,
    step:0.5
});

raterJs({
    element:document.querySelector("#profile-rating"),
    starSize:32,
    step:0.5,
    readOnly:true,
    rating: Number(document.querySelector('#profile-rating-hidden').textContent) 
});
