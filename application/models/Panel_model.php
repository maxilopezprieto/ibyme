<?php
/*
*	Desarrollo: Funciones Genéricas para todo sistema
*	Fecha: 02/08/2017
*/
class Panel_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

// SESION ------------------------------------------------------------------------------------------------------------
	
	/* El select es particular a cada sistema. Está reducido al minimo (usuario, nombre, apellido, rol)
	** Esta función trae los datos del usuario, id y nombre del rol
	*/
    public function login($usuario, $password){
		$this->db->select('dni, usuarios.nombre, apellido, roles.nombre as nombreRol, usuarios.idRol as idRol');
		$this->db->from('usuarios');
		$this->db->where('dni', $usuario);
		$this->db->where('password', $password);
		$this->db->join('roles', 'usuarios.idRol = roles.id');
		$consulta = $this->db->get();
		$resultado = $consulta->row();
		return $resultado;
   }  
   
   //OPCIONAL
	public function registrarAcceso($usuario){
		$ultimoAcceso = date("Y-m-d H:i:s");
		$this->db->set('ultimoAcceso', $ultimoAcceso);
		$this->db->where('dni', $usuario);
		$this->db->update('usuarios');
   }
   //FIN OPCIONAL
   
	//OPCIONAL: Para reseteo de password por mail
	public function verificarMail($mail){
		$this->db->select('usuario, mail');
		$this->db->from('usuarios');
		$this->db->where('mail', $mail);
		$consulta = $this->db->get();
		$resultado = $consulta->row();
		return $resultado;
	}

	
	public function setReset($usuario){
		unset($usuario->mail);
		$this->db->insert('resetpassword', $usuario);
	}
	
	public function getToken($token){
		$this->db->select('fechaCreacion, fechaUso, usuario, id');
		$this->db->from('resetpassword');
		$this->db->where('token', $token);
		$consulta = $this->db->get();
		$resultado = $consulta->row();
		return $resultado;		
	}
	
	public function caducaToken($recupero){
		$this->db->where('id', $recupero->id);
		$this->db->update('resetpassword', $recupero);
	}
	//FIN OPCIONAL

// GETTERS GENERALES ------------------------------------------------------------------------------------------------------------
   
	public function getPermisos($idFuncion, $idRol){
		$this->db->select('permiso');
		$this->db->from('permisos');
		$this->db->where('idFuncion', $idFuncion);
		$consulta = $this->db->get();
		$resultado = $consulta->row();
		return $resultado;
	}
   
	public function getRoles(){
		$this->db->select('id, nombre');
		$this->db->from('roles');
		$consulta = $this->db->get();
		return $consulta->result();		
	}

// LOG ------------------------------------------------------------------------------------------------------------
	
	public function eventsLog($evento){
	   $this->db->insert('log', $evento);
   }
 
// GESTION DE  USUARIOS--------------------------------------------------------------------------------------------

	/* Este conjunto de funciones maneja el AMB de usuarios del sistema y sus claves
	**
	*/
 
	public function cambioPassword($usuario){
		$this->db->where('dni', $usuario['dni']);
		$this->db->update('usuarios', $usuario);
		return $this->db->affected_rows();
	}
	
	public function getSysUser($usuario=NULL){
	   $this->db->select('dni, usuarios.nombre, apellido, mail, roles.nombre as rol, usuarios.idRol as idRol, ultimoAcceso, fechaAlta');
	   $this->db->from('usuarios, roles');
	   $this->db->where('usuarios.idRol = roles.id');
	   if ($usuario != NULL){
			$this->db->where('dni', $usuario);
			$consulta = $this->db->get();
			$resultado = $consulta->row();
			return $resultado;
	   } else {
			$consulta = $this->db->get();
			return $consulta->result();
	   }
   }
   
	public function addSysUser($sysUser){
		$usuario = $this->getSysUser($sysUser->dni);
		if (!empty($usuario)){
			throw new Exception('El usuario ya existe');
		}
		$this->db->insert('usuarios', $sysUser);
	}
	
	public function editSysUser($tabla, $sysUser, $usuarioViejo){
		$this->db->where('dni', $usuarioViejo);
		$this->db->update($tabla, $sysUser);
	}
	
	public function removeSysUser($idUsuario){
		$this->db->where('dni', $idUsuario);
		$this->db->delete('usuarios');		
	}
}