<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="author" content="Maximiliano López Prieto" />
	<meta name="description" content="Sistema" />
	<meta name="Copyright" content="Maximiliano López Prieto" />

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="<?php echo base_url() . "bower_components/bootstrap/dist/css/bootstrap.min.css"; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . "bower_components/bootstrap/dist/css/bootstrap-theme.min.css"; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . "bower_components/font-awesome/css/font-awesome.min.css"; ?>">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

	<link href="<?php echo base_url(); ?>bower_components/animate.css/animate.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="<?php echo base_url() . "css/estilos.css"; ?>">
	<title>Sistema Base v1.0 / 2017 | Login</title>
</head>

<body id="login">

<div class="wrapper">
	<div class="cell">
		
	<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div data-wow-duration="2s" class="logo-base wow fadeInDown">		
			</div>
		</div>
	</div><!-- /row -->
	
	  <div class="row">
	    <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 ">
	    	
	    	<div class="panel panel-default sombreado wow fadeIn">
				  	<div class="panel-heading">
				    	<h3 class="panel-title">Ingreso al sistema Base v1.0 / 2017</h3>
				 	</div>
				  	<div class="panel-body">

				  	<div class="row">
				  		<div class="col-sm-12">
					  		<?php if($error){ ?>
								<div class="alert alert-danger" role="alert">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> 

								<?php echo $error; ?></div>
							<?php } ?>	
				  		</div>
				  	</div><!-- /row -->
					
					<form method="post" accept-charset="UTF-8" role="form" action="<?php echo site_url() . "/panel/doLogin"; ?>">
				  	<div class="row">
				  		<div class="col-sm-6">	
				  			<div class="form-group">
				    		    <input class="form-control" placeholder="Número de DNI" name="dni" id="dni" type="text">
			    			</div>
				  		</div><!--/col-->	
				  		<div class="col-sm-6">
				  			<div class="form-group">
				    			<input class="form-control" placeholder="Contraseña" name="password" id="password" type="password" value="">
				    		</div>
				  		</div><!-- /col -->
					</div><!-- /row -->  

					<?php if($this->session->flashdata('resetMsg')) { ?> 
						<div class="row">
							<div class="col-sm-12">
							<div class="alert <?php echo $this->session->flashdata('clase'); ?>" role="alert">
								<?php  echo $this->session->flashdata('resetMsg'); ?>
							</div>
						</div>
						</div><!-- /row -->
					<?php } ?> 
				    <!--		    		
					<p>
						<i class="fa fa-question-circle-o" aria-hidden="true" style="color: #337ab7;"></i> <a data-toggle="modal" data-target="#myModal" href="#">Recuperar contraseña</a>
					</p>-->
					<input class="btn btn-lg btn-primary btn-block" type="submit" value="Ingresar">
				  		
					</form>	

				    </div><!-- /panel-body -->
			</div><!-- /panel -->

	    </div><!-- /col -->
	  </div><!-- /row -->
	</div><!-- /container -->

	</div><!-- /cell -->
</div><!-- /wrapper -->



<!-- ventana de recupero de password -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Recuperación de clave</h4>
      </div>
      <div class="modal-body">
        
        <div class="row">
        <div class="col-sm-12">
        <form method="post" action="<?php echo site_url() . '/panel/resetPassword'?>" id="recoverPasswordForm">
        <div class="form-group">
			<label for="email">Direccion de e-mail</label>
			<p>Ingrese la dirección de email con la que está registrado.</p>
			<input type="email" class="form-control input-sm" name="mail" placeholder="E-mail registrado">
		</div>
		<div class="form-group">
			<div id="respuesta" class="alert" role="alert"></div>   
		</div>
		<button type="submit" class="btn btn-primary btn-sm">Reestablecer clave</button>

		<!-- mensaje de respuesta 
		<div class="alert alert-success" role="alert"> La información para reestablecer su clave, se envió al correo. Verifique su email.</div>	-->
		</div><!-- /col-->
		</div><!-- /row -->

      </div><!-- /modal-body -->      
    </div>
  </div>
</div>


<!-- scripts -->
<script src="<?php echo base_url() . "bower_components/jquery/dist/jquery.min.js";?>"></script>
<script src="<?php echo base_url() . "bower_components/bootstrap/dist/js/bootstrap.min.js";?>"></script>
<script src="<?php echo base_url() . "bower_components/select2/dist/js/select2.min.js";?>"></script>
<script src="<?php echo base_url() . "bower_components/wow/dist/wow.min.js";?>"></script>
<script src="<?php echo base_url() . "js/functions.js";?>"></script>

</body>
</html>