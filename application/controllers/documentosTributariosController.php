<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocumentosTributariosController extends CI_Controller {

	public function index()
	{ 

		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}

		$data = array();
		$data = array();
		$data["directorio"]    = "Consultas";
		$data["SubDirectorio"] = "Documentos";

		//echo base_url();
		//$this->validarLogin();
		//modelo capaz de carga los modulos que le corresponden al usuario
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser();
		$data["resultado"]    = array();
		$data["doc_dt"] 	  = array();
		$data['doc_dt']['rs_cant'] = 0;

		$activoBusqueda = $this->input->post('activoBusqueda');
		if($activoBusqueda != "" && $activoBusqueda == 1 ){
			$this->load->model('DocumentosTributarios_model');
			
			$data['inputTipo'] = trim($this->input->post('inputTipo'));
			$data['inputDoc']  = trim($this->input->post('inputDoc'));
			$data['inputRut']  = trim($this->input->post('inputRut'));
			$data['inputCaso'] = trim($this->input->post('inputCaso'));

			$data["doc_dt"] = $this->DocumentosTributarios_model->buscar_documentos($data);
		}


		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('DocumentosTributarios/index',$data);
		$this->load->view('layout/footer',$data);
	}

	public function get_traza_caso($ID_CASO,$TIPO_DOC)
	{
		if($ID_CASO > 0){
			$this->load->model('DocumentosTributarios_model');
			$data = $this->DocumentosTributarios_model->buscar_traza_by_caso($ID_CASO,trim($TIPO_DOC));
			$finalixe =$this->load->view('DocumentosTributarios/ajax/traza',$data, TRUE);
			echo  $finalixe;
		}
	}

	public function logout(){
		$data =array();
		unset($_SESSION);
		session_destroy();
		$this->load->view('layout/logout',$data);
	}

	public function validarLogin(){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}else{
			header("location:".base_url());
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

/* End of file documentosTributariosController.php */
/* Location: ./application/controllers/documentosTributariosController.php */