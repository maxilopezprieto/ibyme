<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('class/sysuser.class.php');
/*
*	Desarrollo: Funciones Genéricas para todo sistema
*	Fecha: 02/08/2017
*/
class Panel extends CI_Controller
{
    public function __construct(){
        parent::__construct();
		$this->load->library('session');
		$this->load->model('panel_model');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('email');
	}

// CONTROLES DE SESION Y PERMISOS -----------------------------------------------------------------------------------
	
	/* Login: Contiene el acceso a cuentas. Usuario (genérico, cada empresa decide que usar) y Contraseña
	** Vista: Las vistas del control de sesión se guardan en views/session/
	*/
	
	public function login(){
		$data['error'] = $this->session->flashdata('error');
		$this->load->view('sesion/form_login', $data);
	}
	
	public function doLogin(){
		if ($this->input->post()) {
			$usuario = $this->panel_model->login($this->input->post('dni'), md5($this->input->post('password')));
			/*Guardando los datos de usuario
			**Set de datos del usuario a guardar en la sesión. Es la respuesta de la función login del modelo
			** Usuario / Nombre / Apellido / Rol / Nombre Rol
			*/
			if ($usuario){
				$userData = (array) $usuario;
				$userData['logueado'] = TRUE;				
				$this->session->set_userdata($userData);
				//OPCIONAL: Registra el último acceso del usuario
				$this->panel_model->registrarAcceso($this->input->post('usuario'));
				//FIN OPCIONAL
				redirect('panel/index');
			}else{
                $this->session->set_flashdata('error', 'Usuario y/o contraseña no son validos.');
                redirect('panel/login');				
			}
		}else{
			redirect('panel/login');
		}
	}
	
	public function logout(){
		define("IDFUNCION", 100);
		$this->control(IDFUNCION);
		//Encontrar la forma de llenar el array sin tener que escribir todos los atributos
        $user_session = array('id', 'nombre', 'apellido', 'rol', 'logueado');
        $this->session->unset_userdata($user_session);
        redirect('panel/login');		
	}
	
	public function control($idFuncion=null){
		if (!$this->session->userdata('logueado')){
			$this->session->set_flashdata('warning', "Para acceder al sistema debe estar logueado");
            redirect('panel/login');
		}
		//OPCIONAL: Se usa en caso de tener niveles de usuario. Por default FULL
		$idRol = $this->session->userdata('idRol');
		$permisos = $this->panel_model->getPermisos($idFuncion, $idRol);

		if (substr($permisos->permiso, $idRol, 1) == 0){
			$this->load->view('accesoDenegado');
		}
		//FIN OPCIONAL
	}
	
	//OPCIONAL: Reset de password por mail
	public function resetPassword(){

		$mail = $this->input->post('mail');
		$usuario = $this->panel_model->verificarMail($mail);
		
		if (!empty($usuario)){
			$fecha = new DateTime();
			$token = md5($fecha->getTimestamp() . $mail);
			$usuario->token = $token;
			$usuario->fechaCreacion = date("Y-m-d H:i:s");
			$usuario->fechaUso = null;
			$this->panel_model->setReset($usuario);
			$usuario->mail = $mail;
			$this->enviarToken($usuario);
			echo json_encode(array("response" => true, "message" => "La información de recuperación de clave fue enviada por correo."), JSON_UNESCAPED_UNICODE);
		} else {
			 echo json_encode(array("response" => false, "message" => "El correo ingresado no existe."), JSON_UNESCAPED_UNICODE);
		}

	}
	
	public function enviarToken($usuario){
		$url = site_url() . "/panel/doResetPassword?token=" . $usuario->token;
		$mensaje = "Para recuperar su password haga clic <a href=".$url.">aqui</a>";
		
        $configMail = array(
                            'protocol' => 'smtp',
                            'smtp_host' => 'smtp.sendgrid.net',
                            'smtp_port' => 587,
                            'smtp_user' => 'azure_5099f56c9eaf6e8561579143375e1507@azure.com',
                            'smtp_pass' => 'EnvioCorreo2016!',
                            'mailtype' => 'html',
                            'charset' => 'utf-8',
                            'newline' => "\r\n"
                        );  
        $this->email->initialize($configMail);
        $this->email->from('passwordreset@vidaliquida.com.ar');
        $this->email->to($usuario->mail);
        $this->email->subject('Recupero contraseña Certamen 2017');
        $this->email->message($mensaje);
		$this->email->attach('');
        $this->email->send();
	}
	
	public function doResetPassword(){
		$token = $this->input->get('token');
		$recupero = $this->panel_model->getToken($token);
		
		if($this->verificarToken($recupero)){
			$this->load->view('sesion/form_recuperar-clave');
		} else {
			//Adaptar la vista para que tire el error
			$data['error'] = "Token Vencido o Incorrecto";
			$this->load->view('session/form_recuperar-clave', $data);
		}
	}
	
	public function verificarToken($recupero){
		if (!empty($recupero)){
			$fechaActual = new DateTime();
			$fechaCreacion = new DateTime($recupero->fechaCreacion);
			$diferencia = $fechaActual->diff($fechaCreacion);
				if($diferencia->d < 3 && $recupero->fechaUso == null){
					return true;
				}
		}
		return false;
	}
	
	public function recoverPassword(){
		$password = $this->input->post('password');
		$token = $this->input->post('token');
		$recupero = $this->panel_model->getToken($token);
		if($this->verificarToken($recupero)){
			$usuario = array(
					'dni' => $recupero->dni,
					'password' => md5($password)
				);
			$this->panel_model->cambioPassword($usuario);
			$recupero->fechaUso = date("Y-m-d H:i:s");
			$this->panel_model->caducaToken($recupero);
			$this->eventsLog('102', $recupero->dni, NULL);
			//Lleva a success Page
			echo "Su password fue cambiado con éxito";			
		} else {
			//Lleva a success Page con error
			echo "token vencido o incorrecto";
		}
	}
	//FIN OPCIONAL
	
	//OPCIONAL: Confirmación de acción con password
	public function removeConfirm($dni, $password){
		$usuario = $this->panel_model->login($dni, md5($password));
		if($usuario){
			return true;
		}
		return false;		
	}
	//FIN OPCIONAL

// FUNCIONES AUXILIARES -----------------------------------------------------------------------------------
	/* LOG DE ACTIVIDAD
	** idFuncion: Indica la acción (Alta, Baja, Modificacion, Lectura)
	** idEntidad: Indica que item se tocó
	** observaciones: Dato auxiliar, util para registrar cambios de estado o claves primarias (identificador)
	*/
	
	public function eventsLog($idFuncion, $idEntidad, $observaciones){
		$dni = $this->session->userdata('dni');
		$fecha = date("Y-m-d H:i:s");

		$evento = array(
					'dni' => $dni,
					'fecha' => $fecha,
					'idFuncion' => $idFuncion,
					'idEntidad' => $idEntidad,
					'observaciones' => $observaciones
				);
		$this->panel_model->eventsLog($evento);
	}
	
	/* Validar Password
	** Callback destinado a cumplir los requisitos mínimos de seguridad del password
	*/
	public function validarPassword($str){
		$regexp = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/';
		if (preg_match($regexp,$str)){
				return TRUE;
			} else {
		$this->form_validation->set_message('validarPassword','La contraseña no cumple con los criterios mínimos de seguridad');
		return FALSE;
		}		
	}
	
	/* Validar Igualdad
	** Callback destinado a verificar si el password coincide en ambos campos
	*/	
	public function validarIgualdadPass($pss1){
		if ($pss1 == $this->input->post('password')){
			return TRUE;
		} else {
		$this->form_validation->set_message('validarIgualdadPass','Las contraseña no coinciden');
		return FALSE;			
		}
	}


// DASHBOARD-------------------------------------------------------------------------------------------

	public function index(){
		define("IDFUNCION", 100);
		$this->control(IDFUNCION);
		$data = array();
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/index', $data);
		$this->load->view('dashboard/footer');
	}
	
//PANEL USUARIO----------------------------------------------------------------------------------------

	public function adminSysUser(){
		define("IDFUNCION", 200);
		$this->control(IDFUNCION);
		$data['idSeccion'] = 0; //Identificador para front-end
		$sysUser = $this->panel_model->getSysUser();
		foreach ($sysUser as $key => $value){
			if ($value->idRol == 0){
				if($this->session->userdata('rol') != 0) {
					unset($sysUser[$key]);
				}
			}
		}
		$data['usuarios'] = $sysUser;
		$data['success'] = $this->session->flashdata('success');
		$this->load->view('header', $data);
		$this->load->view('usuarios/form_usuario-listado', $data);
		$this->load->view('footer');
	}
	
	public function addSysUser(){
		define("IDFUNCION", 201);
		$this->control(IDFUNCION);
		$data['action']= 'panel/doAddSysUser';
		$data['titulo']= 'Alta Usuario';
		$data['boton'] = ' Guardar y agregar otro';
		$data['idSeccion'] = 0; //Identificador para front-end
		$data['error'] = $this->session->flashdata('error');
		$roles = $this->panel_model->getRoles();
		foreach ($roles as $key => $value){
			if ($value->id == 0){
				if($this->session->userdata('rol') != 0) {
					unset($roles[$key]);
				}
			}
		}
		$data['roles'] = $roles;
		$this->load->view('header', $data);
		$this->load->view('usuarios/form_unificado', $data);
		$this->load->view('footer');
	}
	
	public function doAddSysUser(){
		define("IDFUNCION", 201);
		$this->control(IDFUNCION);
		$sysUser = new SysUser();
		$this->form_validation->set_rules($sysUser->getRules());
		$this->form_validation->set_rules('password','Contraseña', 'callback_validarPassword');
		$this->form_validation->set_rules('password2','Contraseña', 'callback_validarIgualdadPass');
		
		if ($this->form_validation->run()){
			$sysUser->setParams($this->input->post());
			$sysUser->fechaAlta = date("Y-m-d H:i:s");
			try{
				$dni = $this->panel_model->addSysUser($sysUser);
			} catch (Exception $e) {
				$this->session->set_flashdata('error', 'Ya existe un usuario con ese dni.');
				redirect('panel/addSysUser');
			}
			$this->eventsLog(IDFUNCION, $sysUser->dni, NULL);
			$this->session->set_flashdata('success', 'Usuario agregado con éxito.');
			redirect('panel/adminSysUser');
		} else {

			$this->session->set_flashdata('error2', validation_errors());
			redirect('panel/addSysUser');
		}
	}
	
	public function editSysUser(){
		define("IDFUNCION", 202);
		$this->control(IDFUNCION);
		$data['idSeccion'] = 0; //Identificador para front-end
		$data['action']= 'panel/doEditSysUser';
		$data['titulo']= 'Editar Usuario';
		$data['boton'] = ' Modificar';
		
		$dni = $this->input->get('dni');
		$data['usuario'] = $this->panel_model->getSysUser($dni);
		$data['error'] = $this->session->flashdata('error');

		$roles = $this->panel_model->getRoles();
		foreach ($roles as $key => $value){
			if ($value->id == 0){
				if($this->session->userdata('rol') != 0) {
					unset($roles[$key]);
				}
			}
		}
		$data['roles'] = $roles;
		$this->load->view('header', $data);
		$this->load->view('usuarios/form_unificado', $data);
		$this->load->view('footer');
	}
	
	public function doEditSysUser(){
		define("IDFUNCION", 202);
		$this->control(IDFUNCION);
		$sysUser = new SysUser();
		$this->form_validation->set_rules($sysUser->getRules());
		$dniActual = $this->input->post('dniActual');
		$usuarioActual = $this->panel_model->getSysUser($dniActual);
		$sysUser->fechaAlta = $usuarioActual->fechaAlta;
		$sysUser->ultimoAcceso = $usuarioActual->ultimoAcceso;
		$observaciones = NULL;
		
		if($dniActual != $this->input->post('dni')){
			$observaciones = 'Cambio de dni de '.$dniActual.' a '.$this->input->post('dni');
			$result = $this->panel_model->getSysUser($this->input->post('dni'));
			if (!empty($result)){
					$this->session->set_flashdata('error', 'Ya existe un usuario con ese dni. Elija otro.');
					$salida = "panel/editSysUser?dni=".$this->input->post('dniActual');
					redirect($salida);		
			}
		
		}
		
		if ($this->form_validation->run()){
			$sysUser->setParams($this->input->post());
			$this->panel_model->editSysUser('usuarios', $sysUser, $dniActual);
			$this->eventsLog(IDFUNCION, $usuarioActual->dni, $observaciones);
			redirect('panel/adminSysUser');
		} else {
			//echo validation_errors();
			echo "HOLA";
		}
	}
	
	public function panelUsuario(){
		define("IDFUNCION", 101);
		$this->control(IDFUNCION);
		$data['idSeccion'] = 0; //Identificador para front-end
		$dni = $this->session->userdata('dni');
		$usuario = $this->panel_model->getSysUser($dni);

		$data['usuario'] = $usuario;
		$this->load->view('header', $data);
		$this->load->view('usuarios/form_usuario_perfil', $data);
		$this->load->view('footer');		
	}
	
	public function doEditPanelUsuario(){
		define("IDFUNCION", 101);
		$this->control(IDFUNCION);
		$sysUser = new SysUser();
		$actualUser = $this->panel_model->getSysUser($this->input->post('dni'));
		
		if($this->input->post('formId') == 0){
			$reglas = $sysUser->getRules();
			unset($reglas[3]);
			$this->form_validation->set_rules($reglas);
			$sysUser->dni = $actualUser->dni;
			$sysUser->nombre = $actualUser->nombre;
			$sysUser->apellido = $actualUser->apellido;
			$sysUser->idRol = $actualUser->idRol;
			$sysUser->ultimoAcceso = $actualUser->ultimoAcceso;
			$sysUser->fechaAlta = $actualUser->fechaAlta;
			$sysUser->setParams($this->input->post());
		} else {
			$this->form_validation->set_rules('password','Contraseña', 'callback_validarPassword');
			$this->form_validation->set_rules('password2','Contraseña', 'callback_validarIgualdadPass');
			$sysUser->nombre = $actualUser->nombre;
			$sysUser->apellido = $actualUser->apellido;
			$sysUser->password = md5($this->input->post('password'));
			$sysUser->mail = $actualUser->mail;
			$sysUser->idRol = $actualUser->idRol;
			$sysUser->ultimoAcceso = $actualUser->ultimoAcceso;
			$sysUser->fechaAlta = $actualUser->fechaAlta;
		}
		
		if ($this->form_validation->run()){
			$this->panel_model->editSysUser('usuarios', $sysUser, $actualUser->dni);
			$observaciones = "Se editó el usuario";
			$this->eventsLog(IDFUNCION, $sysUser->dni, $observaciones);
			redirect('panel/index');
		} else {
			
			$this->session->set_flashdata('error2', validation_errors());
			redirect('panel/panelUsuario');			
		}
		
	}
	
	public function removeSysUser(){
		define("IDFUNCION", 203);
		$this->control(IDFUNCION);
		
		$usuario = $this->session->userData('dni');
		$password = $this->input->post('password');
		$idUsuario = $this->input->post('idUsuario');

		
		if(!$this->removeConfirm($usuario, $password)){
			echo json_encode(array("response" => false, "message" => "Error en la contraseña."), JSON_UNESCAPED_UNICODE);
			exit;
		}
		$this->panel_model->removeSysUser($idUsuario);
		$this->eventsLog(IDFUNCION, $idUsuario, NULL);
		echo json_encode(array("response" => true, "message" => "Usuario eliminado exitosamente!"),JSON_UNESCAPED_UNICODE);	
		
	}
	
	public function cambioPassword(){
		$dni = $this->input->get('dni');
		if ($dni == $this->session->userdata('dni')){
			
		} else {
			define("IDFUNCION", 202);
			$this->control(IDFUNCION);
		}
	}
	
	public function doCambioPassword(){
		//Pensar incluir lógica para obligar a cambiar password post blanqueo del admin
		define("IDFUNCION", 202);
		$this->control(IDFUNCION);
		$logueado = $this->session->userData();
		$dni = $this->input->post('dni');
		$password = $this->input->post('password');
		$password2 = $this->input->post('password2');
		$this->form_validation->set_rules('password','Contraseña', 'callback_validarPassword');
		$this->form_validation->set_rules('password2','Contraseña', 'callback_validarIgualdadPass');
		
		if (($logueado['dni'] == $dni) || $logueado['idRol'] <= 1){
			if ($this->form_validation->run()){
					$usuario = array(
							'dni' => $dni,
							'password' => md5($password)
						);
				$response = $this->panel_model->cambioPassword($usuario);
				$this->eventsLog(IDFUNCION, $dni, NULL);
				echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> La clave fué cambiada con éxito.</div>';
				} else {
					echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>'.validation_errors().'</div>';
				}			
		} else {
			echo "Ud no tiene permisos";
		}

		

	}
	
	
}