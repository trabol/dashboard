<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 class centroCostosController extends CI_Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct();
	    $this->load->helper(array('form', 'url'));
		$this->load->library('PHPExcel.php');
 	}

 	public function index(){
 		//$this->validarLogin();

		$data = array();
		$data["directorio"]    ="Mantenedor";
		$data["SubDirectorio"] ="";
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('mantenedor',$data);
		$this->load->view('layout/footer',$data);
 	}

 	public function validarLogin(){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}
	}

 }
?>