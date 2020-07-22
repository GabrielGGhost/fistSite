<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/categories">Categorias</a></li>
    <li class="active"><a href="/admin/categories/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Ingrediente</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/ingredients/create" method="post">
          <?php if( $createError != '' ){ ?>

            <div class="alert alert-danger">
              <?php echo htmlspecialchars( $createError, ENT_COMPAT, 'UTF-8', FALSE ); ?>

            </div>
          <?php } ?>

          <div class="box-body">
            <div class="form-group">
              <div class="form-double">
                <label for="singularName">Ingrediente singular</label>
                <input type="text" class="form-control" id="name" name="singularName" placeholder="Digite o nome do produto no singular" maxlength="50">
              </div>
              <div class="form-double">
                <label for="pluralName">Ingrediente plural</label>
                <input type="text" class="form-control" id="name" name="pluralName" placeholder="Digite o nome do produto no plural" maxlength="50">
              </div>
            </div>
            <div class="form-group">
              <label for="description">Descrição</label>
              <textarea placeholder="Escreva algo sobre este ingrediente" class="form-control" id="description" name="description" maxlength="264"></textarea>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->