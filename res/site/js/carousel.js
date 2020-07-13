function Carousel(config){
  //LAPTOP SLIDE
  this.container = (typeof config.container === 'string') ?
  document.querySelector(config.container) : config.container;//Receber a classe container de config

  this.itens = (typeof config.itens === 'string') ?
  this.container.querySelectorAll(config.itens) : config.itens; //Receber a classe itens de config

  this.btnPrev = (typeof config.btnPrev === 'string') ?
  this.container.querySelector(config.btnPrev) : config.btnPrev; //Receber a classe btnPrev de config

  this.btnNext = (typeof config.btnNext === 'string') ?
  this.container.querySelector(config.btnNext) : config.btnNext; //Receber a classe btnNext de config

  var _this = this; //Salva uma cópia desta instancia
  var _currentSlide = 0; //Variável local com valor 0;

  init();//Chamar método de iniciar

  function init(){
  var _show = _this.container.querySelectorAll('.show'); // Variável para guardar todos as classes show.

    Array.prototype.forEach.call(_show, function(sh){//Usar forEach do array, usando os _show obtido.
      sh.classList.remove('show')//Remover a classe show de todos os itens em _show
    });

    _this.itens[0].classList.add('show'); //Coloca no primeiro item ontido da instancia a classe show.
    _this.btnNext.removeAttribute('style');//Remove o display none do botão next
    _this.btnPrev.removeAttribute('style');//Remove o display none do botão prev

    addListeners();//Aciona o metodo para adicionar os listeners
  }

  function addListeners(){
    _this.btnNext.addEventListener('click', showNextSlide); //Adicionar evento de click no botão next
    _this.btnPrev.addEventListener('click', showPrevSlide); //Adicionar evento de click no botão prev
  }

  function showNextSlide(){
    _currentSlide++; //Adiciona um na contagem
    showSlide();//Chama o método pra mudar o slide
  }

  function showPrevSlide(){
    _currentSlide--; //Subtrai um na contagem
    showSlide();//Chama o método pra mudar o slide
  }

  function showSlide(){
    var qtd = _this.itens.length; //Vê quantos itens foram obtidos
    var slide = Math.abs(_currentSlide % qtd); //Calcula o absoluto do quantidade pela total calculado

    _this.container.querySelector('.show').classList.remove('show');//Remove a classe show das classes que tem esse nome
    _this.itens[slide].classList.add('show') //O iten da contagem absoluta recebe a classe show
  }
}
