<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class consulta_pagos extends CI_Model {

public function __construct()
	{
		parent::__construct();
		
	}	

	public function get_caso_APP_UID($APP_UID){
		$this->db->select('*');
        $this->db->from('application');
        $this->db->where('APP_UID',$APP_UID);
        $query     = $this->db->get();
		$data      = $query->result_array();
		return $data;

	}
   	public function GettareaExpiradas($formAutorizador =""){

   		$TASK_JEFE  = "53973388657cc76ee0ed137014024224";
	    $TASK_SUB   = "465606689573a03ddcab550037948701";
		$TASK_GER   = "415374755572a27a1326b19024013712";
	    $TASK_GF    = "855712890572a27a132e818051933712";
	    $TASK_GG    = "524444580572a27a1336516042457995";
		//buscar casos expirados inlci jefe sub gerente , gerente area
	    $sql ="SELECT * from users as u where USR_UID ='nada'";
		

	    if($formAutorizador!=""){
	    	$sql  =  "SELECT u.* , ca.DEL_DELEGATE_DATE , ca.DEL_TASK_DUE_DATE , ca.APP_NUMBER , app.APP_DATA , app.APP_UID , ca.DEL_INDEX , ca.TAS_UID
				  FROM app_cache_view as ca 
				  INNER JOIN users as u         ON ca.USR_UID    = u.USR_UID
				  INNER JOIN application as app ON ca.APP_NUMBER = app.APP_NUMBER
		          WHERE ca.APP_STATUS ='TO_DO' and ca.DEL_THREAD_STATUS ='OPEN' 
		          AND   u.USR_UID     ='".$formAutorizador."'
		          AND   ca.TAS_UID in('".$TASK_JEFE."','".$TASK_SUB."','".$TASK_GER."','".$TASK_GF."','".$TASK_GG."')  group BY ca.APP_NUMBER";
	    }
	    else
	    {
	    	$sql  =  "SELECT u.* , ca.DEL_DELEGATE_DATE , ca.DEL_TASK_DUE_DATE , ca.APP_NUMBER , app.APP_DATA , app.APP_UID , ca.DEL_INDEX , ca.TAS_UID
				  FROM app_cache_view as ca 
				  INNER JOIN users as u         ON ca.USR_UID    = u.USR_UID
				  INNER JOIN application as app ON ca.APP_NUMBER = app.APP_NUMBER
		          WHERE ca.APP_STATUS ='TO_DO' and ca.DEL_THREAD_STATUS ='OPEN' 
		          AND   ca.TAS_UID in('".$TASK_JEFE."','".$TASK_SUB."','".$TASK_GER."','".$TASK_GF."','".$TASK_GG."')  group BY ca.APP_NUMBER";
	    }
	    
	    $query  = $this->db->query($sql);
	    $casos  = $query->result_array();

	    $atrasos = array();
	    if(count($casos)>0){

	    	$i =0;
	    	foreach($casos as $key => $v){

	    		//obtenida los casos atrasados debemos cruzar la informacion con laba bpm_log_job_reemplazos para obtenre al usuario original del caso y el usuario de remplazo que se pueda escojer por que tabla cache_view es solo una vista de lo que se actualiza en la delegacion
	    		$sql_re    ="SELECT * FROM bpm_log_job_reemplazos WHERE APP_UID ='".$v['APP_UID']."' 
	    		            AND DEL_INDEX ='".$v["DEL_INDEX"]."'";
	    		$query_re  = $this->db->query($sql_re);
	    		$rs_re     = $query_re->result_array();	
	    		$bloqueo =0;
	    		$v['FECHA_BLOQUEO'] = "";
	    		if(count($rs_re)>0){
	    			//print_r($rs_re);
	    			if($rs_re[0]['USER_ORIGINAL'] !=""){
	    			   $v['USR_UID']         = $rs_re[0]['USER_ORIGINAL'];
	    			}
	    			if($rs_re[0]['USER_REEMPLAZO'] !=""){
	    			   $v['USR_REPLACED_BY'] = $rs_re[0]['USER_REEMPLAZO'];
	    			}

	    			if($rs_re[0]['FECHA_BLOQUEO'] == date('Y-m-d') ){
	    			   $bloqueo = 1;
	    			}

	    			$v['FECHA_BLOQUEO'] = $rs_re[0]['FECHA_BLOQUEO'];
	    		}

	    		$A1 = date("d-m-Y"); 
	    		$B2 = date("d-m-Y",strtotime($v["DEL_TASK_DUE_DATE"]));
	    		
	    		$v["DEL_DELEGATE_DATE"] =$A1;
	    		$v["DEL_TASK_DUE_DATE"] =$B2;

    			$inicio = new DateTime($A1);
				$termino = new DateTime($B2);

				$fecha = $inicio->diff($termino);
	    		//if($A1 > $B2){
	    			//echo "<br>".$A1." ".$B2;
	    			$user    = $this->CP_get_bpm_user_by_id($v['USR_UID']);
	    			$remp    = $this->CP_get_bpm_user_by_id($v['USR_REPLACED_BY']);
					$actual  = $this->buscarUltimaDelegacion($v['APP_UID']);

					$userFinal = array();
					if(count($actual)>0){
						$userFinal = $this->CP_get_bpm_user_by_id($actual['USR_UID']);
					}

	    			$atrasos[$i] =$v;
	    			$atrasos[$i]['USER_ORIGINAL'] = $user;
	    			$atrasos[$i]['USR_UID']       = $v['USR_UID'];
	    			$atrasos[$i]['USER_REMPLAZO'] = $remp;
	    			$atrasos[$i]['USER_ACTUAL']   = $userFinal;
	    			$atrasos[$i]['DIAS_ATRASO']   = $fecha->days;
	    			$atrasos[$i]['APP_DATA']      = unserialize($v["APP_DATA"]);
	    			$atrasos[$i]['BLOQUEO']       = $bloqueo;
    				$i++;
	    		//}
	    	}
	    }
		return $atrasos;
   	}

    public  function getVariableConfig($value =''){
    	$query = $this->db->query("SELECT VALOR from bpm_config where VARIABLE ='".$value."'");
    	$row   = $query->row_array();
    	return $row;
    }

    public function buscarUltimaDelegacion($APP_UID){
    	$sql   ="SELECT * FROM app_delegation 
    		     WHERE APP_UID ='".$APP_UID."' 
    		     AND   DEL_THREAD_STATUS ='OPEN'";
        $query = $this->db->query($sql);
        $row   = $query->row_array();
    	return $row;
    }

    public function UpdateTareaExpirada($data){
    	$respuesta = array();
    	$movido    = false;
    	$respuesta["ENVIADO"] = false;

    	if($data['TODOS']=="SI"){
    		//cambiar el reemplazo de manera definitiva 
			$this->db->set('USR_REPLACED_BY' , $data["ID_REM"]);
			$this->db->where('USR_UID'       , $data["ID_ORI"]);
			$estado = $this->db->update('users');
			//buscar todos los casos atrasados del usuario origal
			if($estado){
				$atrasos = $this->casosAtrasadosByUSer($data["ID_ORI"]);
				if(count($atrasos)>0){
					//actulizar la delgacion para que el caso aparezca en al bandeja de entradad de reemplazo
					foreach($atrasos as $key => $value){
						$movido = false;
						
						$input["NUMERO_CASO"]      = $value["APP_NUMBER"];
						$input["APP_UID"]          = $value["APP_UID"];
						$input["TASK_UID"]         = $value["TAS_UID"];
						$input["DEL_INDEX"]        = $value["DEL_INDEX"];
						$input["USER_ORIGINAL"]    = $data["ID_ORI"];
						$input["USER_REEMPLAZO"]   = $data["ID_REM"];
						$input["USER_ACTUAL"]      = $data["ID_REM"];
						$input["FECHA_BLOQUEO"]    = date('Y-m-d');//bloque actualixacion 2 veces en eldia
						$input["FECHA_CREATE"]     = date('Y-m-d H:i:s');
						$input["ORIGEN"]           = "MANTENEDOR TAREAS EXPIRADAS";
						$input["COMENTARIOS"]      = "";
						$input["RESPONSE_SQL"]     = "";
						$respuesta["CASOS"][$key]  = unserialize($value["APP_DATA"]);
						$movido = $this->saveRegJobReemplazo($input);

						if($movido){
							$this->db->set('USR_UID'             , $data["ID_REM"]); //cambia al id 
							$this->db->where('DEL_INDEX'         , $value["DEL_INDEX"]);
							$this->db->where('APP_UID'           , $value["APP_UID"]);
							$this->db->where('DEL_THREAD_STATUS' , 'OPEN');
							$updateQ = $this->db->update('app_delegation');
							$respuesta["ENVIADO"] = $updateQ;
						}
					}
				}
			}
    	}
    	//cambiar solo el usuario que posse la tarea ebn un caos expecifico
    	if($data['TODOS']=="NO"){
    		
    		$input["NUMERO_CASO"]    = $data["APP_NUMBER"];
			$input["APP_UID"]        = $data["APP_UID"];
			$input["TASK_UID"]       = $data["TAS_UID"];
			$input["DEL_INDEX"]      = $data["DEL_INDEX"];
			$input["USER_ORIGINAL"]  = $data["ID_ORI"];
			$input["USER_REEMPLAZO"] = $data["ID_REM"];
			$input["USER_ACTUAL"]    = $data["ID_REM"];
			$input["FECHA_BLOQUEO"]  = date('Y-m-d');//bloque actualixacion 2 veces en eldia
			$input["FECHA_CREATE"]   = date('Y-m-d H:i:s');
			$input["ORIGEN"]         = "MANTENEDOR TAREAS EXPIRADAS";
			$input["COMENTARIOS"]    = "";
			$input["RESPONSE_SQL"]   = "";

			$caso =	$this->get_caso_APP_UID($data["APP_UID"]);
			$respuesta["CASOS"][0]  = unserialize($caso[0]['APP_DATA']);
	    	//buscar si los caso existe en caso contarios sde graba
			$this->saveRegJobReemplazo($input);
    		$this->db->set('USR_UID'             , $data["ID_REM"]); //cambia al id remplazo
			$this->db->where('APP_UID'           , $data["APP_UID"]);
			$this->db->where('DEL_THREAD_STATUS' , 'OPEN');
			$respuesta["ENVIADO"] = $this->db->update('app_delegation');
    	}

		$respuesta["REMPLAZO"]  = $this->CP_get_bpm_user_by_id($data["ID_REM"]);
	    $respuesta["ORIGINAL"]  = $this->CP_get_bpm_user_by_id($data["ID_ORI"]);

    	return $respuesta;
    }

  	//buscar si los caso existe en caso contarios sde graba
    public function saveRegJobReemplazo($data= array()){
    	
    	if(count($data)>0){
    		$this->db->select('*');
	        $this->db->from('bpm_log_job_reemplazos');
	        $this->db->where('APP_UID'  , $data['APP_UID']);
	        $this->db->where('DEL_INDEX', $data['DEL_INDEX']);
	        $this->db->where('TASK_UID'  , $data['TASK_UID']);
	        $query = $this->db->get();
			$rs    = $query->result_array();
			if(count($rs)>0){
				//actualizar
				echo "actualizar";
				$this->db->where('APP_UID'  , $data['APP_UID']);
	        	$this->db->where('DEL_INDEX', $data['DEL_INDEX']);
	        	$this->db->where('TASK_UID' , $data['TASK_UID']);
				$this->db->update('bpm_log_job_reemplazos',$data);
			}
			else
			{
				//insertar
				echo "INSERTAR";
				$this->db->insert("bpm_log_job_reemplazos",$data);
			}
			return true;
    	}
    }

    public function casosAtrasadosByUSer($USR_UID){
    	
    	$sql   ="SELECT u.* , ca.DEL_DELEGATE_DATE,ca.DEL_TASK_DUE_DATE,ca.APP_NUMBER,app.APP_UID ,ca.DEL_INDEX , ca.TAS_UID , app.APP_DATA
				 FROM app_cache_view as ca 
				 INNER JOIN users as u         ON ca.USR_UID    = u.USR_UID
				 INNER JOIN application as app ON ca.APP_NUMBER = app.APP_NUMBER
		         WHERE ca.APP_STATUS ='TO_DO'  and ca.DEL_THREAD_STATUS ='OPEN' 
		         AND u.USR_UID = '".$USR_UID."'
		         group BY ca.APP_NUMBER";
		$query   = $this->db->query($sql);
        $row     = $query->result_array();
        $atrasos = array();

        if(count($row)>0){
        	foreach ($row as $key => $value){
        		echo $value["DEL_DELEGATE_DATE"];
        		$A1 = date("d-m-Y"); 
	    		$B2 = date("d-m-Y",strtotime($value["DEL_TASK_DUE_DATE"]));
	    		
	    		$value["DEL_DELEGATE_DATE"] =$A1;
	    		$value["DEL_TASK_DUE_DATE"] =$B2;

    			$inicio  = new DateTime($A1);
				$termino = new DateTime($B2);
				$fecha   = $inicio->diff($termino);
				//fecha de inicio a mayor a termino
	    		//if($A1 > $B2){
	    		$atrasos[] =$value;
        		//}
        	}
        }
        return $atrasos;
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

		    
		    	$opciones["inputRut"] = str_replace(".","",$opciones["inputRut"]);
		
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
		        echo "</pre>";*/
				
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
	public function GetAutorizadores(){

		$sql = "SELECT * FROM bpm_autorizadores as au 
				INNER JOIN 	bpm_rut_users as ru on au.RUT = ru.RUT 
				group by au.RUT order by au.NOMBRE";

		$query = $this->db->query($sql);
    	$filas   = $query->result_array();
    	return $filas;	
	}

    public function CP_get_bpm_user_by_id($sessionID){
		$this->db->select('*');
        $this->db->from('users');
        $this->db->where('USR_UID',$sessionID);
        $query     = $this->db->get();
		$data      = $query->result_array();
		return $data;

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

