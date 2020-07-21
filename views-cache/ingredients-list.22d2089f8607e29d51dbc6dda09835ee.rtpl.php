<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="ingredients_thumbs">
	<?php $counter1=-1;  if( isset($ingredients) && ( is_array($ingredients) || $ingredients instanceof Traversable ) && sizeof($ingredients) ) foreach( $ingredients as $key1 => $value1 ){ $counter1++; ?>
	<div class="ingredient-box"> <h4><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h4>
		<img <?php if( $value1["pictureId"] != '' ){ ?> src="/res/site/img/igrendients_pictures/<?php echo htmlspecialchars( $value1["pictureId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg" <?php }else{ ?> src="/res/site/img/defaults/no-ingredient.jpg" <?php } ?>>
		<p><?php echo htmlspecialchars( $value1["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
	</div>
    <?php } ?>          
</div>