<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container-ingredients">
 	<section>
    <div class="recipe-filter">
      <div class="recipeName">
        <select id="select_filter" class="select_filter">
          <option>Mais recente</option>
          <option>Mais novas</option>
          <option>Mais avaliadas</option>
        </select>
      </div>
    </div>
    <div class="recipe-list">
      <?php $counter1=-1;  if( isset($recipes) && ( is_array($recipes) || $recipes instanceof Traversable ) && sizeof($recipes) ) foreach( $recipes as $key1 => $value1 ){ $counter1++; ?>
      <div class="recipe-card">
        <div class="recipe-thumb">
          <img src="/res/site/img/recipe_pictures/58_5f3443e131cc6.jpg" id="recipeThumb_card" class="recipeThumb_card">
        </div>
        <div class="recipeTitle">
          <a><b><?php echo htmlspecialchars( $value1["recipeName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></b></a>
        </div>
        <div class="recipeDescription">
          <div class="firstRow">
            <div class="preparationTime">
              <a><strong><i class="fas fa-stopwatch"></i> Preparo:</strong> <?php echo htmlspecialchars( $value1["preparationTime"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
            </div>
            <div class="recipeDifficult">
              <a><strong><i class="fas fa-layer-group"></i> Dificuldade:</strong> <?php echo htmlspecialchars( $value1["difficultLevel"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
            </div>
          </div>
          <div class="secondRow">
            <div class="recipeYield">
              <a><strong><i class="fas fa-cookie-bite"></i> Rende:</strong> 1 prato</a>
            </div>
            <div class="recipeAuthor">
              <label><strong><i class="fas fa-user"></i> Autor:</strong> <?php echo htmlspecialchars( $value1["login"], ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    	<!-- <?php $counter1=-1;  if( isset($ingredients) && ( is_array($ingredients) || $ingredients instanceof Traversable ) && sizeof($ingredients) ) foreach( $ingredients as $key1 => $value1 ){ $counter1++; ?>
        	<article class="ingredient-cards__card">
              <div class="ingredientImage">
                <img <?php if( $value1["pictureId"] != '' ){ ?> src="/res/site/img/igrendients_pictures/<?php echo htmlspecialchars( $value1["pictureId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg" <?php }else{ ?> src="/res/site/img/defaults/no-ingredient.jpg" <?php } ?> alt="Foto de ingrediente" class="ingredient-cards__image ">
              </div>
              	<div class="ingredient-cards__content">
                  <div class="ingredient-title">
                    <h2 class="ingredient-cards__title"><?php echo htmlspecialchars( $value1["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h2>
                  </div>
               		<p class="ingredient-cards__text"><?php echo htmlspecialchars( $value1["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
              	</div>
            </article>
        <?php } ?> -->
    </section>
</div>