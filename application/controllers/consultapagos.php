<?php defined('BASEPATH') OR exit('No direct script access allowed');

class consultapagos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('PHPExcel.php');
	}

	public  function DelegacionCaso(){

		 $this->load->model('consulta_pagos');
		 $this->consulta_pagos->DelegacionCaso();	
	}
	
	public function index(){
		
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}
		$data = array();
		$data["directorio"]    = "Consultas";
		$data["SubDirectorio"] = "Consultas";
		
		$data["activoBusqueda"] = 0;
		$data["estadoPago"]     = "";
        $data["fechaPago"]      = "";
        $data["inputRut"]       = "";
        $data["empresa"]        = "";
        $data["FechaPagoInc"]   = "";
        $data["FechaPagoFin"]   = "";
        $data["FechaEmiInc"]    = "";
        $data["FechaEmiFin"]    = "";

        $data["pagos"]          = array();

        $this->load->model('layout_modal');
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);

		/*cargar consulta cuando usuario presion aceptar*/
		$okBusqueda =$this->input->post('hidden_busqueda');
		if($okBusqueda){
		   $this->load->model('consulta_pagos');
		   
		    $data["estadoPago"]   = $this->input->post("estadoPago");
		    $data["inputRut"]     = $this->input->post("inputRut");
		    $data["empresa"]      = $this->input->post("empresa");

		    $data["FechaPagoInc"]   = $this->input->post("FechaPagoInc");
        	$data["FechaPagoFin"]   = $this->input->post("FechaPagoFin");
        	$data["FechaEmiInc"]    = $this->input->post("FechaEmiInc");
        	$data["FechaEmiFin"]    = $this->input->post("FechaEmiFin");
		   
		   $data["setExcel"] = 0;

		   $pagos = $this->consulta_pagos->buscarPagos($data);	
           $data["pagos"] =$pagos;
           $data["activoBusqueda"] = $okBusqueda;
		}
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('consulta',$data);
		$this->load->view('layout/footer',$data);
	}

	public function validarLogin(){
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}else{
			header("location:".base_url()."consultapagos");
		}
	}

	//validar el inicio sesesion saltandose el doble logeo
	//cuando usario da clic en menu plugin
	public function loginBPM($ID_USER){
		$this->load->model('server_model');
        $this->server_model->validarUserBPM_MENU($ID_USER);	
        $this->validarLogin();
	}

	public function get_traza_proceso(){

		$this->load->model('consulta_pagos');
		$ID_PROCESO = $this->input->post("id_pro");
		$EMPRESA    = $this->input->post("cod_emp");
		$respuesta  = $this->consulta_pagos->get_traza_proceso($ID_PROCESO , $EMPRESA);	
		echo json_encode($respuesta);
	}

	public function setExcel() {

		$this->load->model('consulta_pagos');
		$opciones["estadoPago"] = $this->input->post("estadoPago");
		$opciones["inputRut"]   = $this->input->post("inputRut");
		$opciones["empresa"]    = $this->input->post("empresa");

		$opciones["FechaPagoInc"]   = $this->input->post("FechaPagoInc");
        $opciones["FechaPagoFin"]   = $this->input->post("FechaPagoFin");
        $opciones["FechaEmiInc"]    = $this->input->post("FechaEmiInc");
        $opciones["FechaEmiFin"]    = $this->input->post("FechaEmiFin");
		//opcion que habiolta el excel
		$opciones["setExcel"]  = 1;
		$pagos = $this->consulta_pagos->buscarPagos($opciones);	
		

	    // configuramos las propiedades del documento
	    $this->phpexcel->getProperties()->setCreator("ISAPRES")
	                                 ->setLastModifiedBy("ISAPRES")
	                                 ->setTitle("Office 2007 XLSX Document")
	                                 ->setSubject("Office 2007 XLSX Document")
	                                 ->setDescription("document for Office 2007 XLSX, generated ISAPRES")
	                                 ->setKeywords("office 2007 openxml php")
	                                 ->setCategory("file");
	     
	     
	    // agregamos información a las celdas
	    $this->phpexcel->setActiveSheetIndex(0)

	                ->setCellValue('A1','NÚM CASO')
                    ->setCellValue('B1','EMPRESA')
	                ->setCellValue('C1','RUT PROV')
	                ->setCellValue('D1','NOMBRE PROV')
	                ->setCellValue('E1','NRO DOC')
	                ->setCellValue('F1','DOC')
	                ->setCellValue('G1','SAP')
	                ->setCellValue('H1','ESTADO')
	                ->setCellValue('I1','SOLICITANTE')
	                ->setCellValue('J1','MONTO')
	                ->setCellValue('K1','V PAGO')
	                ->setCellValue('L1','BCO PRO')
	                ->setCellValue('M1','FECHA PAGO')
	                ->setCellValue('N1','FECHA PAGO SAP');

		$letras     = range("A","Z");
	    foreach ($letras as $key => $value) {
	    	$fila =2;

			    foreach($pagos as $ID => $p) {
			    	$estado ="";
			    	if(isset($p->estadoDt)){ $estado = $p->estadoDt;}
			    	$valorT =0;
			    	if(isset($p->valorTotal) && $p->valorTotal >0){
			    	   $valorT = "$".number_format($p->valorTotal,0, '','.');
			    	}

			    	$SOLICITANTE ="";
			    	if(isset($p->ingresador) && $p->ingresador!=""){
			    	   $SOLICITANTE = $p->ingresador;
			    	}

			    	$fechaP = new DateTime($p->fechaSolicitud);
		    		$fechaP = $fechaP->format('Y-m-d');

		    		$fechaPSAP = new DateTime($p->fechaAutoriza);
		    		$fechaPSAP = $fechaPSAP->format('Y-m-d');
	    			$this->phpexcel->setActiveSheetIndex(0)
	                	->setCellValue($letras[0].$fila, $p->idProceso)
	                	->setCellValue($letras[1].$fila, $p->codEmpresa)
	                	->setCellValue($letras[2].$fila, $p->rutProveedor)
	                	->setCellValue($letras[3].$fila, $p->nombreProveedor)
	                	->setCellValue($letras[4].$fila, $p->nroDt)
	                	->setCellValue($letras[5].$fila, $p->claseDocSap)
	                	->setCellValue($letras[6].$fila, $p->codComprobanteSap)
	                	->setCellValue($letras[7].$fila, $estado)
	                	->setCellValue($letras[8].$fila, $SOLICITANTE)
	                	->setCellValue($letras[9].$fila, $valorT)
	                	->setCellValue($letras[10].$fila, $p->totalDistrib)
	                	->setCellValue($letras[11].$fila, $p->porcDistrib)
	                	->setCellValue($letras[12].$fila, $fechaP)
	                	->setCellValue($letras[13].$fila, $fechaPSAP);
	                $fila++;
		    	}
	    	}
	    // Renombramos la hoja de trabajo
	    $this->phpexcel->getActiveSheet()->setTitle('Lista Pagos');
	    // configuramos el documento para que la hoja
	    // de trabajo número 0 sera la primera en mostrarse
	    // al abrir el documento
	    $this->phpexcel->setActiveSheetIndex(0);
	    // redireccionamos la salida al navegador del cliente (Excel2007)
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename="01simple.xlsx"');
	    header('Cache-Control: max-age=0');
	     
	    $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
	    $objWriter->save('php://output');
	}

	public function tareaExpiradas(){
		
		if(!isset($_SESSION["USR_LOGGED"])){
			header("location:".base_url()."login");
			exit;
		}

		$data = array();
		$data["directorio"]    ="Consultas";
		$data["SubDirectorio"] ="Tareas expiradas";
		$this->load->model('layout_modal');
		$data["tareasExpiradas"] =array();
		$data['menuSildebar'] = $this->layout_modal->buscar_modulosByUser($data);

		

		$formAutorizador 		 = $this->input->post('formAutorizador');
		$data['formAutorizador'] = $formAutorizador;

		$this->load->model('consulta_pagos');

		if($formAutorizador!=""){
		   $data["tareasExpiradas"] = $this->consulta_pagos->GettareaExpiradas($formAutorizador);
		}

		$data["autorizadores"]   = $this->consulta_pagos->GetAutorizadores();

		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('layout/notificacion',$data);
		$this->load->view('tareas/tareasExpiradas');
		$this->load->view('layout/footer',$data);
	}

	public function tareaExpiradasRemplazo(){
			$this->load->model('consulta_pagos');
			$userID    = $this->input->post("userID");
			$user      = $this->consulta_pagos->CP_get_bpm_user_by_id($userID);
			echo json_encode($user);
	}

	public function UpdateTareaExpirada(){

		$input['APP_UID']    = $this->input->post("APP_UID");
		$input['ID_REM']     = $this->input->post("ID_REM");
		$input['ID_ORI']     = $this->input->post("ID_ORI");
		$input['TODOS']      = $this->input->post("TODOS");
		
		$input['APP_NUMBER'] = $this->input->post("APP_NUMBER");
		$input['TAS_UID']    = $this->input->post("TAS_UID");
		$input['DEL_INDEX']  = $this->input->post("DEL_INDEX");
		$input['CORREO']     = $this->input->post("CORREO");
		
		$this->load->model('consulta_pagos');
		$rem =$this->consulta_pagos->UpdateTareaExpirada($input);

		$seUser =$this->consulta_pagos->CP_get_bpm_user_by_id($_SESSION['USR_LOGGED']);
			
		if($input["CORREO"]=="SI" && $rem["ENVIADO"] == true){
    		//cargamos la libreria email de ci
    		$this->lang->load('email_lang', 'spanish');
			$this->load->library("email");
			$configGmail = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_user' => 'gestion.procesos@cscbanmedica.cl',
				'smtp_pass' => 'cscbanmedica',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'newline' => "\r\n",
			);    
			
			//$this->email->clear();
			$this->email->initialize($configGmail);
			$this->email->from('gestion.procesos@cscbanmedica.cl');
			$this->email->to($rem['REMPLAZO'][0]['USR_EMAIL']);
			$this->email->cc($seUser[0]["USR_EMAIL"]);
			$this->email->subject('Gestión procesos Trancura (Usuarios de reemplazo)');
			$this->email->set_mailtype("html");
			$message ="";
			if(count($rem["CASOS"])>0){
				$message ="
			            <table border='1' cellpadding='0' cellspacing='0' width='100%'> 
			                <thead>
			                    <tr>
			                        <th>Caso N°</th>
			                        <th>Empresa</th>
			                        <th>Proveedor</th>
			                        <th>Tipo Documento</th>
			                        <th>Folio Doc</th>
			                        <th>Monto Total</th>
			                        <th>Fecha Pago</th>
			                    </tr>    
			                </thead>
			                <tbody>";
							foreach($rem["CASOS"] as $item) { 
							$prontoP ="NO";
							
							if(isset($item["c054"])){	
								if(trim($item['c054']=='On') || $item['C054'] =='On') {
									$prontoP ="YES";
								}
								else
								{
									$prontoP ="NO";
								}
							}

							$message .="<tr>
			                <td align='center' valign=top'>".$item['numero_caso']."</td>
			                <td align='center' valign=top'>".$item['c008']."</td>
			                <td align='center' valign=top'>".$item['c009']." ".$item['c010']."</td>
			                <td align='center' valign=top'>".$item['c021']."</td>
			                <td align='center' valign=top'>".$item['c024']."</td>
			                <td align='center' valign=top'>$".$item['c033']."</td>
			                <td align='center' valign=top'>".$item['c027']."</td>
			                </tr>";
			                } 
			                $message .= "</tbody>
			            </table>
			            <hr /> 
			            <a href='http://172.31.100.80:8080/sysworkflow/es/banmedica/processes/main'>
			            	ir al flujo
			            </a>     
			            <p>Este correo es generado automáticamente, favor no responder.</p>
			        </body>
			    </html>";
			}
			$this->email->message("Estimado(a): 
			".$rem["REMPLAZO"][0]['USR_FIRSTNAME']." ".$rem['REMPLAZO'][0]['USR_LASTNAME']."<br>Se le ha asigando la siguente lista de casos.<br>Procesos los cuales usted como el reemplazo de <b>".$rem['ORIGINAL'][0]['USR_FIRSTNAME']." ".$rem['ORIGINAL'][0]['USR_LASTNAME']."</b> debe validar o autorizar.</br></br>".$message);
			
			$this->email->send();
			var_dump($this->email->print_debugger());
    	}
		//echo json_encode($rem);
	}
}
?>