<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(25, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "vercat" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categorias</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
              <li class="breadcrumb-item active">Categorias</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="content">

                            <div class="container-fluid">

                                <!--============================================================================================================================================
                                    CONTENIDO PARA MODULOS 
                                    =============================================================================================================================================-->

                                <div class="row">

                                    <!--LISTADO DE MODULOS -->
                                    <div class="col-md-9">

                                        <div class="card card-gray shadow">

                                            <div class="card-header">
                                                <input type="hidden" id="Getruta" value="<?php echo $ruta[0] ?>" />

                                                <h3 class="card-title"><i class="fas fa-list"></i> Listado de Categoria</h3>

                                            </div>

                                            <div class="card-body">
                                                <!--<div class="table-responsive">-->
                                                <table class="table display nowrap table-striped shadow rounded tablaCategoria" style="width:100%">

                                                    <thead class="bg-gray text-left">
                                                      <th>Codigo</th>
                                                      <th>Descripcion</th>
                                                      <th>Estado</th>
                                                      <th>Editar</th>
                                                      <th>Eliminar</th>
                                                    </thead>
                                                    <tbody class="">

                                                    </tbody>

                                                </table>
                                                <!--</div>-->
                                            </div>

                                        </div>

                                    </div>
                                    <!--/. col-md-6 -->

                                    <!--FORMULARIO PARA REGISTRO Y EDICION -->
                                    <div class="col-md-3">
                                        <div class="card card-gray shadow">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-edit"></i> Registro de Categoria</h3>
                                            </div>

                                            <div class="card-body">
                                                <form method="post" class="needs-validation" novalidate id="formularioCategoria">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="form-group mb-2">

                                                                <label for="iptModulo" class="m-0 p-0 col-sm-12 col-form-label-sm"><span class="small">Descripción</span><span class="text-danger">*</span></label>

                                                                <div class="input-group  m-0">
                                                                  <input type="hidden" id="idCategoria" name="idCategoria">
                                                                    <input type="text" class="form-control form-control-sm" name="desCat" id="desCat" required>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text bg-gray"><i class="fas fa-laptop text-white fs-6"></i></span>
                                                                    </div>
                                                                    <div class="invalid-feedback">Debe ingresar descripción</div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-12">

                                                            <div class="form-group m-0 mt-2">

                                                                <button type="button" class="btn btn-success w-100 guardarCategoria">Guardar Tipo Pago</button>
                                                                <!--<button type="button" style="display:none" class="btn btn-success w-100 btnEditarTipoPago">Editar Tipo Pago</button>-->

                                                            </div>

                                                        </div>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </div>
                                    <!--/. col-md-3 -->


                                </div>
                                <!--/.row -->

                            </div>

                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php else : ?>
  <?php require_once "views/modules/404.php"; ?>
<?php endif ?>


<script src="<?php echo $url ?>views/js/categoria.js"></script>