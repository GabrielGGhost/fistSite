<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Editar Receita
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Usuário</h3>
        </div>
        <!-- /.box-header -->
        <?php if( $createError != '' ){ ?>
          <div class="alert alert-danger">
            <?php echo htmlspecialchars( $createError, ENT_COMPAT, 'UTF-8', FALSE ); ?>
          </div>
        <?php } ?>
        <?php if( $createSuccess != '' ){ ?>
          <div class="alert alert-success">
            <?php echo htmlspecialchars( $createSuccess, ENT_COMPAT, 'UTF-8', FALSE ); ?>
          </div>
        <?php } ?>
        <!-- form start -->
        <div class="box-body">
          <form role="form" action="/admin/recipes/<?php echo htmlspecialchars( $recipe["idRecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/images" method="post" enctype="multipart/form-data">
            <input type="file" class="form-control" id="file" name="file" style="width: 300px;">
            <img src="/res/site/img/defaults/addPhoto.jpg" alt="Imagem da receita" class="recipe-cards__image recipePic" id="image-preview" style="max-width: 300px; border: 1px solid black; border-radius: 15px;">
            <div class="box-footer">
              <button type="submit" class="btn btn-success">Adicionar</button>
            </div>
          </form>
        </div>
        <div class="box-body">
          <div class="box-header with-border">
          </div>
          <h3 class="box-title">Salvas</h3>
          <section class="recipe-cards">
            <?php $counter1=-1;  if( isset($imagePathes) && ( is_array($imagePathes) || $imagePathes instanceof Traversable ) && sizeof($imagePathes) ) foreach( $imagePathes as $key1 => $value1 ){ $counter1++; ?>
              <form role="form" action="/admin/recipes/<?php echo htmlspecialchars( $recipe["idRecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/removeImage/<?php echo htmlspecialchars( $value1["pathId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                <div class="recipeImage">
                  <img src="/res/site/img/recipe_pictures/<?php echo htmlspecialchars( $value1["pathId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg" alt="Foto da receita" class="recipe-cards__image recipeImageCard">
                  <div class="remove-box">
                    <button onclick="return confirm('Deseja realmente remover esta imagem?')" class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i> Remover</button>
                  </div>
                </div>
              </form>
            <?php } ?>
          </section>
        </div>
      </div>
  	</div>
  </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
document.querySelector('#file').addEventListener('change', function(){
  
  var file = new FileReader();

  file.onload = function() {
    
    document.querySelector('#image-preview').src = file.result;

  }

  file.readAsDataURL(this.files[0]);

});
</script>