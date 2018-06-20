<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class consulta_pagos extends CI_Model {

public function __construct()
	{
		parent::__construct();
		
	}	
   
    public  function getVariableConfig($value ='')
    {
    	$query = $this->db->query("SELECT VALOR from bpm_config where VARIABLE ='".$value."'");
    	$row   = $query->row_array();
    	return $row;

    }
    public function get_traza_proceso($ID_PROCRESO,$EMPRESA){

    	try
    	{
	    	$SERVER    = $this->getVariableConfig("IP_WS");
	    	//$SERVER["VALOR"] ="172.31.100.76";

		        $opts = array(
							'http'=>array(
							'user_agent' => 'PHPSoapClient'
							)
			);
			$context = stream_context_create($opts);
			$client1 = new SoapClient('http://'.$SERVER["VALOR"].'/WS00468_Provee_DT_Traza/Provee_DT_Traza.svc?WSDL',
			array('stream_context' => $context,
			'cache_wsdl' => WSDL_CACHE_NONE));
			
			$search_query = new StdClass();
			$search_query->request = new StdClass();
			$search_query->request->codEmpresa  = $EMPRESA;
			$search_query->request->idProceso   = $ID_PROCRESO;

			
			$server    = $client1->GetProvee_DT_Traza($search_query);
	        $rs  = $server->GetProvee_DT_TrazaResult;

	        //print_r($rs);
	        $respuesta = array();
	     	if(isset($rs->datos->DatosResponse)){

		        if(!is_array($rs->datos->DatosResponse)){
		        	$respuesta[] = $rs->datos->DatosResponse;
		        }else{

		        	$respuesta = $rs->datos->DatosResponse;
		        }
	    	}
	       
	        if(count($respuesta)>0){
	        	$i=0;
	        	foreach($respuesta as $key => $value){

	        		$data[$i]["PROCRESO"]    = $respuesta[$key]->ID_PROCESO;
	        		$data[$i]["EMPRESA"]     = $respuesta[$key]->COD_EMPRESA;
	        		$data[$i]["RUT"]         = $respuesta[$key]->RUT_AUTORIZA;
	        		$data[$i]["ESTADO"]      = $respuesta[$key]->ESTADO_DT;
	        		$data[$i]["COMENTARIOS"] = $respuesta[$key]->OBSERVACION;
	        		$data[$i]["FECHA"] 	  = $respuesta[$key]->FECHA_PROCESO;
	        		$i++;
	        	}
	        }
			return $respuesta;
		}catch (Exception $e){
 		}			
    }

 	public function buscarPagos($opciones =array()){
 		error_reporting(0);
 		
 		try {
 			
	 		if($opciones["estadoPago"]=="todos"){
	 		   $opciones["estadoPago"] ="";
	 		}
	 		if($opciones["FechaPagoInc"]!=""){
	 		   $fecha1 = explode("/",$opciones["FechaPagoInc"]);
	 		   $opciones["FechaPagoInc"] =$fecha1[2].$fecha1[1].$fecha1[0];
	 		}
	 		if($opciones["FechaPagoFin"]!=""){
	 		   $fecha2 = explode("/",$opciones["FechaPagoFin"]);
	 		   $opciones["FechaPagoFin"] =$fecha2[2].$fecha2[1].$fecha2[0];
	 		}
	 		else
	 		{
	 		   $opciones["FechaPagoFin"] = $opciones["FechaPagoInc"];
	 		}

	 		if($opciones["FechaEmiInc"]!=""){
	 		   $fecha3 = explode("/",$opciones["FechaEmiInc"]);
	 		   $opciones["FechaEmiInc"] =$fecha3[2].$fecha3[1].$fecha3[0];
	 		}
	 		if($opciones["FechaEmiFin"]!=""){
	 		   $fecha4 = explode("/",$opciones["FechaEmiFin"]);
	 		   $opciones["FechaEmiFin"] =$fecha4[2].$fecha4[1].$fecha4[0];
	 		}else{
	 			$opciones["FechaEmiFin"] =$opciones["FechaEmiInc"];
	 		}
			# Response Data Array
			$SERVER    = $this->getVariableConfig("IP_WS");
			$HOLDING   = $this->getVariableConfig("HOLDING");
			$SOCIEDAD  = $this->getVariableConfig("SOCIEDAD");
			$PM_SERVER = $this->getVariableConfig("PM_SERVER");
	        
	        //$SERVER["VALOR"] ="172.31.100.76";

		        $opts = array(
							'http'=>array(
							'user_agent' => 'PHPSoapClient'
							)
				);
				
		    //echo $SERVER["VALOR"];
		    $context = stream_context_create($opts);
		    $client1 = new SoapClient('http://'.$SERVER["VALOR"].'/WS00067_GetDTCSCSeg/WS00067_GetDTCSCSeg.asmx?WSDL',
		                             array('stream_context' => $context,
	                                   'cache_wsdl' => WSDL_CACHE_NONE));
		
				$search_query = new StdClass();
				$search_query->request = new StdClass();
				$search_query->request->holding         = $HOLDING["VALOR"];
				$search_query->request->conDistribucion = "";
				$search_query->request->sociedad        = $opciones["empresa"];
				$search_query->request->rutProveedor    = $opciones["inputRut"];
				$search_query->request->nroDt           = "";
				$search_query->request->tipoDt          = $opciones["estadoPago"];
				$search_query->request->urgentePago     = "";
				$search_query->request->fechaVctoIni    = $opciones["FechaPagoInc"];
				$search_query->request->fechaVctoFin    = $opciones["FechaPagoFin"];
				$search_query->request->fechaDoctoIni   = $opciones["FechaEmiInc"];
				$search_query->request->fechaDoctoFin   = $opciones["FechaEmiFin"];
				$search_query->request->fechaAutIni     = "";
				$search_query->request->fechaAutFin     = "";

		 		$server    = $client1->getDTSeg($search_query);
		        $response  = $server->getDTSegResult;

		        $respuesta = array();

		        if($response->error->cod_error == 0){
		           $respuesta = $response->documentos->DT;
		           if(count($respuesta)==1){
		           		$respuesta = (array)$response->documentos;
		           		$respuesta = array_values($respuesta);
		           }
		        }

		        /*echo "<pre>";
		        print_r($search_query);
		        echo "</pre>";
				*/
		        //buscar el peril del usuario para el modulo consulta =1 submodeulo conuslyta =1
		        $peril = $this->getPerfiUsuario($_SESSION['USR_LOGGED'],1,1);

		        if(isset($peril[0]['id_perfil'])){
		        	//perfil de consultos
		        	if($peril[0]['id_perfil']==2){
		        		if(count($respuesta)>0){
		        			foreach ($respuesta as $key => $value) {
		        				//codCuentaContable ==RUT ingresador
	        					if($value->codCuentaContable != $peril[0]["RUT"]){
	        						unset($respuesta[$key]);
	        					}
		        			}
		        			$respuesta = array_values($respuesta);
		        		}
		        	}
		        }
		       

		        if(count($respuesta)>0){
		        	//buscar el usuario que actualmente tiene el caso
		        	foreach ($respuesta as $key => $value) {
						$del ="SELECT * from application as app INNER JOIN app_delegation as del ON app.APP_UID = del.APP_UID INNER JOIN users as u on del.USR_UID = u.USR_UID WHERE app.APP_NUMBER =".$value->idProceso." order by del.DEL_INDEX DESC LIMIT 1";
						$query  = $this->db->query($del);
		    			$rs  = $query->row_array();
		    			if(count($rs)>0){
			    			$respuesta[$key]->usuarioActual = $rs["USR_FIRSTNAME"]." ".$rs["USR_LASTNAME"];
		    			}
	    			}
		        }
		       
 				//cuanso se expor a exel no buscamos los docuemnto  pdf	
 				//print_r($opciones);
		        if($opciones["setExcel"]==0){

		        	$opts = array(
							'http'=>array(
							'user_agent' => 'PHPSoapClient'
							)
				   );
				
				    //echo $SERVER["VALOR"];
				    $context = stream_context_create($opts);
				    $client1 = new SoapClient('http://'.$SERVER["VALOR"].'/WS00160_GetDTEs/WS00160_GetDTEs.asmx?WSDL',
				                             array('stream_context' => $context,
			                                   'cache_wsdl' => WSDL_CACHE_NONE));

			        //$client1 = new SoapClient('http://'.$SERVER['VALOR'].'/WS00160_GetDTEs/WS00160_GetDTEs.asmx?WSDL');
			        if(count($respuesta)>0){

			        	foreach ($respuesta as $key => $value){
			        		$data = array();
			        		$row  = array();

			        		//$id_proceso = explode("--",$respuesta[$key]->nombre_proveedor);
							$respuesta[$key]->nombre_proveedor = $value->nombreProveedor;
							$respuesta[$key]->numero_caso      = $value->idProceso;
							$rut_proveedor_2   = $value->rutProveedor;

							$respuesta[$key]->RUT = $value->rutProveedor;

							if($respuesta[$key]->estadoDt =="CO"){
								$respuesta[$key]->estado_dt ="Ingresado";
							}

			        		if(isset($value->idProceso) && $value->idProceso!=""){
			        			$sql ="SELECT doc.*, app.APP_NUMBER , doc.APP_DOC_UID FROM app_document as doc , application as app where app.APP_NUMBER = '".$value->idProceso."' and app.APP_UID =doc.APP_UID and doc.APP_DOC_FIELDNAME ='c037'";
				        		$query = $this->db->query($sql);
			    				$row[0] = $query->row_array();

			    				

			    				$USER_SQL ="SELECT u.* FROM users u INNER JOIN bpm_rut_users as bpm on u.USR_UID = bpm.USER_UID WHERE BPM.RUT ='".$value->codCuentaContable."'";

			    				$USER_RS   = $this->db->query($USER_SQL);
			    				$USER_RS   = $USER_RS->row_array();
			    				$respuesta[$key]->ingresador = $USER_RS["USR_FIRSTNAME"]." ".$USER_RS["USR_LASTNAME"];
			    		  	}
							$search_query = new StdClass();
							$search_query->request = new StdClass();
							$search_query->request->holding = "ISAPRES";
							$search_query->request->sociedad = $opciones["empresa"];
							$search_query->request->rutProveedor = $rut_proveedor_2;
							$search_query->request->tipoDocto = '';
							$search_query->request->tipoImpuesto = '';
							$search_query->request->nroDocto = $respuesta[$key]->nroDt;

						    $result1 = $client1->getDTEs($search_query);
					    	$string  = $result1->getDTEsResult;
					      	$data    = json_decode(json_encode($string,true),true);
			        		if(isset($data['documentos']['DTE']['urlDoc'])){
			        			$respuesta[$key]->urlFile = $data["documentos"]['DTE']['urlDoc'];

			        		}else if(isset($row[0]["APP_DOC_UID"])){
								//$scalar = new stdClass();
								$respuesta[$key]->urlFile = "http://".$PM_SERVER['VALOR']."/sysworkflow/en/neoclassic/cases/cases_ShowDocument?a=".$row[0]['APP_DOC_UID'];
			    			}
			        	}
			        }
		        }
		        else
		        {
		        	if(count($respuesta)>0){
			        	foreach ($respuesta as $key => $value){
			        		$data = array();
			        		$row  = array();


							$respuesta[$key]->nombre_proveedor = $value->nombreProveedor;
							$rut_proveedor_2      = $value->rutProveedor;
							$respuesta[$key]->RUT = $rut_proveedor_2;

						}
					}
		        }

		        
		      
		    return $respuesta;

	    }catch (Exception $e) {
 			
 		}

	}
	public function getPerfiUsuario($session, $modulo,$submodulo){
		$sql ="SELECT * FROM user_menu_modulos as menu INNER JOIN bpm_rut_users as u on menu.id_user = u.USER_UID WHERE menu.id_modulo = '1' AND menu.id_sud_modulo = '1' AND menu.id_user = '".$session."'";
		$query = $this->db->query($sql);
    	$row   = $query->result_array();
    	return $row;	
	}

	public function  DelegacionCaso(){
		
		ini_set('memory_limit', '1024M');
		$sql ="SELECT * FROM app_delegation as d inner join application as a on d.APP_UID =  a.APP_UID WHERE d.TAS_UID IN ('465606689573a03ddcab550037948701','53973388657cc76ee0ed137014024224') group by d.APP_UID";

		//echo $sql;
		$query = $this->db->query($sql);
	    $data  = $query->result_array();
	    $ar    = array();

	    if(count($data)>0){
	    	foreach ($data as $key => $value) {
	    		$s  = "SELECT *  FROM `bpm_rut_users` WHERE `USER_UID` LIKE '".$value["USR_UID"]."'";
	    		$q  = $this->db->query($s);
	    		
	    		$ar[$key] = $q->row_array();
	    		$ar[$key]["NUMERO_CASO"] = $value["APP_NUMBER"];
	    		//$ar["NUMERO"] = $value["APP_NUMBER"];
	    	}
	    }
	    echo json_encode($ar);
	    //echo "<pre>";
	    	//print_r($ar);
	    //echo "<pre>";
	}
}

