$(function(){
	//Document ready
	Certamen.init();
});

var Certamen = {
	"init" : function(){

		// script header slim
		$(window).scroll(function() {
		    if ($(this).scrollTop() > 50){  
		        $('#header').addClass("slim");
		    } else {
		        $('#header').removeClass("slim");
		    }

			if ($(this).scrollTop() > 100) {
				$('.scrollToTop').fadeIn();
			} else {
				$('.scrollToTop').fadeOut();
			}
		});
	
		//Click event to scroll to top
		$('.scrollToTop').click(function(){
			$('html, body').animate({scrollTop : 0},800);
			return false;
		});
		// tooltip
		$('[data-toggle="tooltip"]').tooltip();
		//inicializamos el plugin de animaciones
		new WOW().init();
		//plugin busqueda campos select
		$('.select-buscar, .select-alumno').select2({
			placeholder: "seleccione",
			theme: "bootstrap"
			
		});

		//funcion que evita que un formulario que no fue editado se envie para guardar
		Certamen.preventFormSaving();
		//carga las acciones asociadas a los alumnos
		Certamen.alumnoActions();
		//carga las acciones asociadas a los docentes
		Certamen.docenteActions();
		//carga las acciones asociadas a los usuarios
		Certamen.usuarioActions();
		//carga las acciones asociadas a las escuelas
		Certamen.escuelaActions();
		// Resetear formulario al cerrar el modal
		$('button.close').on('click', function() {
			Certamen.resetForm('');
		});
		$('.modal').on('hidden.bs.modal', function(){
			if($(this).find('form')){
				Certamen.resetForm('');
			}
		});
	},
	"usuarioActions" : function(){

		$(document).on("click", ".removeUsuario", function (e) {
			e.preventDefault();
			var $this = $(this);
			$('#hUsuario').val($this.data('idusuario'));
			$('#usuario-nombre').text($this.parents('tr').find('.nUsuario').text());
		});

		$(document).on("submit", "#removeUsuarioForm", function (e){
			e.preventDefault();

			var formData = $(this).serialize(),
			urlAction = 'removeSysUser';

			Certamen.doAjaxRequest(urlAction, formData);
		});
		
		$(document).on("click", ".changePassword", function () {
			var myLegajo = $(this).data('id');
			$(".modal-body #dni").val( myLegajo );
		});

		$(document).on("submit", "#recoverPasswordForm", function (e){
			e.preventDefault();

			var formData = $(this).serialize(),
			urlAction = 'resetPassword';

			Certamen.doAjaxRequest(urlAction, formData);
		});	

		//Acá metí la cuchara
		$("#cambiarPassword" ).submit(function(e){

			e.preventDefault();
			//deshabilitamos el boton de envio
			$('#guardarPassword').attr("disabled", true);
		  
		 	var parametros = $(this).serialize();
		 	var respuesta = $('#chngPassRes');

			$.ajax({
				type: "POST",
				url: '/index.php/panel/doCambioPassword',
				data: parametros,
				beforeSend: function(objeto){
					respuesta.html("Mensaje: Cargando...");
				},
				success: function(datos){
					respuesta.html(datos);
					$('#guardarPassword').attr("disabled", false);
			 	},
			 	error: function(){
			 		respuesta.html('<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>Error en el servidor.</div>');
			 	}
			});
		  
		});
	},
	"escuelaActions" : function(){

		$(document).on("click", ".removeEscuela", function (e) {
			e.preventDefault();
			var $idEscuela = $(this).data('idescuela');
			$('#hEscuela').val($idEscuela);
			Certamen.doRemoveEscuelaByAjax($idEscuela);
		});

		$(document).on("click", "#refreshEscuelas", function (e){
			e.preventDefault();
			Certamen.doRemoveEscuelaByAjax($('#hEscuela').val());
		});

		$(document).on("submit", "#removeEscuelaForm", function (e){
			e.preventDefault();

			var formData = $(this).serialize(),
			urlAction = 'removeEscuela';

			Certamen.doAjaxRequest(urlAction, formData);
		});

	},
	"doRemoveEscuelaByAjax" : function (idEsc){

			var $warning = $('#docentes_alumnos'),
				$listaAlumnos = $('#listadoAlumnosAsoc'),
				$listaDocentes = $('#listadoDocentesAsoc');	

			$.ajax({
	            data: { idEscuela: idEsc },
	            url:   '/index.php/panel/dataRemoveEscuela',
	            type:  'GET',
	            dataType: 'json',
	            beforeSend: function (){
	            	$warning.hide();
	            	$listaDocentes.html('');
	            	$listaAlumnos.html('');
	            },
	            success:  function (data){

					$('#nEscuela').text(data.escuela.nombre);
					$('#cueEscuela').text('(CUE: '+data.escuela.cue+')');
					$('#telEscuela').text(data.escuela.telefono);
					$('#mailEscuela').text(data.escuela.mail);	    

					if(data.docentes.length > 0 || data.alumnos.length > 0){
						$warning.fadeIn(300);

						if(data.docentes.length > 0){
							$.each(data.docentes, function(i,v){
								$listaDocentes.append('<li class="list-group-item"><a target="_blank" href="/index.php/panel/editDocente?idDocente='+data.docentes[i].id+'" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> &nbsp;|&nbsp; '+data.docentes[i].nombre + ' ' + data.docentes[i].apellido +'</li>');
							});   
						}
						if(data.alumnos.length > 0){
							$.each(data.alumnos, function(i,v){
								$listaAlumnos.append('<li class="list-group-item"><a target="_blank" href="/index.php/panel/editAlumno?idAlumno='+data.alumnos[i][0].id+'" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> &nbsp;|&nbsp; '+data.alumnos[i][0].nombre + ' ' + data.alumnos[i][0].apellido +'</li>')
							});
						}
					}     	

	            },
	            error: function(){
	            	$listaDocentes.html('');
	            	$listaAlumnos.html('');
	            	$warning.hide();
	            }
	        });
	},
	"alumnoActions" : function (){

		$(document).on("click", ".removeAlumno", function (e) {
			e.preventDefault();
			var $this = $(this);
			$('#idAlumnoModal').val($this.data('idalumno'));
			$('#nombreAlu').text($this.parents('tr').find('.nAlumno').text());
		});

		$(document).on('submit', '#eliminarAlumno form', function(e){
			e.preventDefault();
			//legajo, password, id
			var formData = $(this).serialize(),
			urlAction = 'removeAlumno';

			Certamen.doAjaxRequest(urlAction, formData);
			
		});

	},
	"docenteActions" : function(){
		$(document).on("click", ".removeDocente", function (e) {
			e.preventDefault();
			var $idDocente = $(this).data('iddocente');
			Certamen.doRemoveDocenteByAjax($idDocente);

		});
		$(document).on("click", "#refreshDocente", function(e){
			e.preventDefault();
			Certamen.doRemoveDocenteByAjax($('#hDocente').val());
		});
		$(document).on("submit", "#removeDocenteForm", function (e){
			e.preventDefault();
			var formData = $(this).serialize(),
			urlAction = 'removeDocente';

			Certamen.doAjaxRequest(urlAction, formData);
		});
	},
	"doRemoveDocenteByAjax" : function(idDoc){

		var $lista = $('#lista-alumnos ul');

		$.ajax({
            data: { idDocente : idDoc },
            url:   '/index.php/panel/getDocenteById',
            type:  'GET',
            dataType: 'json',
            beforeSend: function (){
            	$('#lista-alumnos').hide();
            	$lista.html('');
            	$('#hDocente').val('');
            },
            success:  function (data){
				$('#nDocente').text(data.docente.nombre + ' ' + data.docente.apellido);
				$('#dniDocente').text(data.docente.dni); 
				$('#hDocente').val(data.docente.id);

				if (data.alumnos.length > 0){
					$.each(data.alumnos, function(i,v){
						$lista.append('<li class="list-group-item"><a target="_blank" href="/index.php/panel/editAlumno?idAlumno='+data.alumnos[i].id+'" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> &nbsp;|&nbsp; '+data.alumnos[i].nombre+' '+data.alumnos[i].apellido+'</li>')
					});
					$('#lista-alumnos').fadeIn(300);
				}

            },
            error: function(){
                $('#lista-alumnos').hide();
                $lista.html('');
                $('#hDocente').val('');
            }
        });
	},
	"doAjaxRequest" : function (urlAction, formData){

		var $msg = $('#respuesta');

			$.ajax({
	            data: formData,
	            url:   '/index.php/panel/'+urlAction,
	            type:  'POST',
	            dataType: 'json',
	            beforeSend: function (){
	            	$msg.hide();
	            },
	            success:  function (data){           	

	            	if(!data.response){
	            		$msg.removeClass('alert-success').addClass('alert-danger');
	            	}else{
						$msg.removeClass('alert-danger').addClass('alert-success');
						//refrescamos la página cuando cierre el modal
						$('.modal').on('hidden.bs.modal', function(){
							location.reload();
						});

	            	}
	            	$msg.html(data.message);
	            	$('#password').val('');
	            	$msg.fadeIn(300);
	            },
	            error: function(xhr, status, error){

	            	var msgtxt = 'El servidor ha respondido con un mensaje de error.<br>';

	            	if(xhr.responseText){
	            		msgtxt += 'Mensaje: ' + xhr.responseText + '. ';
	            	}

	            	$msg.removeClass('alert-success').addClass('alert-danger');
	            	$msg.html(msgtxt);
	            	$('#password').val('');
	            	$msg.fadeIn(300);
	            }
	        });

	},
	"resetForm" : function(formID){

		var $form = $('form'+formID);
		$form.find('#respuesta').html('');
		$form.find('#respuesta.alert').hide();
		$form[0].reset();
	},
	"preventFormSaving" : function(){
		//los botones de editar y agregar los inicializamos deshabilitados
		$('.btn-edit, .btn-add').prop('disabled', true);
		
		//convertimos el formulario a un array y luego lo pasamos a un objeto JSON
		var formData = Certamen.prepareJSONstring($('form').serializeArray());
		
		//Mantiene el submit deshabilitado hasta que se realiza una modificación en un formulario
		$('select').on('change', function(){
			//Si un combo cambio, entonces habilitamos el envio del form
			$('.btn-edit, .btn-add').prop('disabled', false);
		});

		$('input').on('keydown',function(){
			//al comenzar a escribir en un input, habilitamos el boton
			$(this).data('edited', true);
		});

		$('input').on('keyup blur', function(){
			//al quitar el foco del input o al dejar de escribir, evaluamos la situacion
			var $this = $(this), $name = $this.attr('name'), $value = $this.val();
		
			//si existe en el formulario la propiedad editada y si su valor cambio
			if(formData.hasOwnProperty($name) && formData[$name] != $value){
				//marcamos como editado el input
				$this.data('edited', true);	
				//habilitamos el envio del form
				$('.btn-edit, .btn-add').prop('disabled', false);
			}else{
				//si el valor no cambio, lo marcamos como no editado y deshabilitamos el envio
				$this.data('edited', false);
				$('.btn-edit, .btn-add').prop('disabled', true);

				//buscamos todos los input que hayan sido editados, y si existe alguno que no sea el actual, entonces habilitamos el formulario
				if($('input').filterByData('edited', true).not($this).length > 0){
					$('.btn-edit, .btn-add').prop('disabled', false);
				}				
				
			}
		});
	},
	"prepareJSONstring" : function(arrayForm){
		
		var formData = '{';

		$(arrayForm).each(function(i,v){
			formData += '"' + v.name + '"';
			formData += ':';
			formData += '"' + v.value + '"';
			if(arrayForm.length-1 != i){
				formData += ',';
			}
		});

		formData += '}';
		//devolvemos un objeto JSON
		return JSON.parse(formData);
	},
	"showModal" : function(title, content){
		var $alert = $('#modal-alert');

		if(!title){
			title = "Advertencia!";
		}

		$alert.find('.modal-title').text(title);
		$alert.find('.modal-body').html(content);
		$alert.modal('show');
	}
};

//Extension al JQuery Filter para filtrar por attributos data agregados via jQuery y no a traves del DOM
(function ($){

    $.fn.filterByData = function (prop, val) {
        var $self = this;
        if (typeof val === 'undefined') {
            return $self.filter(
                function () { return typeof $(this).data(prop) !== 'undefined'; }
            );
        }
        return $self.filter(
            function () { return $(this).data(prop) == val; }
        );
    };

})(window.jQuery);