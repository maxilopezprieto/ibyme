
<div class="container">
	<div class="row">

		<!-- columna 1 -->
		<div class="col-sm-8">
		<div class="row">
		<div class="col-xs-6 col-sm-4">
			<div class="box-seccion">
				<div class="titulo text-center">
					Item A
				</div>
				<div class="icono"  data-toggle="tooltip" data-placement="top" title="Ver listado de Alumnos.">
					<a href="<?php echo site_url(); ?>/panel/adminAlumnos">
					<img src="<?php echo base_url(); ?>img/ico-estudiante.svg" alt="">
					</a>
				</div>
				<div class="tools">
					<a href="<?php echo site_url(); ?>/panel/addAlumno" class="btn btn-default btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> nuevo item A</a>
				</div>
			</div><!-- /box-seccion -->
		</div><!-- /col -->
		<div class="col-xs-6 col-sm-4">
			<div class="box-seccion">
				<div class="titulo text-center">
					Item B
				</div>
				<div class="icono"  data-toggle="tooltip" data-placement="top" title="Ver listado de Docentes.">
				<a href="<?php echo site_url(); ?>/panel/adminDocentes">
					<img src="<?php echo base_url(); ?>img/ico-blackboard.svg" alt="">
				</a>
				</div>		
				<div class="tools">
					<a href="<?php echo site_url(); ?>/panel/addDocente" class="btn btn-default btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> nuevo item B</a>
				</div>		
			</div><!-- /box-seccion -->
		</div><!-- /col -->
		<div class="col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-0">
			<div class="box-seccion">
				<div class="titulo text-center">
					Item C
				</div>
				<div class="icono"  data-toggle="tooltip" data-placement="top" title="Ver listado de Escuelas.">
				<a href="<?php echo site_url(); ?>/panel/adminEscuelas">
					<img src="<?php echo base_url(); ?>img/ico-school.svg" alt="">
				</a>
				</div>
				<div class="tools">
					<a href="<?php echo site_url(); ?>/panel/addEscuela" class="btn btn-default btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> nueva item C</a>
				</div>
			</div><!-- /box-seccion -->
		</div><!-- /col -->
			
		</div><!-- /row -->
		
		<!-- estadisticas -->
		<div class="row" style="margin-top: 15px;">  
			<div class="col-sm-12">
				<div class="box-secciones">
				<div class="row">
					<div class="col-sm-6">
						<h2 class="titulo"><i class="fa fa-bar-chart" aria-hidden="true"></i> Otros Datos</h2>
					</div><!-- /col -->
					<div class="col-sm-6 text-right"><i class="fa fa-angle-right" aria-hidden="true"></i>
					<a href="#" class="azul">más datos</a>
					</div>
				</div><!-- /row -->
					
				
					<div class="row" style="margin-top: 20px;">
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="box-stat">
								<div class="txt">
									Dato 1
								</div>
								<div class="val">
									<?php echo "" ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="box-stat">
								<div class="txt">
									Dato 2
								</div>
								<div class="val">
									<?php echo "" ?>
								</div>
							</div>
						</div><!-- /col -->
						<div class="col-xs-12 col-sm-4 col-md-3">
							<div class="box-stat">
								<div class="txt">
									Dato 3
								</div>
								<div class="val">
									<?php echo "" ?>
								</div>
							</div>
						</div><!-- /col -->
						<div class="col-xs-12 hidden-sm col-md-3 ">
							<div class="box-stat">
								<div class="txt">
									Dato 4
								</div>
								<div class="val">
									<?php echo "" ?>
								</div>
							</div>
						</div><!-- /col -->
					</div><!-- /row -->
				</div><!-- /box-secciones -->
			</div><!-- /col -->
		</div><!--/row -->
			
		</div><!-- /col -->

		<!-- columna 2 -->
		<div class="col-sm-4">


			<div class="box-seccion seccion-perfil hidden-xs">
				<div class="titulo">
					<i class="fa fa-user-o" aria-hidden="true"></i> Perfil de <?php echo ($this->session->userdata('nombre')) ? $this->session->userdata('nombre') : 'usuario';?>
				</div>			
				<div class="info">
					<b>DNI/Usuario:</b> <?php echo $this->session->userdata('dni'); ?><br>
					<b>Rol:</b> 
					<span class="rol">
					<?php echo $this->session->userdata('nombreRol'); ?>
					</span>
				</div>
				<div class="acciones">
					<i class="fa fa-angle-right azul" aria-hidden="true"></i>
 <a href="<?php echo site_url(); ?>/panel/panelUsuario">Editar perfil/clave</a><br/>
					<i class="fa fa-angle-right azul" aria-hidden="true"></i>
 <a href="<?php echo site_url(); ?>/panel/adminSysUser">Gestionar usuarios</a><br/>
					<i class="fa fa-angle-right azul" aria-hidden="true"></i>
 <a href="#">Ver logs de acceso</a>
				</div>		
			</div><!-- /box-seccion -->

		<!-- evento -->
		<div class="row" style="margin-top: 30px;">  
			<div class="col-sm-12">
				<div class="box-secciones">
				<div class="row">
					<div class="col-sm-12">
						<h2 class="titulo"><i class="fa fa-bar-chart" aria-hidden="true"></i> Otros Datos</h2>
					</div><!-- /col -->					
				</div><!-- /row -->					

				<div class="row" style="margin-top: 20px;">
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="box-graph">								
							<div class="txt">
								Dato A
							</div>
							<div class="pie">
								<!--<canvas id="asistAlumno" width="100" height="100"></canvas>-->
							</div><!-- /pie -->
							<div class="val">
								Info A
							</div>
						</div>
					</div>
					<div class="hidden-xs hidden-sm col-md-6">
						<div class="box-graph">								
							<div class="txt">
								Dato B
							</div>
							<div class="pie">
								<!--<canvas id="asistDocente"></canvas>-->
							</div>
							<div class="val">
								Info B
							</div>
						</div>
					</div><!-- /col -->
					
					
				</div><!-- /row -->
				</div><!-- /box-secciones -->
			</div><!-- /col -->
		</div><!--/row -->

		</div><!-- /col -->

	</div><!-- /row -->
</div><!-- /container -->