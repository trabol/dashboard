<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

class administracionController extends CI_Controller 
{
	
	
	public function index(){
		$this->salirIndex();
	}


	public function permisos($opcion='' , $userUID=''){
		$this->validarLogin();
		$data = array();
		$data["directorio"]    ="Administracion";//tabla menu_modulos
		$data["SubDirectorio"] ="Permisos"; //tabla sub_menu_modulos

		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);

		$vista = "mantenedor/usuariosBpm";
		$this->load->model("mantenedor_model");

		$data["usuarios"] = $this->mantenedor_model->getListaUsuarios();
		$view ="permisos";

		if($opcion=="editar"){
			$view ="permisos-editar";
			if($userUID==""){
			   $this->salirIndex();
			}
			else
			{
				$this->load->model("mantenedor_model");
				$user = $this->mantenedor_model->validarUSR_UID($userUID);
				


		    	if(count($user)>0){
		    		$this->load->model("administracion_model");
					$data["user"]         = $user;
					$data["input_modulo"] = $this->input->post("input_modulo");
					$data["input_perfil"] = $this->input->post("input_perfil");
					$data["USR_UID"]      = $this->input->post("USR_UID");
					//actualizar los campos
					if($this->input->post("hi_opcion")=="saveForm"){
						$data["chekSubModulos"] = $this->input->post("chkSubModulo");
						$this->administracion_model->updateUserSubModulo($data["chekSubModulos"],$data["input_modulo"],$data["USR_UID"],$data["input_perfil"]);
			 		}

					
					$data["modulos"]      = $this->administracion_model->GetListaModulos();
					$data["subModulos"]   = $this->administracion_model->getSubMenuByUser($data["USR_UID"],$data["input_modulo"]);

					
			    }
			    else
			    {
	              $this->salirIndex();
			    }
			}
		}
		

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);

		$this->load->view('administracion/'.$view,$data);
		$this->load->view('layout/footer',$data);
	}

	public function validarLogin(){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}
	}
	public function salirIndex($value='')
	{
		header("location:".base_url()."administracion/permisos");
	}
}
?>