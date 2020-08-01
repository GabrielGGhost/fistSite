var line = 0,
	ingredients = 0;
var btnAddStep = document.getElementById('addStep');
var btnRemoveStep = document.getElementById('removeStep');

var btnAddIngredient = document.getElementById('addIngredient');
var btnRemoveIngredient = document.getElementById('removeIngredient');

btnAddStep.addEventListener('click', function(){
	addInput('stepLines');
});
btnRemoveStep.addEventListener('click', function(){
	removeInput('stepLines');
});

btnAddIngredient.addEventListener('click', function(){
	addIngredient('ingredients');
});
btnRemoveIngredient.addEventListener('click', function(){
	removeIngredient('ingredients');
});

function addInput(divName) {
	line < 1 ? line = 0 : line = line; 
  var newdiv = document.createElement('div');
  newdiv.innerHTML += '<input type="text" class="form-control stepInput" id="step' + (line+1) + '" name="recipeName" placeholder="Passo Nº' + (line+1) +'" maxlength="200">';
  document.getElementById(divName).appendChild(newdiv);
  line++;
}

function removeInput() {
	var div = document.getElementById('stepLines');

	div.removeChild(div.lastChild);
  	line--;
}

function addIngredient(divName) {
	ingredients < 2 ? ingredients = 1 : ingredients = ingredients; 
	var obj = document.getElementById('ingredients1');
	var clone = obj.cloneNode(true);

	var newDiv = document.createElement("div");
	newDiv.innerHTML = replaceAll(clone.innerHTML ,'_1' , '_' + (ingredients+1));


	document.getElementById(divName).appendChild(newDiv);

	ingredients++;
}

function removeIngredient() {
	var div = document.getElementById('ingredients');

	if(div.children.length > 1){
	
		div = div.removeChild(div.lastChild);
  		ingredients--;		
	}
	
}

function replaceAll(str, needle, replacement){
    return str.split(needle).join(replacement);
}

