<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mantenedorController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    $this->load->helper(array('form', 'url'));
		$this->load->library('PHPExcel.php');
	}
	
	public function index(){
		
		$this->validarLogin();

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

	public function centroCostos($IDUSER=""){
		
		$this->validarLogin();

		$data = array();
		
		$data["directorio"]    ="Mantenedor";
		$data["SubDirectorio"] ="Centro costos";
		
		$data["input_empresa"] = "";
		$data["rutCosto"] 	   = array();
		
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);
		
		$this->load->model("mantenedor_model");
		$data["colaboradores"] = $this->mantenedor_model->listarColaboradores();

		$vista ="mantenedor/centroCostos";
		if($IDUSER!=""){
			
			$user = $this->mantenedor_model->validarUSR_UID($IDUSER);
		    if(count($user)<=0){
		       header("location:".base_url()."mantenedor/centro-costos");
		    }
		    else{
		    	//si pasa la validacion cambia la viste a detale del usuario
		    	$data["borrarEstado"]  =0;
		    	$data["user"] = $user;
		    	$empresa = $this->input->post("input_empresa");
		    	if($empresa !=""){
		    		$data["input_empresa"] = $empresa;
		    		$data["input_rut"]     = $this->input->post("input_rut");
		    		$data["borrarCentros"] = $this->input->post("my_select");
		    		$data["activoBorrar"]  = $this->input->post("activoBorrar");
		    		
		    		if($data["activoBorrar"] =="SI"){
					   $data["borrarEstado"]  = $this->mantenedor_model->borrarCentorCostoByEmpresa($data);
					}

		    	    $data["rutCosto"]	   = $this->mantenedor_model->getRutCentroCostoByEmpresa($data);
		    	}
		    	$vista ="mantenedor/centroCostosUser";
			}
		}	

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view($vista,$data);
		$this->load->view('layout/footer',$data);
	}


	public function CargaMasiva($option=""){
		$this->validarLogin();

		$data = array();
		$data["directorio"]    = "Mantenedor";
		$data["SubDirectorio"] = "Centro costos";
		$data["estadoCarga"]   = array();
		$data["mensajeFinal"]  = 0;
        $this->load->model("mantenedor_model");
		$vista ="mantenedor/centroCostoCargaMasiva";

		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);
        
        if(isset($_FILES["file"]) && $option=="cargar"){

        	$file = $_FILES["file"]['tmp_name'];
            if($_FILES["file"]["size"] > 0){
				//load the excel library
				$this->load->library('excel');
				//read file from path
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				//get only the Cell Collection
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
				//extract to a PHP readable array format
				foreach($cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				 	$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				 	$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				 	//header will/should be in row 1 only. 
				 	if($row > 1){
				 	   $filas[$row][$column] = trim($data_value);
				 	}
				}
				if(isset($filas)){
					$data["estadoCarga"] =$this->mantenedor_model->CentroCostoValidarFilaExcel($filas);
					$vista ="mantenedor/ajax/tablaErroresCentroCostos";
					$this->load->view($vista,$data);
				}
			}            	
        }
        else if(isset($_FILES["file"]) && $option =="guardar"){
        	$file = $_FILES["file"]['tmp_name'];
        	if($_FILES["file"]["size"] > 0){
				//load the excel library
				$this->load->library('excel');
				//read file from path
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				//get only the Cell Collection
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
				//extract to a PHP readable array format
				foreach($cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				 	$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				 	$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				 	//header will/should be in row 1 only. 
				 	if($row > 1){
				 	   $filas[$row][$column] = trim($data_value);
				 	}
				}
				
				$data["mensajeFinal"] = $this->mantenedor_model->CentroCostoInsertarExcel($filas);

				$vista ="mantenedor/centroCostoCargaMasiva";
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('layout/notificacion',$data);
				$this->load->view($vista,$data);
				$this->load->view('layout/footer',$data);
			}      
        }
        else{

			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('layout/notificacion',$data);
			$this->load->view($vista,$data);
			$this->load->view('layout/footer',$data);
		}
	}
	////////////////////////////////////////////////////////////////////////
    ///////////////////////   PROVEEDORES  /////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    public function proveedores($view='', $opcion=''){
    	
    	$this->validarLogin();
    	$data = array();
		 
		$data["directorio"]    = "Mantenedor";
		$data["SubDirectorio"] = "Proveedores";
		
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);
		$vista ="proveedores";

		$this->load->model("mantenedor_model");

		if($view == ""){
     		$data["proveedores"] = $this->mantenedor_model->listarProveedores();
     	}
     	$data["cuentaSAP"] = array();
     	$data["emp_POST"]  = "";
     	
     	if($view=="nuevo"){
     		 
     		if(isset($_POST['sociedad'])){
     		$emp_POST = $_POST['sociedad'];
     		if($emp_POST !=""){
     		   $data["cuentaSAP"] = $this->mantenedor_model->cargarListaCuentaSap($emp_POST);
     		}}

			$vista ="proveedoresNuevo";
	
			if($opcion =="insert"){
			   
			   $new["RUT"]      = str_replace(".","", $this->input->post("RUT"));
		   	   $new["NOMBRE"]    = $this->input->post("NOMBRE");
		   	   $new["MAIL"]      = $this->input->post("MAIL");
		   	   $new["AGENCIA"]   = $this->input->post("AGENCIA");
		   	   $new["BANCO"]     = $this->input->post("BANCO");
		   	   $new["TIPO_P"]    = $this->input->post("TIPO_P");
		   	   $new["CUENTAS"]   = $this->input->post("CUENTAS");
		   	   $new["SOCIEDAD"]  = $this->input->post("SOCIEDAD");

		   	   $new["RECURRENTE"] = $this->input->post("RECURRENTE");
		   	   
		   	   $monto 			  = str_replace(",","", $this->input->post("MONTO_TOPE"));
		   	   $new["MONTO_TOPE"] = str_replace(".",",", $monto);


		   	   $data["resp_new"] = $this->mantenedor_model->insertProveedor($new);
		   	   echo json_encode($data["resp_new"]);
			}
			
			if($opcion =="validarSAP"){
				$new["RUT"]      = str_replace(".","", $this->input->post("RUT"));
				$new["SOCIEDAD"]  = $this->input->post("SOCIEDAD");
				$data["resp_new"] = $this->mantenedor_model->validaRUTSAP($new);
		   		echo json_encode($data["resp_new"]);
			}
		}

		

		if($view == "editar"){
		    $vista ="proveedoresEditar";
		    if($opcion!=""){
		       //separar la empresa del rut
		       $opcion = explode('_', $opcion);
		       $data["SOCIEDAD"] = $opcion[1];
		       $data["camposP"] = $this->mantenedor_model->getProveedorByRut($opcion[0],$opcion[1]);
		       $data["cuentaSAP"] = $this->mantenedor_model->cargarListaCuentaSap($data["SOCIEDAD"]);
		       if(count($data["camposP"])==0){
		       		header("location:".base_url()."mantenedor/proveedores");
		       }
		       else
		       {
		         $opcion ="";
		       }
		    }
		}


		if($view=="update"){
			if($opcion!=""){

				$old["RUT"]      = str_replace(".","", $this->input->post("RUT"));
		   		$old["NOMBRE"]   = $this->input->post("NOMBRE");
		   		$old["MAIL"]     = $this->input->post("MAIL");
		   		$old["AGENCIA"]  = $this->input->post("AGENCIA");
		   		$old["BANCO"]    = $this->input->post("BANCO");
		   		$old["TIPO_P"]   = $this->input->post("TIPO_P");
		   		$old["CUENTAS"]  = $this->input->post("CUENTAS");
		   		$old["SOCIEDAD"] = $this->input->post("SOCIEDAD");
		   		$old["ambasEMP"] = $this->input->post("ambasEMP");

		   		$old["RECURRENTE"] = $this->input->post("RECURRENTE");
		   	   
		   	    $monto 			  = str_replace(",","", $this->input->post("MONTO_TOPE"));
		   	    $old["MONTO_TOPE"] = str_replace(".",",", $monto);

		   		$data["resp_old"] = $this->mantenedor_model->UpdateProveedor($old);
		   		echo json_encode($data["resp_old"]);
			}

		}

		if($opcion==""){

			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('layout/notificacion',$data);
			$this->load->view('mantenedor/'.$vista,$data);
			$this->load->view('layout/footer',$data);
		}

    }

 	////////////////////////////////////////////////////////////////////////
    ///////////////////////CUENTAS CONTABLES////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
	public function cuentaContables($IDUSER=""){
		
		$this->validarLogin();

		$data = array();
		$data["directorio"]    ="Mantenedor";
		$data["SubDirectorio"] ="Cuentas contables";
		$data["input_empresa"] = "";
		$data["rutCuentas"]    = array();

		$this->load->model("mantenedor_model");
		$data["autorizadores"] = $this->mantenedor_model->listarAutorizadores();
		
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);

		$vista ="mantenedor/cuentaContables";
		if($IDUSER!=""){
			
			$user = $this->mantenedor_model->validarUSR_UID($IDUSER);
		    if(count($user)<=0){
		       header("location:".base_url()."mantenedor/cuentaContables");
		    }
		    else{
		    	//si pasa la validacion cambia la viste a detale del usuario
		    	$data["user"] = $user;
		    	$empresa = $this->input->post("input_empresa");
		    	if($empresa !=""){
		    		$data["input_empresa"] = $empresa;
		    		$data["input_rut"]     = $this->input->post("input_rut");
		    		$data["borrarCuentas"] = $this->input->post("my_select");
					//borrar cuenta contables si el select tienen dato
					$data["borrarEstado"]  = $this->mantenedor_model->borrarCuentasContablesByEmpresa($data);
					//lista cuenta contables despues de ser borrados
		    	    $data["rutCuentas"]	   = $this->mantenedor_model->getRutcuentaContablesEmpresa($data);
		    	}
		    	$vista ="mantenedor/ceuntaContablesUser";
			}
		}	

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view($vista,$data);
		$this->load->view('layout/footer',$data);
	}

	////////////////////////////////////////////////////////////////////////
    ///////////////////////Eliminar Caso////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
	public function eliminarCasos($option=""){
		
		$this->validarLogin();

		$data = array();
		$data["directorio"]    ="Mantenedor";
		$data["SubDirectorio"] ="Eliminar casos";

		$data["pagos"] 		    = "";
		$data["RUTPROV"] 	    = "";
		$data["PROCESO"] 	    = "";
		$data["SOCIEDAD"] 	    = "";
		
		$data["activoBusqueda"]    = 0;
		$data["activoEliminacion"] = 0;

		$data["rutCuentas"]    = array();
		
		$vista ="mantenedor/EliminarCasos";


		$this->load->model("mantenedor_model");
		$this->load->model('layout_modal');

		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);


		$hidden_busqueda = $this->input->post("hidden_busqueda");
		//echo $option; 
		if($option =="delete"){
		   $hidden_busqueda   		  = "1";
		   $data["activoEliminacion"] = 1;
		   $data['CASO_ID_HIDDEN']    = $this->input->post("CASO_ID_HIDDEN");
		   $data['SOCIEDA_HIDDEN']    = $this->input->post("SOCIEDA_HIDDEN");


		   $data['SOCIEDAD'] = $this->input->post("SOCIEDA_FORM");
		   $data['PROCESO']  = $this->input->post("CASO_ID_FORM");
		   $data['RUTPROV']  = $this->input->post("RUTPROV_FORM");

		   $this->mantenedor_model->deteleDTFiltro($data);
		   
		}

		if($hidden_busqueda =="1"){

			$data["activoBusqueda"]	 = 1;

			if($data["activoEliminacion"] ==0){
				$data['SOCIEDAD'] = $this->input->post("empresa");
				$data['PROCESO']  = $this->input->post("numeroCaso");
				$data['RUTPROV']  = $this->input->post("inputRut");
			}

			$data['pagos']    = $this->mantenedor_model->buscarDtFiltro($data);
		}

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view($vista,$data);
		$this->load->view('layout/footer',$data);
	}

	public function cuentas_cargaMasiva($option=""){
		$this->validarLogin();

		$data = array();
		$data["directorio"]    ="Mantenedor";
		$data["SubDirectorio"] ="Cuentas contables";
		$data["estadoCarga"]   = array();
		$data["mensajeFinal"]  = 0;
        $this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);
       
        $this->load->model("mantenedor_model");
		$vista ="mantenedor/cuentaContableCargaMasiva";
        
        if(isset($_FILES["file"]) && $option=="cargar"){

        	$file = $_FILES["file"]['tmp_name'];
            if($_FILES["file"]["size"] > 0){
				//load the excel library
				$this->load->library('excel');
				//read file from path
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				//get only the Cell Collection
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
				//extract to a PHP readable array format

				foreach($cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				 	$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				 	$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				 	//header will/should be in row 1 only. 
				 	if($row > 1){
				 	   $filas[$row][$column] = trim($data_value);
				 	}
				}
				if(isset($filas)){
					$data["estadoCarga"] =$this->mantenedor_model->CuentasContablesValidarFilaExcel($filas);
					$vista ="mantenedor/ajax/tablaErroresCuentasContables";
					$this->load->view($vista,$data);
				}
			}            	
        }
        else if(isset($_FILES["file"]) && $option =="guardar"){
        	$file = $_FILES["file"]['tmp_name'];
        	if($_FILES["file"]["size"] > 0){
				//load the excel library
				$this->load->library('excel');
				//read file from path
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				//get only the Cell Collection
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
				//extract to a PHP readable array format
				foreach($cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				 	$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				 	$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				 	//header will/should be in row 1 only. 
				 	if($row > 1){
				 	   $filas[$row][$column] = trim($data_value);
				 	}
				}
				
				$data["mensajeFinal"] = $this->mantenedor_model->CuentaContablesInsertarExcel($filas);

				$vista ="mantenedor/cuentaContableCargaMasiva";
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('layout/notificacion',$data);
				$this->load->view($vista,$data);
				$this->load->view('layout/footer',$data);
			}      
        }
        else{

			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('layout/notificacion',$data);
			$this->load->view($vista,$data);
			$this->load->view('layout/footer',$data);
		}
	}

	public function usuariosBpm($userUID = ''){
		$this->validarLogin();
		$data = array();
		$data["directorio"]    ="Mantenedor";
		$data["SubDirectorio"] ="Lista de usuarios BPM";
		$data["estadoCarga"]   = array();
		$data["mensajeFinal"]  = 0;
		
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);
		
		$vista = "mantenedor/usuariosBpm";
		$this->load->model("mantenedor_model");

		$data["usuarios"] = $this->mantenedor_model->getListaUsuarios();

	    if($userUID !=""){
		   	$user = $this->mantenedor_model->validarUSR_UID($userUID);
		    if(count($user)<=0){
               header("location:".base_url()."mantenedor/usuarios-bpm");
		    }
		    else
		    {
		    	
		    	$data['sustituto'] = array();
		    	$usuarios          = $data["usuarios"];
				$opcion = $this->input->post("input_hidden");
				if($opcion == 1){
					$data["nombre"]          = $this->input->post("nombre");
					$data["apellido"]        = $this->input->post("apellido");
					$data["correo"]          = $this->input->post("correo");
					$data["sustitucion"]     = $this->input->post("sustitucion");
					$data["USR_UID"]         = $user[0]->USR_UID;

					$data['mensajeFinal'] = $this->mantenedor_model->actualizar_usuario($data);
				   	$user = $this->mantenedor_model->validarUSR_UID($userUID);
				   	$data["usuarios"] = $this->mantenedor_model->getListaUsuarios();
				}
				if(count($usuarios)>0){
					foreach ($usuarios as $key => $value){
						if($value['USR_UID'] == $user[0]->USR_REPLACED_BY){
							$data['sustituto'][0] = $usuarios[$key];
							unset($usuarios[$key]);
						}
						$data["usuarios"] = array_values($usuarios);
					}
				}
				$data['user']  = $user;
			   	$vista = "mantenedor/usuariosBpmEdit"; 
	    	}
	    }
 

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view($vista,$data);
		$this->load->view('layout/footer',$data);
	}


	public function validarLogin(){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}
	}

	/**caragr las distribucion de costos para los mismo usuarios*/
	public function cargarDistribucion($input =''){
		//$this->validarLogin();

		$data = array();
		$data["directorio"]    ="Mantenedor";
		$data["SubDirectorio"] ="Cargar Distribucion";
		$this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);
		$vista  = 'cargarDistribucion';

		$data["getRUT"] = $input;

		if($input =='nuevo'){
		   $vista ='cargarDistribucionNuevo';
		}
		if($input =='editar'){
		   $vista ='cargarDistribucionEditar';
		}

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('mantenedor/'.$vista,$data);
		$this->load->view('layout/footer',$data);

	}
}