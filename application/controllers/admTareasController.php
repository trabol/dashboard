<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admTareasController extends CI_Controller {

	public function index()
	{ 

		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}

		$data = array();
		$data = array();
		$data["directorio"]    = "Administrador de tareas";
		$data["SubDirectorio"] = "Grupo de tareas";
		//echo base_url();
		//$this->validarLogin("grupo-tareas");
		//modelo capaz de carga los modulos que le corresponden al usuario
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser();

		$this->load->model('tareas_model');
		$data['tareas'] = $this->tareas_model->getGrupoTareas();

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('administradorTareas/grupoTareas',$data);
		$this->load->view('layout/footer',$data);
	}
	//mantendor para mostrar solo los usuarios que esten dentro del flujo BPM ODT (orquestador de tareas)
	public function user_bpm_odt($opcion =""){
		
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}

		$data = array();
		$data["directorio"]    = "Administrador de tareas";
		$data["SubDirectorio"] = "Usuarios BPM ODT";
		$data["usuarios"] 	   = array();
		//echo base_url();
		//$this->validarLogin("grupo-tareas");
		//modelo capaz de carga los modulos que le corresponden al usuario
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser();

		//$this->load->model('user_model');
		/*$_users = $this->user_model->get_list_user_by_flujo("1");
		if(count($_users)>0){
			$data["usuarios"] =$_users;
		}*/

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('administradorTareas/usuariosBPM/listaUsuarios',$data);
		$this->load->view('layout/footer',$data);
	}


	public function enviarTareasHome($ID_GRUPO){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}

		$data = array();
		$data = array();
		$data["directorio"]    = "Administrador de tareas";
		$data["SubDirectorio"] = "Grupo de tareas";
		//modelo capaz de carga los modulos que le corresponden al usuario
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser();

		$this->load->model('tareas_model');
		$data['tareas'] = $this->tareas_model->getGrupoTareasBYID($ID_GRUPO);
		$opcion = $this->input->get_post('opcion');

		if($opcion=="enviar"){
			$data["mensaje"] = $this->tareas_model->enviarTareasUser($ID_GRUPO);
		}
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('administradorTareas/grupoTareasEnviarTareas',$data);
		$this->load->view('layout/footer',$data);

	}

	public function nuevoGrupo(){

		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}

		$data = array();
		$data = array();
		$data["directorio"]    = "Administrador de tareas";
		$data["SubDirectorio"] = "Grupo de tareas";
		//echo base_url();
		//modelo capaz de carga los modulos que le corresponden al usuario
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser();

		$this->load->model('tareas_model');
		$data['sociedades'] = $this->tareas_model->getSociedades();
		$data['userGrupo']  = $this->tareas_model->getUserBygrupo("ODT-ingresadores");

		$opcion =$this->input->post('opcion');
		$tareas =$this->input->post('tareas');
		$nombreGrupo = $this->input->post('nombreGrupo');

		if($opcion=="guardar"){
			$data["mensaje"] = $this->tareas_model->nuevoGrupoTareas($tareas,$nombreGrupo);
		}
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('administradorTareas/grupoTareasNew',$data);
		$this->load->view('layout/footer',$data);
	}

	public function empresas($opcion = "" , $ID =""){

		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}

		$data = array();
		$data = array();
		$data["directorio"]    = "Administrador de tareas";
		$data["SubDirectorio"] = "Empresas";
		$vista ="index";
		$data["mensajeFinal"]  =0;
		//echo base_url();
		//modelo capaz de carga los modulos que le corresponden al usuario
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser();

		$this->load->model('tareas_model');
		$data["empresas"] = $this->tareas_model->getAllEmpresas();
		
		if($opcion  == "nueva"){
		    $vista  =  "nuevaEmpresa";
		    $sql    =  $this->input->post('hidden_opcion_sql');
		    
		    if($sql == "insertar"){
		   	    
		   	    $var =array();
			   	
			   	$var["NOMBRE"] = $this->input->post('NOMBRE');
			   	$var["CODIGO"] = $this->input->post('CODIGO');

			   	$data["mensajeFinal"] = $this->tareas_model->nuevaEmpresa($var);
		    }
		}else if($opcion =="eliminar"){
			
			$IDEMP = $this->input->post('hidden_emp_id');
			$data["mensajeFinal"] = $this->tareas_model->eliminarEmpresa($IDEMP);
			if($data["mensajeFinal"]==1){
				header('location:'.base_url()."empresas");
			}

		}else if($opcion  == "editar"){
			
		    $data["emp"] =$this->tareas_model->findEmpresaByID($ID);
		    $vista  =  "editarEmpresa";
		    
		    if($ID ==""){
		       header('location:'.base_url()."empresas");
		    }

		    if(count($data["emp"])>0){
		    	$sql    =  $this->input->post('hidden_opcion_sql');
		    	if($sql =="update"){
		     		$var =array();

		     		$var["ID"] = $ID;
				   	$var["NOMBRE"] = $this->input->post('NOMBRE');
				   	$var["CODIGO"] = $this->input->post('CODIGO');
				   	$data["mensajeFinal"] = $this->tareas_model->editarEmpresa($var);
				   	$data["emp"] =$this->tareas_model->findEmpresaByID($ID);
		    	}
		    }
		    else{
		       header('location:'.base_url()."empresas");
		    }
		}
		
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('administradorTareas/empresas/'.$vista,$data);
		$this->load->view('layout/footer',$data);
	}


	

	public function logout(){
		$data =array();
		$this->load->view('layout/logout',$data);
	}

	public function validarLogin($url){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}else{
			header("location:".base_url().$url);
		}
	}
	//validar el inicio sesesion saltandose el doble logeo
	//cuando usario da clic en menu plugin
	public function login($ID_USER = ''){
		$this->load->model('server_model');
        $this->server_model->validarUserBPM_MENU($ID_USER);
        $this->validarLogin();
	}
	public function validarUser(){
		$this->load->model('server_model');
		$array['username'] = $this->input->post('username');
		$array['password'] = $this->input->post('password');

		$resp = $this->server_model->validarUserBPM($array);
		echo json_encode($resp);
	}
}
