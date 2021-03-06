<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="author" content="Maximiliano López Prieto" />
	<meta name="description" content="Sistema Base 1.0 / 2017" />
	<meta name="Copyright" content="Maximiliano López Prieto" />

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="<?php echo base_url() . "bower_components/bootstrap/dist/css/bootstrap.min.css"; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . "bower_components/bootstrap/dist/css/bootstrap-theme.min.css"; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . "bower_components/font-awesome/css/font-awesome.min.css"; ?>">

	<link href="<?php echo base_url(); ?>bower_components/select2/dist/css/select2.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>bower_components/select2-bootstrap-theme/dist/select2-bootstrap.min.css" rel="stylesheet" />	

	<link href="<?php echo base_url(); ?>bower_components/animate.css/animate.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="<?php echo base_url() . "css/estilos.css"; ?>">	
	<script src="<?php echo base_url() . "bower_components/jquery/dist/jquery.min.js";?>"></script>

	<title>Sistema Base 1.0 / 2017</title>
</head>

<body>
<!-- header -->
<header class="header" id="header">
<div class="container">
	

	<div class="row line1">
		<div class="col-sm-4">
		<div class="base-logo"></div>
		</div>
		<div class="col-sm-5 col-sm-offset-3 text-right">
			<div class="usuario">Bienvenido/a, <b><a href="<?php echo site_url() . '/panel/panelUsuario'?>" data-toggle="tooltip" data-placement="left" title="Acceso a perfil de usuario."><?php echo $this->session->userdata('nombre')." ".$this->session->userdata('apellido'); ?></a></b> <i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
			<div class="logout">
			<a href="<?php echo site_url();?>/panel/logout" class="btn_salir">Salir</a>
			<i class="fa fa-sign-out" aria-hidden="true"></i>
		</div><!-- /logout -->
		</div><!-- /col -->
	</div><!-- /row -->



	<!-- menu row -->
	<div class="row line2">
		<div class="col-sm-12">		
		<!-- menu de secciones -->
		<div class="menu">
		<ul>
			<li>		
				<a href="<?php echo site_url();?>">Panel</a>
			</li>
			<!--
			<li <?php if($idSeccion==0) echo 'class="seleccionado"'; ?>>
				<a href="<?php echo site_url();?>/panel/adminSysUser">Usuarios</a>
			</li>
			-->
			<li <?php if($idSeccion==1) echo 'class="seleccionado"'; ?>>
				<a href="<?php echo site_url();?>/panel/adminEscuelas">Item A</a>
			</li>
			<li <?php if($idSeccion==3) echo 'class="seleccionado"'; ?>>
				<a href="<?php echo site_url();?>/panel/adminDocentes">Item B</a>
			</li>
			<li <?php if($idSeccion==4) echo 'class="seleccionado"'; ?>>
				<a href="<?php echo site_url();?>/panel/adminAlumnos">Item C</a>
			</li>
		</ul>
		</div><!-- /menu -->
		</div><!-- /col -->
	</div><!-- /row -->

	<!-- vlq logo -->
	<div class="base-logo-sm"></div>
	<!-- user tools -->
	<div class="user-tool">
		<a href="<?php echo site_url() . '/panel/panelUsuario'?>"><i class="fa fa-user-circle-o azul" aria-hidden="true"></i></a>

		<a href="<?php echo site_url();?>/panel/logout"><i class="fa fa-sign-out azul" aria-hidden="true"></i></a>
	</div>

</div><!-- /container -->
</header>

<?php //echo $idSeccion ?>