var recipeCard = document.getElementsByClassName("recipe-card");


for (var i = 0; i < recipeCard.length; i++) {

	recipeCard[i].addEventListener('click', function(){
		var id = this.className;
		id = id.split(' ');
		id = id[1].split('_');
		id = id[1];

		var openButton = document.getElementById('openButton_' + id);

		openButton.click();
	});
}




