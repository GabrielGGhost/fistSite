var ingredientItens = document.getElementsByClassName('item');

for (var i = 0; i < ingredientItens.length; i++) {
	ingredientItens[i].addEventListener('click', function(){
		var item = this;
		if(item.style.textDecoration === "") item.style.textDecoration = 'line-through';
		else item.style.textDecoration = "";
	})
}