<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Medidas
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Medida</h3>
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
        <form role="form" action="/admin/measures/<?php echo htmlspecialchars( $measure["idType"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <div class="form-double">
                <label for="singularName">Nome singular</label>
                <input type="text" class="form-control" id="singularName" name="singularName" placeholder="Digite o nome da medida" value="<?php echo htmlspecialchars( $measure["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="30">           
              </div>
              <div class="form-double">
                <label for="pluralName">Nome plural</label>
                <input type="text" class="form-control" id="pluralName" name="pluralName" placeholder="Digite o nome da medida" value="<?php echo htmlspecialchars( $measure["pluralName"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="30">    
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