<?php

class SysUser
{
    public function setParams($parametros){
		$this->dni = $parametros['dni'];
		if (isset($parametros['nombre'])){
			$this->nombre = $parametros['nombre'];
		}	        
		if (isset($parametros['apellido'])){
			$this->apellido = $parametros['apellido'];
		}
		if (isset($parametros['password'])){
			$this->password = md5($parametros['password']);
		}		
		if (isset($parametros['idRol'])){
			$this->idRol = $parametros['idRol'];
		}
		if (isset($parametros['mail'])){
			$this->mail = $parametros['mail'];
		}
    }
	
	public $fechaAlta;
	public $ultimoAcceso;

    public function getRules(){
            $config = array(
                    array(
                        'field'=>'dni',
                        'label'=>'dni',
                        'rules'=>'required|numeric'
                    ),
                    array(
                        'field'=>'apellido',
                        'label'=>'Apellido',
                        'rules'=>'required'
                    ),
                    array(
                        'field'=>'nombre',
                        'label'=>'Nombre',
                        'rules'=>'required'
                    ),
                    array(
                        'field'=>'idRol',
                        'label'=>'Rol',
                        'rules'=>'required|in_list[0,1,2,3]'
                    ),
                    array(
                        'field'=>'mail',
                        'label'=>'Principal',
                        'rules'=>'required|valid_email'
                    )
                 );
        return $config;        
    }		
	
}