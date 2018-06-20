<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

class contabilidadController extends CI_Controller 
{
	
	
	public function index(){
		$this->salirIndex();
	}

	public function tareasPorHacer($opcion='' , $numCaso='',$sociedad=''){
		$this->validarLogin();
		$data = array();
		$data["directorio"]    ="Contabilidad";//tabla menu_modulos
		$data["SubDirectorio"] ="Tareas por hacer"; //tabla sub_menu_modulos

		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);

		$vista = "mantenedor/usuariosBpm";
		$this->load->model("mantenedor_model");

		$data["usuarios"] = $this->mantenedor_model->getListaUsuarios();
		$view ="tareasPorHacer";
		$data["numCaso"] = $numCaso;
		
		$this->load->model("contabilidad_model");
		
		if($opcion==""){
			$data["casos"]   = $this->contabilidad_model->GetTodoCase();
		}
		

		if($opcion=="editar"){
			
			$view ="tareasPorHacer_editar";
			
			if($numCaso=="" || $sociedad ==""){
			   $this->salirIndex();
			}
			else
			{
				$this->load->model("serverBPM_model");
				//delegar caso 
				$data["cabecera"]   = $this->serverBPM_model->GetProvee_DT($sociedad, $numCaso);
				/*
				validar si la cabecera exista*/
				/*echo "<pre>";
				print_r($data["cabecera"]);
				echo "</pre>";
				*/

				if(count($data["cabecera"])>0){

					$data["delegacion"] = $this->serverBPM_model->update_delegarCaso($numCaso);	
					
					$f1   = explode("/" , $data["cabecera"]["FECHA_EMISION"]);
					$f2   = explode("/" , $data["cabecera"]["FECHA_RECEPCION"]);
					$f3   = explode("/" , $data["cabecera"]["FECHA_PAGO"]);

				
					$data["cabecera"]["FECHA_EMISION"]   = $f1[1]."-".$f1[0]."-".substr(trim($f1[2]),0,4);
					$data["cabecera"]["FECHA_RECEPCION"] = $f2[1]."-".$f2[0]."-".substr(trim($f2[2]),0,4);
					$data["cabecera"]["FECHA_PAGO"]      = $f3[1]."-".$f3[0]."-".substr(trim($f3[2]),0,4);

					$data["cabecera"]["TIPDOC"] = $data["cabecera"]["TIPO_DOCUMENTO"];
					$data["cabecera"]["TIPIMP"] = $data["cabecera"]["TIPO_IMPUESTO"];

					if($data["cabecera"]["TIPO_DOCUMENTO"]=="FA"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="FACTURA";
					}
					if($data["cabecera"]["TIPO_DOCUMENTO"]=="BO"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="BOLETA";
					}

					if($data["cabecera"]["TIPO_DOCUMENTO"]=="NC"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="NOTA CREDITO";
					}
					if($data["cabecera"]["TIPO_DOCUMENTO"]=="ND"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="NOTA DEBITO";
					}

					/************************/

					if($data["cabecera"]["TIPO_IMPUESTO"]=="R"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "RETENCIÓN";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "A"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "AFECTO";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "E"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "EXENTO";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "M"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "MIXTO";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "S"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "SIN RETENCIÓN";
					}
					
					/*valida que el documento sea electronico*/
					$_PDF_ELEC       = $this->contabilidad_model->GetDocumentoElectronico($data["cabecera"]);
					$data["anexos"]  = $this->contabilidad_model->GetDocumentoAnexos($numCaso);

					if(count($_PDF_ELEC)>0){
					   $data["DOC_PDF"]["urlFile"] =$_PDF_ELEC[0];

					}else{
						/*valida que el documento sea manual*/
						$_PDF  = $this->contabilidad_model->GetDocumentoManual($numCaso);
						if(count($_PDF)>0){
						   //$extension = "chrome-extension://oemmndcbldboiebfnladdacbdfmadadm/";
						   $extension = "";
						   $data["DOC_PDF"]["urlFile"]=$extension.$_PDF["doc"];
						}
					}
					/*carga la informcacion hacia el formularios*/
					$ID_PROCESO  	  = $data["cabecera"]["ID_PROCESO"];
					$COD_EMPRESA      = $data["cabecera"]["COD_EMPRESA"];
					$data["Comprobante"]  = $this->serverBPM_model->get_bpm_preconprobante($ID_PROCESO,$COD_EMPRESA);
					$data["distribucion"] = $this->serverBPM_model->get_bpm_distribucion($ID_PROCESO,$COD_EMPRESA);
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

		$this->load->view('contabilidad/'.$view,$data);
		$this->load->view('layout/footer',$data);
	}

	public function AJAX_delegarCasoBPM(){
		$this->load->model("serverBPM_model");

		$numero_caso = $this->input->post('numero_caso');
		$ACCION      = $this->input->post('accion_caso');
		$sessionID   = $this->input->post('sessionID_caso');
		$comentarios = $this->input->post('comentarios_caso');
		$caseId      = $this->input->post('APP_UID');
		$nextUser    = $this->input->post('nextUser');
		$tuId        = $this->input->post('TASK_UID');
		$DEL_INDEX   = $this->input->post('DEL_INDEX');
		$password    = $this->input->post('password');

		//$numeroCASO ,$action , $sessionId , $comentarios, $nextUser,$caseId,$tuId){
		$estado =$this->serverBPM_model->sendForceTriggerBpmContabilidad($numero_caso, $ACCION ,$sessionID,$comentarios,$nextUser,$caseId,$tuId,$DEL_INDEX,$password);

		echo json_encode($estado);
	}

	public  function confirmarValidacion(){
		$this->model->serverBPM_model();
		$this->serverBPM_model->login_user_bpm();
	}
	public function validarLogin(){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}
	}
	public function salirIndex($value='')
	{
		header("location:".base_url()."contabilidad/tarea-por-hacer");
	}



	public function histotial_casos($numCaso ='',$sociedad =''){

		$this->validarLogin();
		$this->load->model('layout_modal');
		$data = array();

		
		$data["directorio"]    = "Contabilidad";//tabla menu_modulos
		$data["SubDirectorio"] = "Historial casos"; //tabla sub_menu_modulos
		$data['menuSildebar']  = $this->layout_modal->buscar_modulosByUser($data);
		$data["casos"] 		   = array();

		$view ="historial_caso";
		$data["inputOpciones"] = $this->input->post("inputOpciones");

		$this->load->model("contabilidad_model");

		if($data["inputOpciones"] !="" ){
           $data["casos"] = $this->contabilidad_model->buscarHistorialcaso($data["inputOpciones"]);
		}

		if($numCaso!=""){
		       $this->load->model("serverBPM_model");
				//delegar caso 
				$data["cabecera"]   = $this->serverBPM_model->GetProvee_DT($sociedad, $numCaso);
				if(count($data["cabecera"])>0){
					$view ="historial_caso_detalles";
					
					//$data["delegacion"] = $this->serverBPM_model->update_delegarCaso($numCaso);	
					
					$f1   = explode("/" , $data["cabecera"]["FECHA_EMISION"]);
					$f2   = explode("/" , $data["cabecera"]["FECHA_RECEPCION"]);
					$f3   = explode("/" , $data["cabecera"]["FECHA_PAGO"]);

					
					$data["cabecera"]["FECHA_EMISION"]   = $f1[1]."-".$f1[0]."-".substr(trim($f1[2]),0,4);
					$data["cabecera"]["FECHA_RECEPCION"] = $f2[1]."-".$f2[0]."-".substr(trim($f2[2]),0,4);
					$data["cabecera"]["FECHA_PAGO"]      = $f3[1]."-".$f3[0]."-".substr(trim($f3[2]),0,4);

					if($data["cabecera"]["TIPO_DOCUMENTO"]=="FA"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="FACTURA";
					}
					if($data["cabecera"]["TIPO_DOCUMENTO"]=="BO"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="BOLETA";
					}

					if($data["cabecera"]["TIPO_DOCUMENTO"]=="NC"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="NOTA CREDITO";
					}
					if($data["cabecera"]["TIPO_DOCUMENTO"]=="ND"){
					   $data["cabecera"]["TIPO_DOCUMENTO"] ="NOTA DEBITO";
					}

					/************************/

					if($data["cabecera"]["TIPO_IMPUESTO"]=="R"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "RETENCIÓN";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "A"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "AFECTO";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "E"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "EXENTO";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "M"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "MIXTO";
					}

					if($data["cabecera"]["TIPO_IMPUESTO"]== "S"){
					   $data["cabecera"]["TIPO_IMPUESTO"] = "SIN RETENCIÓN";
					}
					
					/*valida que el documento sea electronico*/
					$_PDF_ELEC       = $this->contabilidad_model->GetDocumentoElectronico($data["cabecera"]);
					$data["anexos"]  = $this->contabilidad_model->GetDocumentoAnexos($numCaso);

					if(count($_PDF_ELEC)>0){
					   $data["DOC_PDF"]["urlFile"] =$_PDF_ELEC[0];

					}else{
						/*valida que el documento sea manual*/
						$_PDF  = $this->contabilidad_model->GetDocumentoManual($numCaso);
						if(count($_PDF)>0){
						   //$extension = "chrome-extension://oemmndcbldboiebfnladdacbdfmadadm/";
						   $extension = "";
						   $data["DOC_PDF"]["urlFile"]=$extension.$_PDF["doc"];
						}
					}
					/*carga la informcacion hacia el formularios*/
					$ID_PROCESO  	  = $data["cabecera"]["ID_PROCESO"];
					$COD_EMPRESA      = $data["cabecera"]["COD_EMPRESA"];
					$data["Comprobante"]  = $this->serverBPM_model->get_bpm_preconprobante($ID_PROCESO,$COD_EMPRESA);
					$data["distribucion"] = $this->serverBPM_model->get_bpm_distribucion($ID_PROCESO,$COD_EMPRESA);
				}
				else
				{
					$this->salirIndex();
				}
		}

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('contabilidad/'.$view,$data);
		$this->load->view('layout/footer',$data);
	}
}
?>