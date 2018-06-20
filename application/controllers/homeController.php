<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class homeController extends CI_Controller {

	public function index()
	{ 

		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."logout");
			exit;
		}

		$data = array();
		$data = array();
		$data["directorio"]    = "Dashboard";
		$data["SubDirectorio"] = "";

		//echo base_url();
		//$this->validarLogin();
		//modelo capaz de carga los modulos que le corresponden al usuario
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser();

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('home',$data);
		$this->load->view('layout/footer',$data);
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
