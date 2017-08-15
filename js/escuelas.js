var sysEsc = {
    "isEditPage" : false,
    "findEscuela" : false,
    "currentEscData" : {
        prov : -1,
        nivel : -1,
        region : -1,
        distrito : -1,
        depto : -1,
        localidad : -1
    },
    "defaultOption" : '<option value="-1" selected="selected">seleccione</option>',
    "getNextComboByProv" : function(idPcia){
        /**
        * Provincias:
        * 1: Buenos Aires
        * 2: CABA
        * Ubicacion Provincias:
        * 0: CABA
        * 1: Buenos Aires
        * 2: Resto
        */
        var pcia = (idPcia == -1) ? sysEsc.currentEscData.prov : idPcia, 
        region = $("#slc-region"), 
        distrito = $('#slc-distrito');

        if(pcia == 1){
            //Si la provincia es Bs As, debemos mostrar Region y Distrito
            //Primero cargamos el combo de region con los datos que necesitamos
            sysEsc.getRegionesByPcia(idPcia);

            if(sysEsc.currentEscData){
                sysEsc.getDistritosByRegion(sysEsc.currentEscData.region);
            }

        } else if (pcia == 2){
            //Si la provincia es CABA mostramos nivel, region y distrito
            sysEsc.getNiveles();
        }
    },
    "getDeptoByProv" : function (idPcia){

        var pcia = (idPcia == -1) ? sysEsc.currentEscData.prov : idPcia;
        var option = sysEsc.defaultOption;
        var depto = $('#slc-deptos');

        $.ajax({
            data: { idProvincia : idPcia },
            url:   '/index.php/panel/getDepto',
            type:  'GET',
            dataType: 'json',
            beforeSend: function (){
                //vaciamos el combo de regiones
                depto.find('option').remove();
            },
            success:  function (data){

                var actualDepto = null;

                depto.append(option);

                $(data).each(function(i, v){ // indice, valor

                    option = $('<option value="' + v.id + '">' + v.nombre + '</option>');
                    if(sysEsc.currentEscData && v.id == sysEsc.currentEscData.depto){
                        actualDepto = v.id;
                        option.attr('selected','selected');
                    }
                    depto.append(option); 
                })
                
                depto.prop('disabled', false);

                if(actualDepto) {
                    sysEsc.getLocalidadesByDepto(actualDepto)
                };
          
            },
            error: function(){
                Certamen.showModal(null,'Ocurrió un error en el servidor...');
            }
        });
    },
    "getRegionesByPcia" : function (idPcia){
        var region = $("#slc-region");
        var option = sysEsc.defaultOption;

        $.ajax({
            data: { idProvincia : idPcia },
            url:   '/index.php/panel/getRegion',
            type:  'GET',
            dataType: 'json',
            beforeSend: function (){
                //vaciamos el combo de regiones
                region.find('option').remove();
            },
            success:  function (data){

                region.append(option);

                $(data).each(function(i, v){ // indice, valor

                    option = $('<option value="' + v.id + '">' + v.nombre + '</option>');
                    if(sysEsc.currentEscData && v.id == sysEsc.currentEscData.region){
                        option.attr('selected','selected');
                    }
                    region.append(option); 
                })
                
                region.prop('disabled', false);   
            },
            error: function(){
                Certamen.showModal(null,'Ocurrió un error en el servidor...');
           }
        });
    },
    "getDistritosByRegion" : function(idReg){
        var distrito = $("#slc-distrito");
        var option = sysEsc.defaultOption;

        $.ajax({
            data: { idRegion : idReg },
            url:   '/index.php/panel/getDistrito',
            type:  'GET',
            dataType: 'json',
            beforeSend: function (){
                //Vaciamos el combo de distritos
                distrito.find('option').remove();
            },
            success:  function (data){

                distrito.append(option);

                $(data).each(function(i, v){ // indice, valor

                    option = $('<option value="' + v.id + '">' + v.nombre + '</option>');
                    if(sysEsc.currentEscData && v.id == sysEsc.currentEscData.distrito){
                        option.attr('selected','selected');
                    }
                    distrito.append(option); 
                })
                
                distrito.prop('disabled', false);

                return true;
          
            },
            error: function(){
                Certamen.showModal(null,'Ocurrió un error en el servidor...');
                return false;
            }
        });
    },
    "getDistritosByRegionCABA" : function(idReg){
        var distrito = $("#slc-distrito");
        var option = sysEsc.defaultOption;

        $.ajax({
            data: { idRegion : idReg },
            url:   '/index.php/panel/getDistritosCabaByRegion',
            type:  'GET',
            dataType: 'json',
            beforeSend: function (){
                //Vaciamos el combo de distritos
                distrito.find('option').remove();
            },
            success:  function (data){

                distrito.append(option);

                $(data).each(function(i, v){ // indice, valor

                    option = $('<option value="' + v.idDistrito + '">' + v.nombre + '</option>');
                    if(sysEsc.currentEscData && v.idDistrito == sysEsc.currentEscData.distrito){
                        option.attr('selected','selected');
                    }
                    distrito.append(option); 
                })
                
                distrito.prop('disabled', false);
            },
            error: function(){
                Certamen.showModal(null,'Ocurrió un error en el servidor...');
            }
        });
    },
    "getNiveles" : function (){
        
        var nivel = $("#slc-nivel");
        var option = sysEsc.defaultOption;

            $.ajax({
                url:   '/index.php/panel/getNivel',
                dataType: 'json',
                beforeSend: function(){
                    nivel.find('option').remove();
                },
                success:  function (data){

                    var actualNivel = null;

                    nivel.append(option);
                    
                    $(data).each(function(i, v){ // indice, valor

                        option = $('<option value="' + v.id + '">' + v.nombre + '</option>');
                        if(sysEsc.currentEscData && v.id == sysEsc.currentEscData.nivel){
                            actualNivel = v.id;
                            option.attr('selected','selected');
                        }
                        nivel.append(option); 
                    });
                    nivel.prop('disabled', false);

                    if(actualNivel){
                        sysEsc.getRegionesByNivel(actualNivel);
                    }
                },
                error: function(){                    
                    Certamen.showModal(null,'Ocurrió un error en el servidor...'); 
                }
            }); 
    },
    "getRegionesByNivel" : function(idNiv){

        var region = $("#slc-region");
        var option = sysEsc.defaultOption;

            $.ajax({
                data: { idNivel : idNiv },
                url: '/index.php/panel/getRegionesCabaByNivel',
                dataType: 'json',
                beforeSend: function(){
                    region.find('option').remove();
                },
                success:  function (data){

                    var actualNivel = null;

                    region.append(option);
                    
                    $(data).each(function(i, v){ // indice, valor

                        option = $('<option value="' + v.idRegion + '">' + v.nombre + '</option>');

                        if(sysEsc.currentEscData && v.idRegion == sysEsc.currentEscData.region){
                            actualRegion = v.idRegion;
                            option.attr('selected','selected');
                        }

                        region.append(option); 
                    });
                    region.prop('disabled', false);

                    if(actualNivel){
                        sysEsc.getDistritosByRegionCABA(actualRegion);
                    }
                },
                error: function(){                    
                   Certamen.showModal(null,'Ocurrió un error en el servidor...'); 
                }
            }); 
    },
    "getLocalidadesByDepto" : function(idDto){

        if(sysEsc.currentEscData.prov == 2){
            return false;
        }

        var option = sysEsc.defaultOption;
        var localidad = $('#slc-localidad');

         $.ajax({
            data: { idDepto : idDto },
            url:   '/index.php/panel/getLocalidad',
            type:  'GET',
            dataType: 'json',
            beforeSend: function (){
                //Vaciamos el combo de distritos
                localidad.find('option').remove();
            },
            success:  function (data){

                localidad.append(option);

                $(data).each(function(i, v){ // indice, valor

                    option = $('<option value="' + v.id + '">' + v.nombre + '</option>');
                    if(sysEsc.currentEscData && v.id == sysEsc.currentEscData.localidad){
                        option.attr('selected','selected');
                    }
                    localidad.append(option); 
                })
                
                localidad.prop('disabled', false);

                return true;
          
            },
            error: function(){
                Certamen.showModal(null,'Ocurrió un error en el servidor...');
                return false;
            }
        });
    },
    "getEscDataById" : function (idEscuela){

        if(idEscuela == -1){
            sysEsc.resetCurrentEscData();
            return sysEsc.currentEscData;
        }

        $.ajax({
            data: { idEsc : idEscuela },
            url:   '/index.php/panel/getEscuelaById',
            type:  'GET',
            dataType: 'json',
            success:  function (data){

                if(data){
                    sysEsc.currentEscData = {
                        prov : data.idProvincia || -1,
                        nivel : data.idNivel || -1,
                        region : data.idRegion || -1,
                        distrito : data.idDistrito || -1,
                        depto : data.idDepto || -1,
                        localidad : data.idLocalidad || -1
                    }
                    
                    sysEsc.setFormBehavior();
                    //Cargamos los combos en base a la información que nos llega de la db
                    sysEsc.getNextComboByProv(sysEsc.currentEscData.prov);
                    sysEsc.getDeptoByProv(sysEsc.currentEscData.prov);
                
                }else{
                    sysEsc.resetCurrentEscData();
                };
            },
            error: function(){
                Certamen.showModal(null,'Ocurrió un error en el servidor...');
            }
        });
    },
    "getEscuelaByLocation" : function(params){
        if(!sysEsc.findEscuela){
            return false;
        }

        var option = sysEsc.defaultOption;
        var listado = $('#slc-escuela');

        var escuelaData = {
            idProvincia : (sysEsc.currentEscData.prov == -1) ? null : sysEsc.currentEscData.prov,
            idNivel : (sysEsc.currentEscData.nivel == -1) ? null : sysEsc.currentEscData.nivel,
            idRegion : (sysEsc.currentEscData.region == -1) ? null : sysEsc.currentEscData.region,
            idDistrito : (sysEsc.currentEscData.distrito == -1) ? null : sysEsc.currentEscData.distrito,
            idDepto : (sysEsc.currentEscData.depto == -1) ? null : sysEsc.currentEscData.depto,
            idLocalidad : (sysEsc.currentEscData.localidad == -1) ? null : sysEsc.currentEscData.localidad
        }

        $.ajax({
            data: escuelaData,
            url:   '/index.php/panel/getEscuelasByFilter',
            type:  'GET',
            dataType: 'json',
            beforeSend: function (){
                //Vaciamos el combo de escuelas
                listado.find('option').remove();
            },
            success:  function (data){
               
                listado.append(option);

                $(data).each(function(i, v){ // indice, valor

                    option = $('<option value="' + v.idEscuela + '">' + v.nombreEscuela + '</option>');

                    listado.append(option); 
                })
                
                listado.prop('disabled', false);

            },
            error: function(){
                Certamen.showModal(null,'Ocurrió un error en el servidor...');
            }
        });
    },
    "getEscuelaById" : function (idEscuela){
        $.ajax({
            data: { idEsc : idEscuela },
            url:   '/index.php/panel/getEscuelaById',
            type:  'GET',
            dataType: 'json',
            beforeSend : function (){
                $('#escuela-data').fadeOut();
            },
            success:  function (escuelaData){
            
                if(escuelaData){
                    $('.escuela-nombre').text(escuelaData.nombreEscuela);
                    $('.escuela-cue').text(escuelaData.CUE);
                    $('.escuela-telefono').text(escuelaData.telefono);
                    $('.escuela-email').text(escuelaData.mail);
                    $('.escuela-direccion').text(escuelaData.direccion);
                    $('#escuela-data').fadeIn();
                    $('#selected-escuela').val(escuelaData.nombreEscuela);
                    $('#idEscuelaAsignada').val(escuelaData.idEscuela);
                }
            },
            error: function(){
                return null;
            }
        });
    },
    "getDocentesByEscuela" : function (idEsc){

        var option = sysEsc.defaultOption;
        var docentes = $('#slc-docente');

        $.ajax({
            data: { idEscuela : idEsc },
            url:   '/index.php/panel/getDocentesByEscuela',
            type:  'GET',
            dataType: 'json',
            beforeSend : function (){
                docentes.find('option').remove();
            },
            success:  function (data){
                
                docentes.append(option);

                $(data).each(function(i, v){ // indice, valor

                    option = $('<option value="' + v.id + '">' + v.apellido + ', ' + v.nombre + ' (DNI: '+ v.dni + ')' + '</option>');

                    docentes.append(option); 
                });
                
                docentes.prop('disabled', false);        

            },
            error: function(){
                Certamen.showModal(null,'Ocurrio un error en el servidor...');
            }
        });
    },
    "setFormBehavior" : function(){
        var nivel = $("#div-nivel"),
        region = $("#div-region"), 
        distrito = $('#div-distrito'),
        departamento = $('#div-depto'),
        localidad = $('#div-localidad');

        switch(parseInt(sysEsc.currentEscData.prov)){
            case 1: //buenos aires
                nivel.hide();
                region.show();
                distrito.show();
                departamento.show();
                localidad.show();
            break;
            case 2://caba
                nivel.show();
                region.show();
                distrito.show();
                departamento.show();
                localidad.hide();
            break;
            default://resto
                nivel.hide();
                region.hide();
                distrito.hide();
                departamento.show();
                localidad.show();
            break;
        }

        sysEsc.resetForm();
    },
    "resetForm" : function(){
        $('#slc-nivel,#slc-region,#slc-distrito,#slc-localidad').prop('disabled',true).find('option').remove();
    },
    "resetCurrentEscData" : function(){
        sysEsc.currentEscData = {
            prov : -1,
            nivel : -1,
            region : -1,
            distrito : -1,
            depto : -1,
            localidad : -1
        }; 
    }
};

$(function(){
    /*Al cargar el sitio quiero ver:
    * Provincia siempre
    * Provincia = BsAs: Mostrar Departamento + Localidad y Región + Distrito (cargar una en funcion de la otra)
    * Provincia = Resto: Mostrar Departamento + Localidad (carga una en funcion de la otra)
    * Provincia = CABA: Mostrar Departamento + Nivel + Distrito (en PRIMARIA tiene SOLO una REGION)
    */
        
    //Chequeamos si estamos editando o añadiendo una escuela
    sysEsc.isEditPage = ($('form').attr('id') == 'editEscuelaForm' || $('form').hasClass('editPageForm')) ? true : false;
    sysEsc.findEscuela = ($(document).find('select#idEscuela')) ? true : false;

    if(sysEsc.isEditPage){
        //Si estamos en la pag de edicion de escuelas, necesitamos los datos de la escuela que queremos editar
        var idEsc = $('#hidEsc').val() || -1;
        //buscamos los datos de la escuela por id
        sysEsc.getEscDataById(idEsc);
    }

    //Asociamos los eventos relacionados al change de los combos

    //SELECTOR DE PROVINCIA
    $("#slc-provincia").change(function(){
        //Reseteamos la data de la escuela actual porque ahora cambió
        sysEsc.resetCurrentEscData();
        //actualizamos la provincia actualmente seleccionada
        sysEsc.currentEscData.prov = parseInt($(this).val());
        //mostramos el formulario que corresponde a esta provincia
        sysEsc.setFormBehavior();
        //buscamos el siguiente combo (depende de la prov)
        sysEsc.getNextComboByProv(sysEsc.currentEscData.prov);
        //llenamos el combo de departamento (depende de la prov)
        sysEsc.getDeptoByProv(sysEsc.currentEscData.prov);

        sysEsc.getEscuelaByLocation(sysEsc.currentEscData);

    });

    //SELECTOR DE REGIONES BS AS
    $("#slc-region").change(function(){
        //actualizamos el valor de la region seleccionada actualmente
        sysEsc.currentEscData.region = parseInt($(this).val());
        if(sysEsc.currentEscData.prov == 2){ 
            //cargamos los distritos de caba
            sysEsc.getDistritosByRegionCABA(sysEsc.currentEscData.region);
        }else{
            //cargamos los demas distritos
            sysEsc.getDistritosByRegion(sysEsc.currentEscData.region);
        }
        sysEsc.getEscuelaByLocation(sysEsc.currentEscData);
    });

    //SELECTOR DE NIVELES CABA
    $("#slc-nivel").change(function(){
        //si estamos en bs as o resto, volvemos
        if(sysEsc.currentEscData.prov != 2){ 
            return false; 
        }
        //actualizamos el valor del nivel seleccionado actualmente
        sysEsc.currentEscData.nivel = parseInt($(this).val());
        //si es caba, cargamos las regiones del nivel
        sysEsc.getRegionesByNivel(sysEsc.currentEscData.nivel);
        sysEsc.getEscuelaByLocation(sysEsc.currentEscData);
    });

    //Carga Localidades
    $("#slc-deptos").change(function(){
        //si estamos en caba volvemos
        if(sysEsc.currentEscData.prov == 2){
            return false;
        }
        //actualizamos el valor del departamento seleccionado actualmente
        sysEsc.currentEscData.depto = parseInt($(this).val());
        //cargamos las localidades correspondientes al depto seleccionado
        sysEsc.getLocalidadesByDepto(sysEsc.currentEscData.depto);
        sysEsc.getEscuelaByLocation(sysEsc.currentEscData);

    });

    $("#slc-distrito").change(function(){
        //si no es caba o bs as, volvemos
        if(sysEsc.currentEscData.prov >= 3){
            return false;
        }
        //actualizamos el valor del distrito seleccionado actualemtne
        sysEsc.currentEscData.distrito = parseInt($(this).val());
        sysEsc.getEscuelaByLocation(sysEsc.currentEscData);
    });

   $("#slc-localidad").change(function(){
        //si es caba, volvemos
        if(sysEsc.currentEscData.prov == 2){
            return false;
        }
        //actualizamos el valor de la localidad seleccionada actualmente
        sysEsc.currentEscData.localidad = parseInt($(this).val());
        sysEsc.getEscuelaByLocation(sysEsc.currentEscData);
    });

   $("#slc-escuela").change(function(){

    var idEscuela = $(this).val();
    sysEsc.getEscuelaById(idEscuela);

    if($('#addDocente').length == 0){
        sysEsc.getDocentesByEscuela(idEscuela);
        $('#selected-docente').val('no seleccionado');
        $('#idDocenteAsignado').val('');
    }
    
   });

   $('#slc-docente').change(function(){
        var $opt = $(this).find('option:selected');
        $('#selected-docente').val($opt.text());
        $('#idDocenteAsignado').val($opt.val());
   });

   /** Comienzo asignacion de multiples escuelas a un docente */
   var escuelasAsignadas = (sysEsc.isEditPage) ?  ($('#escuelas-collection').val() != "") ? $('#escuelas-collection').val().split(',') : [] : [];

   
   $('#asigna-escuela').on('click', function(e){
        e.preventDefault();
        
        var slcEscuela = $("#slc-escuela"), noAsignadas = $('#empty-escuelas'), tabla = $('#tabla-escuelas'), escId = $('#slc-escuela option:selected').val();

        if(slcEscuela.prop('disabled') || escId == -1){
            return false;
        }

        //verificamos que la escuela no haya sido asignada previamente
        if(tabla.find('a.btn').filterByData('escid', escId).length > 0){
            Certamen.showModal('Error', 'La escuela seleccionada ya fue asignada.');
            return false;
        }

        //creamos el html que vamos a insertar, es decir la fila de la tabla
        var fila = '<tr>';
            fila += '<td style="text-align: center;">';
            fila += '<a href="#" class="btn btn-default btn-xs" data-escid="'+escId+'" data-toggle="tooltip" data-placement="left" title="Quitar escuela"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
            fila += '</td>';
            fila += '<td>';
            fila += '<span class="escuel-cue">'+ $('#escuela-data .escuela-cue').text() +'</span>';
            fila += '</td>';
            fila += '<td>'+$('#slc-escuela option:selected').text()+'</td>';
            fila += '</tr>';

        //agregamos la fila;
        tabla.find('tbody').append(fila);
        //actualizamos el array de escuelas asignadas con el nuevo id agregado
        escuelasAsignadas.push(escId);
        //mostramos la tabla
        noAsignadas.fadeOut(300, function(){
            tabla.fadeIn();
        });
        //enviamos al input hidden la data de las escuelas asignadas
        $('#escuelas-collection').val(escuelasAsignadas);

   });

    //click del boton eliminar de las filas de la tabla de escuelas asignadas
    $('#tabla-escuelas').on('click', 'a.btn', function(e){
        e.preventDefault();
        e.stopPropagation();

        var escId = parseInt($(this).data('escid'));

        //eliminamos la fila
        $(this).parents('tr').remove();
        //si era la unica fila de la tabla mostramos el cartel
        if($('#tabla-escuelas').find('tbody tr').length == 0){
           $('#tabla-escuelas').fadeOut(300, function(){
                $('#empty-escuelas').fadeIn();
            });
        }
        //removemos el id de la escuela eliminada del array
        escuelasAsignadas = jQuery.grep(escuelasAsignadas, function(value) {
                              return value != escId;
                            });
        //actualizamos el input hidden con los valores actuales del array
        $('#escuelas-collection').val(escuelasAsignadas);
    });

   /** Fin asignacion de multiples escuelas a un docente */

}); // END document ready