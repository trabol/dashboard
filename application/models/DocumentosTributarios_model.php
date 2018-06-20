<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocumentosTributarios_model extends CI_Model {
	private $db_PM;
	public function __construct()
	{
		parent::__construct();
		$this->db_PM = $this->load->database('workflow', TRUE); 
	}	
 	/*cargar la variables de configuracion del sistema*/
	public function get_bpm_config($VARIABLE){
		$this->db->select('*');
        $this->db->from('bpm_config');
        $this->db->where('VARIABLE',$VARIABLE);
        $query     = $this->db->get();
		$variables = $query->result_array();
		return $variables[0]['VALOR'];
	}


	public function buscar_documentos($data = array()){
		//habiltar lecturas a los nuevos documentos
		$this->send_permisos_lecturaFTP();

		$where ='';
		$rs    = array();
		$dt_documento =array();
		$where =' WHERE ID > 0';
		   $AND1 ='';
		   $AND2 ='';
		   $AND3 ='';

		if($data['inputDoc'] != "" || $data['inputRut'] !="" || $data['inputCaso']){

		   if($data['inputDoc'] != ""){
		   	  $AND1 = "AND NUMERO_DOCUMENTO ='".$data['inputDoc']."'";
		   }
		   if($data['inputRut'] != ""){
		   	  $AND2 = "AND RUT_PROVEEDOR ='".$data['inputRut']."'";
		   }
		   if($data['inputCaso'] != ""){
		   	  $AND3 = "AND ID_CASO ='".$data['inputCaso']."'";
		   }

		   // filtro  para order de compra 
		    if($data['inputTipo']==2){
				if($data['inputDoc'] != ""){
					$AND1 = "AND NUMERO_ORDEN ='".$data['inputDoc']."'";
				}
				if($data['inputRut'] != ""){
					$AND2 = "AND ID_PROVEEDOR ='".$data['inputRut']."'";
				}
				if($data['inputCaso'] != ""){
					$AND3 = "AND ID_CASO ='".$data['inputCaso']."'";
				}
		    }
		}

		if($data['inputTipo']==1){

			$sql_dt          = "SELECT * FROM `dt_documento` ".$where." ".$AND1." ".$AND2." ".$AND3." group by `ID_CASO` order by ID desc";
			$query_dt        = $this->db->query($sql_dt);
			$dt_documento    = $query_dt->result_array();
			if(count($dt_documento)>0){
			    foreach ($dt_documento as $key => $value){

			    	
			    	$sqlMAX = "SELECT * FROM dt_documento as dt , dt_historial_caso as H  WHERE dt.ID_CASO = H.ID_CASO AND
			  	   	dt.ID =(SELECT MAX(ID) FROM dt_documento WHERE ID_CASO ='".$value["ID_CASO"]."') and H.ID = (SELECT MAX(ID) FROM dt_historial_caso WHERE ID_CASO ='".$value['ID_CASO']."')";
			  	    $query  = $this->db->query($sqlMAX);
					$datos  = $query->result_array();	

		  	    	$rs['documento'][$key]['ID_CASO'] 		   = 'DT N° Caso '.$datos[0]["ID_CASO"];
		  	    	$rs['documento'][$key]['RUT_PROVEEDOR']    = $datos[0]["RUT_PROVEEDOR"];
		  	    	$rs['documento'][$key]['NOMBRE_PROVEEDOR'] = $datos[0]["NOMBRE_PROVEEDOR"];
		  	    	$rs['documento'][$key]['DT']               = $datos;	

		  	    	$rs['documento'][$key]['ORDEN']            = array();

		  	    	$sql_F_O  = "SELECT * FROM oc_documento  where NUMERO_ORDEN ='".$datos[0]['NUMERO_ORDEN_COMPRA']."' ORDER BY ID DESC LIMIT 1";
					$query_F_O = $this->db->query($sql_F_O);
					$rs_F_O    = $query_F_O->result_array();
					if(count($rs_F_O) >0){

						$rs['documento'][$key]['ORDEN'] = $rs_F_O[0];
						$sql_oc_es ="SELECT * FROM oc_historial_caso WHERE ID_CASO ='". $rs_F_O[0]['ID_CASO']."' ORDER BY ID DESC LIMIT 1";
						$query_oc_es = $this->db->query($sql_oc_es);
						$rs_oc_es    = $query_oc_es->result_array();

						$rs['documento'][$key]['ORDEN']['ID_ESTADO'] = $rs_oc_es[0]['ID_ESTADO'];
					}
		  	    }
		  	    $rs["rs_cant"] =0;
		  	    if(isset($dt_documento[0])){
		  	    	$rs["rs_cant"]     = count($dt_documento[0]);	
		  	    }
			}
		}
		/*echo "<pre>";
		print_r($rs['documento']);
		echo "<pre>";*/

		if($data['inputTipo'] ==2){

			$sql          = "SELECT * FROM oc_documento ".$where." ".$AND1." ".$AND2." ".$AND3." group by ID_CASO order by ID_CASO desc";
			$query        = $this->db->query($sql);
			$oc_documento = $query->result_array();

			if(count($oc_documento)>0){

		  	   foreach ($oc_documento as $key => $value) {
			  	   	$sqlMAX = "SELECT * FROM oc_documento as oc , oc_historial_caso as oh WHERE oc.ID_CASO = oh.ID_CASO AND oc.ID =(SELECT MAX(ID) FROM oc_documento WHERE ID_CASO ='".$value["ID_CASO"]."') AND oh.ID =(SELECT MAX(ID) FROM oc_historial_caso WHERE ID_CASO ='".$value['ID_CASO']."')";
			  	    $query  = $this->db->query($sqlMAX);
					$datos  = $query->result_array();

		  	    	$rs['documento'][$key]['ID_CASO']          = "OC N° Caso ".$datos[0]["ID_CASO"];
		  	    	$rs['documento'][$key]['RUT_PROVEEDOR']    = $datos[0]["ID_PROVEEDOR"];
		  	    	$rs['documento'][$key]['NOMBRE_PROVEEDOR'] = $datos[0]["NOMBRE_PROVEEDOR"];
		  	    	$rs['documento'][$key]['ORDEN']            = $datos[0];
		  	    	$rs['documento'][$key]['DT']      		   = array();

		  	    	$sql_F_O = "SELECT * FROM dt_documento  where  NUMERO_ORDEN_COMPRA ='".$datos[0]['NUMERO_ORDEN']."' GROUP BY ID_CASO";
					$query_F_O = $this->db->query($sql_F_O);
					$rs_F_O    = $query_F_O->result_array();
					$dt_anexos = array();
					if(count($rs_F_O) >0){
						//buscar ultima version documento
						foreach ($rs_F_O as $i => $v){
							$sql_dt_anexos = "SELECT * FROM dt_documento as dt , dt_historial_caso as H WHERE dt.ID_CASO = H.ID_CASO AND  dt.ID_CASO ='".$v['ID_CASO']."' AND dt.ID =(SELECT MAX(ID) FROM dt_documento WHERE ID_CASO ='".$v['ID_CASO']."') AND H.ID =(SELECT MAX(ID) FROM dt_historial_caso WHERE ID_CASO ='".$v['ID_CASO']."')";
							$query_anexos = $this->db->query($sql_dt_anexos);
							  $rs_anexo	   = $query_anexos->result_array();
							  //echo $sql_dt_anexos."<br>";
							  $dt_anexos[] = $rs_anexo[0];
						} 
						$rs['documento'][$key]['DT'] = $dt_anexos;
					}
		  	    }
		  	    $rs["rs_cant"]    = count($oc_documento[0]);
			}
		}
		return $rs;
	}

	public function buscar_traza_by_caso($ID_CASO,$TIPO_DOC){
		$data   = array();
		$OC   	= array();
		$empresa = "";

		$data['TIPO_VIEW'] =$TIPO_DOC;
		if($TIPO_DOC =='OC'){
  		   $sqlOC    = "SELECT * FROM oc_documento WHERE ID_CASO ='".$ID_CASO."' order by id desc limit 1";
  		   $queryOC  = $this->db->query($sqlOC);
		   $OC       = $queryOC->result_array();

		   $data['infoOC'] = $this->get_data_oc($OC[0]['NUMERO_ORDEN'],$OC[0]['ID_EMPRESA']);
		   $empresa        = $OC[0]['ID_EMPRESA'];
		}

		if($TIPO_DOC =='DT'){
		   $sqlDT    = "SELECT * FROM dt_documento WHERE ID_CASO ='".$ID_CASO."' order by ID desc limit 1";
  		   $queryDT  = $this->db->query($sqlDT);
		   $DT       = $queryDT->result_array();

		   $data['infoDT']     = $this->get_data_DT($DT);
		   $data['infoDT_DIS'] = $this->get_data_DT_distribucion($DT);
		   $empresa  = $DT[0]['ID_EMPRESA'];
		}

		$data["traza"] = $this->get_traza_proceso($ID_CASO,$empresa);

		if(count($data['traza'])>0){
			foreach ($data['traza'] as $key => $value){

				$sql_user   = "SELECT *  FROM `users` WHERE `USR_USERNAME` = '".$value['RUT']."'";
				$query_user = $this->db_PM->query($sql_user);
				$user       = $query_user->result_array();
				if(count($user)>0){
					$data["traza"][$key]['NOMBRE_AUTORIZA'] = $user[0]['USR_FIRSTNAME']." ".$user[0]['USR_LASTNAME'];
				}
			}
		}
		//buscar anexos del documento orden de compra
		$sql_app   = "SELECT * FROM APPLICATION WHERE APP_NUMBER = '".$ID_CASO."'";
		$query_app = $this->db_PM->query($sql_app);
		$app       = $query_app->result_array();
		$rs_doc =array();
		if(count($app)>0){
			$sql_doc = "SELECT *,  C.CON_ID AS fileId, C.CON_VALUE AS filename FROM APP_DOCUMENT AD, CONTENT C WHERE AD.APP_UID='".$app[0]['APP_UID']."' AND AD.APP_DOC_TYPE='INPUT' AND AD.APP_DOC_STATUS='ACTIVE' AND AD.APP_DOC_UID=C.CON_ID AND C.CON_CATEGORY='APP_DOC_FILENAME' AND C.CON_VALUE <> ''
			GROUP by C.CON_ID  ORDER BY AD.APP_DOC_CREATE_DATE DESC";
			$query_doc = $this->db_PM->query($sql_doc);
			$rs_doc    = $query_doc->result_array();
		}

		if(count($rs_doc)>0){
			$WS_MERGE_AUX_PDF    = $this->get_bpm_config("WS_MERGE_AUX_PDF");
			foreach ($rs_doc as $key => $v){
		       $url ='http://'.$WS_MERGE_AUX_PDF.'/'.$v['APP_UID'].'/'.$v['fileId'].'_1.pdf';
 		       $data["documentos"][] = $url;
            }
           
            if(isset($OC[0]['FILE_MERGE_URL']) && $OC[0]['FILE_MERGE_URL'] !=""){
            	unset($data["documentos"]);
            	$data["documentos"][0] = "http://".$OC[0]['FILE_MERGE_URL'];
            }
            
            if(isset($DT[0]['URL_FILE_MERGE']) && $DT[0]['URL_FILE_MERGE'] !=""){
            	unset($data["documentos"]);
            	$data["documentos"][0] = "http://".$DT[0]['URL_FILE_MERGE'];
            }
        }

		
		return $data;
	}

	public function get_data_DT($data =array()){
		try
    	{
    		$respuesta =array();
	    	$SERVER    = $this->get_bpm_config("IP_WS");
	    	//$SERVER["VALOR"] ="172.31.100.76";

		        $opts = array(
							'http'=>array(
							'user_agent' => 'PHPSoapClient'
							)
			);
			$context = stream_context_create($opts);
			$client1 = new SoapClient('http://'.$SERVER.'/WS00067_GetDTCSCSeg/WS00067_GetDTCSCSeg.asmx?wsdl',
			array('stream_context' => $context,
			'cache_wsdl' => WSDL_CACHE_NONE));
			$search_query = new StdClass();
			$search_query->request = new StdClass();
			
			if($data[0]["ID_TIPO_DOCUMENTO"]==1){
			   $data[0]["ID_TIPO_DOCUMENTO"] ='BO';
			}

			if($data[0]["ID_TIPO_DOCUMENTO"]==2){
			   $data[0]["ID_TIPO_DOCUMENTO"] ='FA';
			}

			if($data[0]["ID_TIPO_DOCUMENTO"]==3){
			   $data[0]["ID_TIPO_DOCUMENTO"] ='NC';
			}

			if($data[0]["ID_TIPO_DOCUMENTO"]==4){
			   $data[0]["ID_TIPO_DOCUMENTO"] ='ND';
			}

			$search_query->request->holding         = "ISAPRES";
			$search_query->request->conDistribucion ='C';
			$search_query->request->sociedad        =$data[0]["ID_EMPRESA"];
            $search_query->request->rutProveedor    =$data[0]["RUT_PROVEEDOR"];
            $search_query->request->nroDt           =$data[0]["NUMERO_DOCUMENTO"];
            $search_query->request->tipoDt          =$data[0]["ID_TIPO_DOCUMENTO"];
            $search_query->request->urgentePago     = "";
            $search_query->request->fechaVctoIni    = "";
            $search_query->request->fechaVctoFin    = "";
            $search_query->request->fechaDoctoIni   = "";
            $search_query->request->fechaDoctoFin   = "";
            $search_query->request->fechaAutIni     = "";

           

            $server    = $client1->getDTSeg($search_query);
		    $response  = $server->getDTSegResult;

	        if($response->error->cod_error == 0){
	           $respuesta = $response->documentos->DT;
	        }
	        return $respuesta;
		}catch (Exception $e){

		}
	}

	public function get_data_DT_distribucion($data =array()){
		
		try 
		{
			$distribucion  = array();
	        $SERVER    = $this->get_bpm_config("IP_WS");
	        $opts = array(
						'http'=>array(
						'user_agent' => 'PHPSoapClient'
						)
					);
		    $context = stream_context_create($opts);
		    $client1 = new SoapClient('http://'.$SERVER.'/WS00466_Provee_DT_DIST/Provee_DT_DIST.svc?wsdl',
		                             array('stream_context' => $context,
	                                   'cache_wsdl' => WSDL_CACHE_NONE));
			$search_query = new StdClass();
			$search_query->request = new StdClass();

			$search_query->request->codEmpresa  = $data[0]['ID_EMPRESA'];
			$search_query->request->idProceso	= $data[0]['ID_CASO'];
			$servicio  = $client1->GetProvee_DT_DIST($search_query);

			$response  = $servicio->GetProvee_DT_DISTResult;
			$data      = array();
			
			if(isset($response->datos->DatosResponse) && count($response->datos)>0){
				/*convertir dodo en array*/
				if(count($response->datos->DatosResponse)==1){
					$data[] = (array)$response->datos->DatosResponse;
				}else{
					foreach ($response->datos->DatosResponse as $key => $value) {
						$data[$key] = (array)$value;
					}
				}
			}
			
			return $data;

		}catch(Exception $e){
			
		}
	}

	public function send_permisos_lecturaFTP(){
		$cmd = 'c:\permisosFTP.bat';
		shell_exec($cmd);
	}

	public function get_data_oc($NUMERO_ORDEN,$EMPRESA){
		try
    	{
    		$respuesta =array();
	    	$SERVER    = $this->get_bpm_config("IP_WS");
	    	//$SERVER["VALOR"] ="172.31.100.76";

		        $opts = array(
							'http'=>array(
							'user_agent' => 'PHPSoapClient'
							)
			);
			$context = stream_context_create($opts);
			$client1 = new SoapClient('http://'.$SERVER.'/WS00022_GetOC/WS00022_GetOC.asmx?wsdl',
			array('stream_context' => $context,
			'cache_wsdl' => WSDL_CACHE_NONE));
			$search_query = new StdClass();
			$search_query->request = new StdClass();
			$search_query->request->sociedad = $EMPRESA;
			$search_query->request->nroOC    = $NUMERO_ORDEN;

			$server = $client1->getOC($search_query);
			$rs     = $server->getOCResult;

			if(isset($rs->error->cod_error) && $rs->error->cod_error ==0){
			   $respuesta = $rs->oc;
			}
			
			return  $respuesta;

		}catch (Exception $e){

 		}
	}
	

	public function get_traza_proceso($ID_PROCRESO,$EMPRESA){

    	try
    	{
	    	$SERVER    = $this->get_bpm_config("IP_WS");
	    	//$SERVER["VALOR"] ="172.31.100.76";

		        $opts = array(
							'http'=>array(
							'user_agent' => 'PHPSoapClient'
							)
			);
			$context = stream_context_create($opts);
			$client1 = new SoapClient('http://'.$SERVER.'/WS00468_Provee_DT_Traza/Provee_DT_Traza.svc?WSDL',
			array('stream_context' => $context,
			'cache_wsdl' => WSDL_CACHE_NONE));
			
			$search_query = new StdClass();
			$search_query->request = new StdClass();
			$search_query->request->codEmpresa  = $EMPRESA;
			$search_query->request->idProceso   = $ID_PROCRESO;

			
			$server = $client1->GetProvee_DT_Traza($search_query);
	        $rs     = $server->GetProvee_DT_TrazaResult;
	        
	        $respuesta = array();
	     	if(isset($rs->datos->DatosResponse)){

		        if(!is_array($rs->datos->DatosResponse)){
		        	$respuesta[] = $rs->datos->DatosResponse;
		        }else{

		        	$respuesta = $rs->datos->DatosResponse;
		        }
	    	}
	        $data = array();
	        if(count($respuesta)>0){
	        	$i=0;
	        	foreach($respuesta as $key => $value){

	        		$data[$i]["PROCRESO"]    = $respuesta[$key]->ID_PROCESO;
	        		$data[$i]["EMPRESA"]     = $respuesta[$key]->COD_EMPRESA;
	        		$data[$i]["RUT"]         = $respuesta[$key]->RUT_AUTORIZA;
	        		$data[$i]["ESTADO"]      = $respuesta[$key]->ESTADO_DT;
	        		$data[$i]["COMENTARIOS"] = $respuesta[$key]->OBSERVACION;
	        		$data[$i]["FECHA"] 	     = $respuesta[$key]->FECHA_PROCESO;
	        		$i++;
	        	}
	        }

			return $data;
		}
		catch (Exception $e){

 		}			
    }
}

/* End of file DocumentosTributarios_model.php */
/* Location: ./application/models/DocumentosTributarios_model.php */