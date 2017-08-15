
	<div class="container">
	<div class="row">
		<div class="col-sm-12">			
			<h1 class="titulo-seccion">
				<i class="fa fa-users" aria-hidden="true"></i> Datos de usuario
			</h1>
		</div>
	</div><!-- /row -->
	<div class="row">
		<div class="col-sm-12">			
		<div class="panel panel-default sombreado">
		  <div class="panel-heading"><?php echo $titulo ?></div>
		  <div class="panel-body">

		  <div class="row">
		  	<div class="col-sm-5 col-sm-offset-3">
		  		<!-- 'error' mensaje -->
		    	<?php if(isset($error)) { ?> 
					<div class="alert alert-danger" role="alert">
			    		<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
			    		<?php  echo $error; ?>
			    	</div>
		    	<?php } ?>
		  	</div><!-- /col -->

			
	  		<?php if($this->session->flashdata('error2')) { ?> 
	  		<div class="col-sm-6 col-sm-offset-3">
				<div class="alert alert-danger" role="alert">
					<p>
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<b>Atención:</b>
					</p>
		    		<?php  echo $this->session->flashdata('error2'); ?>
		    	</div>
		    </div>
	    	<?php } ?>	


		  </div><!-- /row -->
		    
		    <div class="row">
		    	<form action="<?php echo site_url() . '/' . $action ;?>" method="POST">
				<input type="hidden" name="dniActual" id="dniActual" value="<?php if (isset($usuario)) {echo $usuario->dni;}?>">
		    	<div class="col-sm-4">
		    	<div class="form-group">
				    <label for="nombre">Nombre</label>
				    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre" value="<?php  if (isset($usuario)) {echo $usuario->nombre;}?>">
				</div>
		    	</div>
		    	<div class="col-sm-4">
		    		<div class="form-group">
				    <label for="apellido">Apellido</label>
				    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="apellido" value="<?php  if (isset($usuario)) {echo $usuario->apellido;}?>">
				</div>
		    	</div>
		    	<div class="col-sm-4">
		    		<div class="form-group">
				    <label for="mail">Correo electrónico</label>
				    <input type="text" class="form-control" id="mail" name="mail" placeholder="e-mail" value="<?php  if (isset($usuario)) {echo $usuario->mail;}?>">
				</div>
		    	</div>		    	
		    	</div><!-- /row -->

		    	<hr>

		    	<div class="row">
	    		<div class="col-sm-3">
	    		<div class="form-group">
				    <label for="dni">dni</label>
				    <input type="text" class="form-control" id="dni" name="dni" placeholder="dni" value="<?php  if (isset($usuario)) {echo $usuario->dni;}?>">
				    <p class="help-block">Número de dni.</p>
				</div>
		    	</div><!-- /col -->
		    	<div class="col-sm-3">
		    		<div class="form-group">
				    <label for="idRol">Rol</label>
				    <select class="form-control" id="idRol" name="idRol">
						<?php foreach($roles as $rol){ ?>
							<option <?php if (isset($usuario)){if($usuario->idRol == $rol->id) { echo "selected='selected'";}}?> value="<?php echo $rol->id;?>"><?php echo $rol->nombre;?></option>
						<?php } ?>
					</select>
				</div>
		    	</div><!-- /col -->
				<?php if(!isset($usuario)){?>
		    	<div class="col-sm-3">
		    		<div class="form-group">
				    <label for="password">Contraseña</label>
				    <input type="password" class="form-control" id="password" name="password" placeholder="contraseña alfanumérica">
				    <p class="help-block">Al menos 5 letras, 2 digitos y 1 caracter especial.</p>
				</div>
		    	</div><!-- /col -->
		    	<div class="col-sm-3">
		    		<div class="form-group">
				    <label for="password2">Repetir contraseña</label>
				    <input type="password" class="form-control" id="password2" name="password2">
				</div>
		    	</div><!-- /col -->			
				<?php }?>   	
		    	</div><!-- /row -->
		    	<div class="row">
		    		<div class="col-sm-12">
		    			<button class="btn btn-success btn-sm" type="submit"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span><?php echo $boton?></button>
		    		</div>
		    	</div><!-- /row -->
		    	
				<?php if (isset($usuario)) {?>
				<hr>
		    	<div class="row">
		    		<div class="col-sm-6">
		    			<b>Fecha de registro:</b> <?php echo $usuario->fechaAlta;?>
		    		</div>
		    		<div class="col-sm-6">
		    			<b>Fecha de último acceso:</b> 
						<?php 
							if ($usuario->ultimoAcceso == NULL){
								echo "Nunca";
							} else {
								echo $usuario->ultimoAcceso;
							} ?>
		    		</div>
				</div>
				<?php } ?>
		    	</form>
				
		    </div><!-- /row -->
		  </div><!-- /p-body-->
		</div><!-- /panel-->
			
		</div><!-- /col -->
	</div><!-- /row -->
	</div><!-- /container -->



<!-- scripts -->