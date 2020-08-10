<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Cadastrar Nova Receita
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/recipes">Receitas</a></li>
    <li class="active"><a href="/admin/recipes/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Nova Receita</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        </div>
        <!-- form start -->
        <form role="form" action="/admin/recipes/create" method="post">
        <?php if( $createError != '' ){ ?>
          <div class="alert alert-danger">
            <?php echo htmlspecialchars( $createError, ENT_COMPAT, 'UTF-8', FALSE ); ?>
         </div>
        <?php } ?>
          <div class="box-body">
            <div class="form-group">
              <div class="form-double">
                <label for="recipeName">Nome</label>
                <input type="text" class="form-control" id="recipeName" name="recipeName" placeholder="Digite o nome da receita" maxlength="30" value="<?php echo htmlspecialchars( $recipeRegisterValues["recipeName"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
              <div class="form-double">
                <div class="form-double">
                  <label for="yield">Rendimento</label>
                  <input type="number" class="form-control" id="yield" name="yield" placeholder="Digite o nome da receita" maxlength="10" value="<?php echo htmlspecialchars( $recipeRegisterValues["yield"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-double">
                  <div class="form-double">
                    <label for="idYield">tipo</label>
                    <?php if( empty($listedIngredients) ){ ?>
                      <select class="form-control" id="idYield" name="idYield">
                        <?php $counter1=-1;  if( isset($yieldType) && ( is_array($yieldType) || $yieldType instanceof Traversable ) && sizeof($yieldType) ) foreach( $yieldType as $key1 => $value1 ){ $counter1++; ?>
                          <option value="<?php echo htmlspecialchars( $value1["idType"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                        <?php } ?>
                      </select>
                    <?php }else{ ?>
                      <select class="form-control" id="idYield" name="idYield">
                        <?php $a = $recipeRegisterValues["idYield"]; ?>
                        <?php $counter1=-1;  if( isset($yieldType) && ( is_array($yieldType) || $yieldType instanceof Traversable ) && sizeof($yieldType) ) foreach( $yieldType as $key1 => $value1 ){ $counter1++; ?>
                          <option value="<?php echo htmlspecialchars( $value1["idType"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $value1["idType"] == $a ){ ?>Selected<?php } ?>><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                        <?php } ?>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-double">
                    <label for="preparationTime">T.Preparo</label>
                    <input type="time" class="form-control" id="preparationTime" name="preparationTime" placeholder="Digite o nome da receita" maxlength="30" value="<?php echo htmlspecialchars( $recipeRegisterValues["preparationTime"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-double">
                <label for="idDifficult">Dificuldade</label>
                <select class="form-control" id="idDifficult" name="idDifficult">
                  <?php $counter1=-1;  if( isset($difficult) && ( is_array($difficult) || $difficult instanceof Traversable ) && sizeof($difficult) ) foreach( $difficult as $key1 => $value1 ){ $counter1++; ?>
                    <option value="<?php echo htmlspecialchars( $value1["idDifficult"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["difficultLevel"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-double">
                <div class="form-double">
                  <label for="idAuthor">Id Autor</label>
                  <input type="number" class="form-control" id="idAuthor" name="idAuthor" placeholder="Digite o ID" maxlength="30" value="<?php echo htmlspecialchars( $recipeRegisterValues["idAuthor"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                </div>
                <div class="form-double">
                  <label for="recipeName">Autor</label>
                  <input type="text" class="form-control" id="recipeName" name="recipeName" maxlength="30" disabled>
                </div>
              </div>
            </div>
            <div id="ingredients">
              <?php if( empty($listedIngredients) ){ ?>
                <div id="ingredientLine_1" class="ingredientList">
                  <div class="form-group" id="ingredients1">
                    <div class="form-double">
                      <div class="form-double">
                        <label for="quantity_1">Quantidade</label>
                        <input type="number" class="form-control" id="quantity_1" name="quantity_1" maxlength="30">
                      </div>
                      <div class="form-double">
                        <label for="measure_1">Medida</label>
                        <select class="form-control" id="measure_1" name="measure_1">
                          <option value=""></option>
                          <?php $counter1=-1;  if( isset($measure) && ( is_array($measure) || $measure instanceof Traversable ) && sizeof($measure) ) foreach( $measure as $key1 => $value1 ){ $counter1++; ?>
                            <option value="<?php echo htmlspecialchars( $value1["idType"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-double" style="margin-bottom: 10px">
                      <div class="form-double">
                        <label for="complement_1">Complemento</label>
                        <input type="text" class="form-control" id="complement_1" name="complement_1" maxlength="30">
                      </div>
                      <div class="form-double">
                        <div class="form-double" style="width: 70%">
                          <label for="ingredient_1">Ingrediente</label>
                          <select class="form-control" id="ingredient_1" name="ingredient_1">
                            <?php $counter1=-1;  if( isset($ingredient) && ( is_array($ingredient) || $ingredient instanceof Traversable ) && sizeof($ingredient) ) foreach( $ingredient as $key1 => $value1 ){ $counter1++; ?>
                              <option value="<?php echo htmlspecialchars( $value1["idIngredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                            <?php } ?>
                            }
                          </select>
                        </div>
                        <div class="form-double" style="width: 30%">
                          <label for="plural_1">Plural</label>
                          <select class="form-control" id="plural_1" name="plural_1">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php }else{ ?>
                  <?php $counter1=-1;  if( isset($listedIngredients) && ( is_array($listedIngredients) || $listedIngredients instanceof Traversable ) && sizeof($listedIngredients) ) foreach( $listedIngredients as $key1 => $value1 ){ $counter1++; ?>
                    <div class="form-group" id="ingredients">
                      <div id="ingredientLine_1" class="ingredientList">
                        <div class="form-double">
                          <div class="form-double">
                            <label for="<?php echo htmlspecialchars( $value1["quantityId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Quantidade</label>
                            <input type="number" class="form-control" id="<?php echo htmlspecialchars( $value1["quantityId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="<?php echo htmlspecialchars( $value1["quantityId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="30" value="<?php echo htmlspecialchars( $value1["quantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                          </div>
                          <div class="form-double">
                            <label for="<?php echo htmlspecialchars( $value1["measureId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Medida</label>
                            <select class="form-control" id="<?php echo htmlspecialchars( $value1["measureId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="<?php echo htmlspecialchars( $value1["measureId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                              <option value=""></option>
                              <?php $a = $value1["measure"]; ?>
                              <?php $counter2=-1;  if( isset($measure) && ( is_array($measure) || $measure instanceof Traversable ) && sizeof($measure) ) foreach( $measure as $key2 => $value2 ){ $counter2++; ?>
                                <option value="<?php echo htmlspecialchars( $value2["idType"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $value2["idType"] == $a ){ ?> selected <?php } ?>><?php echo htmlspecialchars( $value2["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-double" style="margin-bottom: 10px">
                          <div class="form-double">
                            <label for="<?php echo htmlspecialchars( $value1["complementId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Complemento</label>
                            <input type="text" class="form-control" id="<?php echo htmlspecialchars( $value1["complementId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="<?php echo htmlspecialchars( $value1["complementId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="30" value="<?php echo htmlspecialchars( $value1["complement"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                          </div>
                          <div class="form-double">
                            <div class="form-double" style="width: 70%">
                              <label for="">Ingrediente</label>
                              <select class="form-control" id="<?php echo htmlspecialchars( $value1["ingredientId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="<?php echo htmlspecialchars( $value1["ingredientId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                <?php $i = $value1["ingredient"]; ?>
                                <?php $counter2=-1;  if( isset($ingredient) && ( is_array($ingredient) || $ingredient instanceof Traversable ) && sizeof($ingredient) ) foreach( $ingredient as $key2 => $value2 ){ $counter2++; ?>
                                  <option value="<?php echo htmlspecialchars( $value2["idIngredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $value2["idIngredient"] == $i ){ ?>Selected<?php } ?>><?php echo htmlspecialchars( $value2["singularName"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                <?php } ?>
                                }
                              </select>
                            </div>
                            <div class="form-double" style="width: 30%">
                              <label for="<?php echo htmlspecialchars( $value1["pluralId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Plural</label>
                              <select class="form-control" id="<?php echo htmlspecialchars( $value1["pluralId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="<?php echo htmlspecialchars( $value1["pluralId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                <option value="0" <?php if( $value1["plural"] == 0 ){ ?> selected <?php } ?>>Não</option>
                                <option value="1" <?php if( $value1["plural"] == 1 ){ ?> selected <?php } ?>>Sim</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
              <?php } ?>
            </div>
            <button type="button" id="addIngredient" class="btn btn-primary">+</button>
            <button type="button" id="removeIngredient" class="btn btn-primary">-</button>
            <div class="form-group">
              <label for="recipeName">Passos</label>
              <div  id="steps">
                <?php if( empty($listedSteps) ){ ?>
                  <div id="step_1" class="stepList">
                    <input type="text" class="form-control stepInput" id="step_1" name="step_1" placeholder="Passo Nº1" maxlength="200">                                  
                  </div>
                <?php }else{ ?>
                  <?php $counter1=-1;  if( isset($listedSteps) && ( is_array($listedSteps) || $listedSteps instanceof Traversable ) && sizeof($listedSteps) ) foreach( $listedSteps as $key1 => $value1 ){ $counter1++; ?>
                    <div id="<?php echo htmlspecialchars( $value1["stepId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="stepList">
                      <input type="text" class="form-control stepInput" id="<?php echo htmlspecialchars( $value1["stepId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="<?php echo htmlspecialchars( $value1["stepId"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Passo Nº1" maxlength="200" value="<?php echo htmlspecialchars( $value1["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
              <button type="button" id="addStep" class="btn btn-primary">+</button>
              <button type="button" id="removeStep" class="btn btn-primary">-</button>
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

<!-- /.content-wrapper