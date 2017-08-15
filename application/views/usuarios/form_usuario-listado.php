
	<div class="container">
	<div class="row">
		<div class="col-sm-12">			
			<h1 class="titulo-seccion">
				<i class="fa fa-users" aria-hidden="true"></i> Usuarios del sistema
			</h1>
		</div>
	</div><!-- /row -->
	<div class="row">
		<div class="col-sm-12">			
		<div class="panel panel-default sombreado">
		  <div class="panel-heading"><i class="fa fa-list" aria-hidden="true"></i> Listado de usuarios en el sistema</div>
		  <div class="panel-body">
		    
		    <div class="row">	    	
		    	
		    	<div class="col-sm-12 col-md-10 col-md-offset-1">
				
				<a href="<?php echo site_url() . "/panel/addSysUser"?>"><button class="btn btn-success btn-sm" type="submit"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo usuario</button></a>
		    	<hr>
				
				<?php if(isset($success)) {echo $success;} ?>
				
				<div class="table-responsive">
		    	<table class="table table-condensed table-bordered">
				  <thead>
				  	<tr>
				  		<th>
				  			Nombre y apellido	  			
				  		</th>
				  		<th>
				  			Usuario
				  		</th>
				  		<th>
				  			Rol
				  		</th>
				  		<th>
				  			F. de registro
				  		</th>
				  		<th style="width: 92px; text-align: center;">
				  			Acciones
				  		</th>
				  	</tr>
				  </thead>
				  <tbody>
					<!-- registro -->
					<?php foreach ($usuarios as $usuario){ ?>
							<tr>
								<td class="nUsuario"><?php echo $usuario->nombre.' '.$usuario->apellido ?></td>
								<td><?php echo $usuario->dni ?></td>
								<td><?php echo $usuario->rol ?></td>
								<td><?php echo $usuario->fechaAlta ?></td>
								<td class="text-center">
									
									<a href="<?php echo site_url(); ?>/panel/editSysUser?dni=<?php echo $usuario->dni?>" class="btn btn-success btn-xs"  data-toggle="tooltip" data-placement="left" title="Editar información de usuario."><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> 

									<a href="#cambioClave" class="btn btn-success btn-xs changePassword" data-toggle="modal" data-id="<?php echo $usuario->dni?>" ><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a> 

									<a href="#eliminarUsuario" class="btn btn-default btn-xs removeUsuario" data-toggle="modal"  data-idusuario="<?php echo $usuario->dni?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a> 
								</td>					
							</tr>
					<?php } ?>
				  </tbody>
				</table>
				</div><!-- /table-responsive -->		    	
		    	</div><!-- /col -->
		    	</div><!-- /row -->

		   
		  </div><!-- /p-body-->
		</div><!-- /panel-->
			
		</div><!-- /col -->
	</div><!-- /row -->
	</div><!-- /container -->


<!-- Modal: reseteo de password -->
<div class="modal fade" id="cambioClave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        <h4 class="modal-title modal-titulo" id="myModalLabel"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Cambio de clave</h4>

      </div>
      
      <div class="modal-body">
      
      <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
	  <p>Ingrese a continuación la nueva clave.</p>
	  <form method="post" id="cambiarPassword" name="cambiarPassword" action="">
	  <input type="hidden" name="dni" id="dni" value="">
      <div class="form-group">
	    <label for="nuevaClave">Nueva clave</label>
	    <input type="password" class="form-control" name="password" />
	  </div>
	  <div class="form-group">
	    <label for="repetClave">Repetir clave</label>
	    <input type="password" class="form-control" name="password2"/>
	  </div>
	  <button id="guardarPassword" class="btn btn-success btn-sm"><span class=" glyphicon glyphicon-repeat" aria-hidden="true"></span> Cambiar clave</button>
	  <hr>
	  <div id="chngPassRes"></div>
	  </form>
	  </div><!-- /col -->
      </div><!-- /row -->
      </div><!-- /modal-body -->     
    </div>
  </div>
</div><!-- /modal -->




<!-- Modal: eliminar usuario -->
<div class="modal fade" id="eliminarUsuario" tabindex="-1" role="dialog" aria-labelledby="eliminarUsuario">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title modal-titulo" id="myModalLabel"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar usuario</h4>
      </div>
	      <form id="removeUsuarioForm" action="<?php echo site_url() . '/panel/removeSysUser'?>" method="post" enctype="multipart/form-data">
		      <div class="modal-body">
			      <div class="row">      	
				    <div class="col-sm-8 col-sm-offset-2">
					  	<div class="alert alert-info" role="alert">
					  		<p class="text-center"><b>Usuario a eliminar:</b><br><span id="usuario-nombre"></span></p>	
					  	</div>    
					  	<p>
				      		Confirme la eliminación del usuario ingresando su clave a continuación.
					  	</p>
						<div class="form-group">
						    <label for="password">Su clave:</label>
						    <input type="password" class="form-control" id="password" name="password">			
					    </div>
					    <div class="form-group">
							<div id="respuesta" class="alert" role="alert">
						</div>   
					</div>
				    </div><!-- /col -->
			    </div><!-- /row -->

		      </div><!-- /modal-body -->
		      <div class="modal-footer">
		      	<input id="hUsuario" type="hidden" name="idUsuario" value="">
		        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
		        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
		      </div>
	 	 </form>
    </div>
  </div>
</div>