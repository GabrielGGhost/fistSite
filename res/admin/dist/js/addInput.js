var btnAddStep = document.getElementById('addStep');
var btnRemoveStep = document.getElementById('removeStep');

var btnAddIngredient = document.getElementById('addIngredient');
var btnRemoveIngredient = document.getElementById('removeIngredient');

btnAddStep.addEventListener('click', function(){
	addInput('steps');
});
btnRemoveStep.addEventListener('click', function(){
	removeInput();
});

btnAddIngredient.addEventListener('click', function(){
	addIngredient('ingredients');
});
btnRemoveIngredient.addEventListener('click', function(){
	removeIngredient('ingredients');
});

function addInput(divName) {

	var obj = document.querySelectorAll('.stepList');

	var count = obj.length;

	var clone = obj[0].cloneNode(true);
	var newDiv = document.createElement("div");

	newDiv.id = "step_" + (++count);
	newDiv.classList.add("stepList");
	newDiv.innerHTML = replaceAll(clone.innerHTML ,'_1' , '_' + count);
	newDiv.innerHTML = replaceAll(newDiv.innerHTML ,'º1' , 'º' + count);

	document.getElementById(divName).appendChild(newDiv);

	var lastChild = document.getElementById('steps').lastElementChild;
	lastChild.children[0].value = "";

}

function removeInput() {
	var div = document.getElementById('steps');

	var children = div.children.length

	if(children > 1){

		div.removeChild(div.lastElementChild);

	}

}

function addIngredient(divName) {
	
	var obj = document.querySelectorAll('.ingredientList');

	var count = obj.length;

	var clone = obj[0].cloneNode(true);
	var newDiv = document.createElement("div");

	newDiv.id = "ingredientList_" + (++count);
	newDiv.classList.add("ingredientList");
	newDiv.innerHTML = replaceAll(clone.innerHTML ,'_1' , '_' + count);


	document.getElementById(divName).appendChild(newDiv);

	var lastChild = document.getElementById('ingredients').lastElementChild;
	lastChild.children[0].children[0].children[1].value = "";
	lastChild.children[1].children[0].children[1].value = "";
}

function removeIngredient() {
	var div = document.getElementById('ingredients');

	var children = div.children.length
	if(children > 1){
	
		div = div.removeChild(div.lastElementChild);
	}
	
}

function replaceAll(str, needle, replacement){
    return str.split(needle).join(replacement);
}

