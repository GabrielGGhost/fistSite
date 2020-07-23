<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Ingredientes
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="/admin/ingredients">Ingredientes</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-header">
              <a href="/admin/ingredients/create" class="btn btn-success">Cadastrar Ingrediente</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome do ingrediente</th>
                    <th style="width: 500px">Descrição</th>
                    <th style="width: 230px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($ingredients) && ( is_array($ingredients) || $ingredients instanceof Traversable ) && sizeof($ingredients) ) foreach( $ingredients as $key1 => $value1 ){ $counter1++; ?>

                  <tr>
                    <td><?php echo htmlspecialchars( $value1["idIngredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td>
                      <a href="/admin/ingredients/<?php echo htmlspecialchars( $value1["idIngredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Editar</a>
                      <a href="/admin/ingredient-category/linkCategories/<?php echo htmlspecialchars( $value1["idIngredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-secondary btn-xs"><i class="fa fa-edit"></i>Categorias</a>

                      <a href="/admin/ingredients/<?php echo htmlspecialchars( $value1["idIngredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/des_active" onclick="return confirm('Deseja realmente desativar este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i><?php if( $value1["active"] == 1 ){ ?> Desativar<?php }else{ ?>Ativar<?php } ?></a>
                    </td>
                  </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->