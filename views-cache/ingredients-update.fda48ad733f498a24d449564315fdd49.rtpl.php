<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/ingredients/<?php echo htmlspecialchars( $ingredient["idIngredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post" enctype="multipart/form-data">
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

          <div class="box-body">
            <div class="form-group">
              <div class="form-double">
                <label for="name">Ingrediente</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do ingrediente" maxlength="50" value="<?php echo htmlspecialchars( $ingredient["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
              <div class="form-double">
              <label for="name">Ativo</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do produto" maxlength="50" <?php if( $ingredient["active"] == 1 ){ ?> value="sim" <?php } ?> value="Não" disabled>
              </div>
            </div>
            <br> <br> <br>
            <div class="form-group">
              <label for="description">Descrição</label>
              <textarea placeholder="Escreva algo sobre este ingrediente" class="form-control" id="description" name="description" maxlength="264"><?php echo htmlspecialchars( $ingredient["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
            </div>
            <div class="form-group">
              <div class="form-double">
                <label for="file">Imagem</label>
                <input type="file" class="form-control" id="file" name="file">
              </div>
              <div class="form-double">
                <div class="box box-widget">
                  <div class="box-body">
                    <img class="img-responsive" id="image-preview" src="<?php echo htmlspecialchars( $ingredient["pathPhoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Photo" style="border:2px solid black; border-radius: 10px">
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
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