<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Cadastrar Novo Rendimento
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/users">Rendimentos</a></li>
    <li class="active"><a href="/admin/users/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Rendimento</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/yields/create" method="post">
        <?php if( $createError != '' ){ ?>
          <div class="alert alert-danger">
            <?php echo htmlspecialchars( $createError, ENT_COMPAT, 'UTF-8', FALSE ); ?>
         </div>
        <?php } ?>
          <div class="box-body">
            <div class="form-group">
              <div class="form-double">
                <label for="singularName">Nome Singular</label>
                <input type="text" class="form-control" id="singularName" name="singularName" placeholder="Digite o nome do rendimento" maxlength="30" value="<?php echo htmlspecialchars( $yieldRegisterValues["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">  
              </div>
              <div class="form-double">
                <label for="pluralName">Nome Plural</label>
                <input type="text" class="form-control" id="pluralName" name="pluralName" placeholder="Digite o nome do rendimento" maxlength="30" value="<?php echo htmlspecialchars( $yieldRegisterValues["pluralName"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"> 
              </div>          
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