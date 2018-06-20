<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('server_model');
	}
	public function no_found(){
		$data = array();
		$this->load->view('layout/header',$data);
		$this->load->view('layout/extra-404',$data);
		$this->load->view('layout/footer',$data);
	}
	public function validarLogin(){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}
	}
	public function index(){
		$this->validarLogin();
		$data = array();
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
	    $this->load->view('consulta',$data);
		$this->load->view('layout/footer',$data);
	}

	public function load_view($view, $data=array()){
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
	    $this->load->view($view,$data);
		$this->load->view('layout/footer',$data);	
	}

	public function logout(){
		unset($_SESSION['USR_LOGGED']);
		$this->login();
	}
	public function login(){
		$data= array();
		$this->load->view('layout/login',$data);	
	}
	public function validarUser(){
		$array['username'] = $this->input->post('username');
		$array['password'] = $this->input->post('password');
		$resp = $this->server_model->validarUserBPM($array);
		echo json_encode($resp);
	}
	public function menu_dashboard(){
		$this->validarLogin();
		$this->load_view("bpm/menu_dashboard");
	}
	public function doc_tributarios(){
		$this->validarLogin();
	}
	
	//carga por defecto varible de session
	public function activaPM(){
		$array['username'] = $_POST['username'];
		$array['password'] = $_POST['password'];
		header("location:".base_url());
		$resp = $this->server_model->validarUserBPM($array);
	}
}
?>