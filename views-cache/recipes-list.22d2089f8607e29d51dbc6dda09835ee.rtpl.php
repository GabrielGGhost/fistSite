<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container-ingredients">
 	<section >
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
      <div class="recipe-card recipe-card_<?php echo htmlspecialchars( $value1["idRecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"  id="recipe-card">
        <form role="form" action="/recipe-detail/<?php echo htmlspecialchars( $value1["idRecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="get">
          <div id="keepItTogether">
            <div class="recipe-thumb">
              <img <?php if( $value1["pathId"] != '' ){ ?> src="/res/site/img/recipe_thumbs/<?php echo htmlspecialchars( $value1["pathId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg" <?php }else{ ?> src="/res/site/img/defaults/no-recipe_image.jpg" <?php } ?> alt="Foto de receitas" class="border-recipe">
            </div>
            <div class="recipeTitle">
              <a class="recipePrincipalText"><?php echo htmlspecialchars( $value1["recipeName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
            </div>
            <div class="recipeDescription">
              <div class="firstRow">
                <div class="preparationTime">
                  <a><a class="recipePrincipalText"><i class="fas fa-stopwatch"></i> Tempo:</a><br> <?php echo htmlspecialchars( $value1["preparationTime"], ENT_COMPAT, 'UTF-8', FALSE ); ?>h</a>
                </div>
                <div class="recipeYield">
                  <a><a class="recipePrincipalText"><i class="fas fa-cookie-bite"></i> Rende:</a><br><?php echo htmlspecialchars( $value1["amount"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php if( $value1["amount"] > 1 ){ ?> <?php echo htmlspecialchars( $value1["pluralName"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php }else{ ?> <?php echo htmlspecialchars( $value1["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php } ?></a>
                </div>
              </div>
              <div class="secondRow">
                <div class="recipeDifficult">
                  <a><a class="recipePrincipalText"><i class="fas fa-layer-group"></i> Nível:</a><br> <?php echo htmlspecialchars( $value1["difficultLevel"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                </div>
                <div class="recipeAuthor">
                  <a><a class="recipePrincipalText"><i class="fas fa-user"></i> Autor:</a><br><?php echo htmlspecialchars( $value1["login"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                </div>
              </div>
            </div>
            <input type="submit" name="openButton_<?php echo htmlspecialchars( $value1["idRecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="openButton_<?php echo htmlspecialchars( $value1["idRecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="display:none">
          </div>
        </form>
      </div>
      <?php } ?>
    </div>
    </section>
</div>