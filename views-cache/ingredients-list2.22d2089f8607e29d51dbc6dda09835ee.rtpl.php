<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container-ingredients">
 	<section class="ingredient-cards">
    	<?php $counter1=-1;  if( isset($ingredients) && ( is_array($ingredients) || $ingredients instanceof Traversable ) && sizeof($ingredients) ) foreach( $ingredients as $key1 => $value1 ){ $counter1++; ?>
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
        <?php } ?>
    </section>
</div>