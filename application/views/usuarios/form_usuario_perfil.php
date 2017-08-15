<div class="container">
	<div class="row">
		<div class="col-sm-12">			
			<h1 class="titulo-seccion">
				<i class="fa fa-user-o" aria-hidden="true"></i> Perfil de usuario
			</h1>
		</div>
	</div><!-- /row -->
	<div class="row">
		<div class="col-sm-12">			
		<div class="panel panel-default sombreado">
		  <div class="panel-heading">Datos de usuario</div>
		  <div class="panel-body">

			<div class="row">
			    <div class="col-sm-12 text-center">
			    <span class="usuar-legajo">
			    	DNI: <?php echo $usuario->dni?>
			    </span>
			    </div>
			</div><!-- /row -->

			<?php if($this->session->flashdata('error2')) { ?> 
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
				<div class="alert alert-danger" role="alert">
					<p>
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<b>Atención:</b>
					</p>
					<?php  echo $this->session->flashdata('error2'); ?>
				</div>
			</div>
			</div><!-- /row -->
			<?php } ?>

			<div class="row">
			    <div class="col-sm-8 col-sm-offset-2">

			    <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#datosUsuario" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user-o" aria-hidden="true"></i> Datos de usuario</a></li>
				    <li role="presentation"><a href="#clave" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Cambio de clave</a></li>
				  </ul>

  
					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="datosUsuario">
					    	<form id="editarUsuario" action="doEditPanelUsuario" method="post">
							<input type="hidden" name="formId" value="0">
					    	<div class="row" style="margin-top: 20px;">
					    		<div class="col-sm-12">
					    			<p>Modifique los datos que desea actualizar.</p>
					    		</div>
								<input type="hidden" name="dni" value="<?php echo $usuario->dni?>">
					    		<div class="col-sm-6">
					    		<div class="form-group">
								    <label for="nombre">Nombre</label>
								    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario->nombre ?>">
								</div>
								</div><!-- /col -->
					    		<div class="col-sm-6">
								<div class="form-group">
								    <label for="apellido">Apellido</label>
								    <input type="text" class="form-control" id="apellido"  name="apellido" value="<?php echo $usuario->apellido ?>">
								</div>
					    		</div><!-- /col -->
					    	</div><!-- /row -->
					    	<div class="row">
					    		<div class="col-sm-6">
					    		<div class="form-group">
								    <label for="nombre">Correo electrónico</label>
								    <input type="text" class="form-control" id="mail"  name="mail" value="<?php echo $usuario->mail ?>">
								</div>
								</div><!-- /col -->
					    	</div><!-- /row -->
					    	<div class="row">
					    		<div class="col-sm-12">
					    			<button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Modificar datos</button>
					    			<a href="<?php echo site_url() . "/panel";?>" class="btn btn-default btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
					    		</div><!-- /col-->
					    	</div><!-- /row -->
							</form>
					    </div><!-- /tab -->


					    <div role="tabpanel" class="tab-pane" id="clave">
							<form action="doEditPanelUsuario" method="post">
								<input type="hidden" name="formId" value="1">
								<input type="hidden" name="dni" value="<?php echo $usuario->dni?>">
								<div class="row" style="margin-top: 20px;">
								<div class="col-sm-8 col-sm-offset-2">
								<p>Ingrese la clave que desea actualizar.</p>
								<div class="form-group">
									<label for="clave">Nueva clave</label>
									<input type="password" class="form-control" id="password" name="password">
								</div>
								<div class="form-group">
									<label for="repetClave">Repetir clave</label>
									<input type="password" class="form-control" id="password2" name="password2">
								</div>
								<button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Modificar clave</button>
								<a href="<?php echo site_url() . "/panel/";?>" class="btn btn-default btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
								</div><!-- /col -->					    		
								</div><!-- /row -->
							</form>
					    </div><!-- /tab -->  
					  </div><!-- /tab-content -->


			    </div>
			</div><!-- /row -->


		  </div><!-- /p-body-->
		</div><!-- /panel-->
			
		</div><!-- /col -->
	</div><!-- /row -->
	</div><!-- /container -->



<!-- scripts -->
<script src="<?php echo base_url() . "bower_components/jquery/dist/jquery.min.js";?>"></script>
<script src="<?php echo base_url() . "bower_components/bootstrap/dist/js/bootstrap.min.js";?>"></script>
<script src="<?php echo base_url() . "js/functions.js"?>"></script>
<script>$(document).ready(initPage);</script>	

</body>
</html>