<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="ingredients_thumbs">
	<?php $counter1=-1;  if( isset($ingredients) && ( is_array($ingredients) || $ingredients instanceof Traversable ) && sizeof($ingredients) ) foreach( $ingredients as $key1 => $value1 ){ $counter1++; ?>
	<div class="ingredient-box"> <h4><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h4>
		<img src="res/site/img/articles/07.jpg">
		<p><?php echo htmlspecialchars( $value1["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
	</div>
    <?php } ?>          
</div>