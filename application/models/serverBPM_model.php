<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class serverBPM_model extends CI_Model {

public function __construct()
	{
		parent::__construct();
		
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
	public  function GetProvee_DT($sociedad='',$ID_PROCESO=''){

		error_reporting(0);
		try {
			
			$SERVER       = $this->get_bpm_config("IP_WS");
		
			$opts = array(
					'http'=>array(
					'user_agent' => 'PHPSoapClient'
					)
				);

		    $context = stream_context_create($opts);
		    $client1 = new SoapClient('http://'.$SERVER.'/WS00467_Provee_DT/Provee_DT.svc?wsdl',
		                             array('stream_context' => $context,
	                                   'cache_wsdl' => WSDL_CACHE_NONE));
			$search_query = new StdClass();
			$search_query->request = new StdClass();

			$search_query->request->codEmpresa  = $sociedad;
			$search_query->request->idProceso	= $ID_PROCESO;
			$servicio     = $client1->GetProvee_DT($search_query);


			//print_r($search_query);

			$response     = $servicio->GetProvee_DTResult;
			$data         = array();


			if(count($response->datos)>0){
				if(isset($response->datos->DatosResponse)){
					$data = (array)$response->datos->DatosResponse;
					$AppSQL    = "SELECT * FROM application where APP_NUMBER ='".$ID_PROCESO."'";
					$query     = $this->db->query($AppSQL);
					$appTable  = $query->result_array();
					$appTable  = unserialize($appTable[0]["APP_DATA"]);
					//$data["FORMA_PAGO"]     = $appTable["forma_pago"];
				}
			}
		
			return $data;

		} catch (Exception $e) {
			
		}
	}

	public  function get_bpm_preconprobante($proceso,$empresa)
	{
		
		$SERVER  = $this->get_bpm_config("IP_WS");
		//echo $SERVER;
		//$SERVER  = "192.168.6.169";
		//$empresa = "CL01";
		//$proceso = "357";

		try{

			$opts = array(
				'http'=>array(
				'user_agent' => 'PHPSoapClient'
				)
			);

	    	$context = stream_context_create($opts);
	    	$client1 = new SoapClient('http://'.$SERVER.'/WS00550_PreContabilidad/WS00550.svc?wsdl',
	                             array('stream_context' => $context,
                                   'cache_wsdl' => WSDL_CACHE_NONE));

			//$client1 = new SoapClient('http://'.$SERVER.'/WS00550_PreContabilidad/WS00550.svc?wsdl'); 
			$search_query = new StdClass();
			$search_query->empresa = $empresa;
			$search_query->proceso = $proceso;  //'205'
			$result1 = $client1->GeneraComprobante($search_query);
			$string  = $result1->GeneraComprobanteResult;
			$data 	 = json_decode(json_encode($string,true),true);
			$precon  = array();

			if(count($data)>0){
				$precon = $data["Comprobante"];
			}

			return $precon;
		}
		catch (Exception $e){
			//print_r($e->getMessage());
		}

		
	}

	public function get_bpm_distribucion($proceso,$empresa){
		error_reporting(0);
		
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

			$search_query->request->codEmpresa  = $empresa;
			$search_query->request->idProceso	= $proceso;
			$servicio  = $client1->GetProvee_DT_DIST($search_query);

			$response  = $servicio->GetProvee_DT_DISTResult;
			$data      = array();
			
			if(count($response->datos)>0){
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
	function update_delegarCaso($numeroCASO){

		$SQL_DCasos ="SELECT *  FROM `pmt_masivo` WHERE `APP_NUMBER` ='".$numeroCASO."'";
		//echo $SQL_DCasos;
		$query = $this->db->query($SQL_DCasos);
	    $DCasos  = $query->result_array();
		
		$caseId = $DCasos[0]['APP_UID'];

		$SQL_TASK = "SELECT CON_ID as TUID FROM `content` WHERE CON_VALUE LIKE 'T002 - Revisión Contabilidad' AND CON_CATEGORY='TAS_TITLE' AND CON_LANG='es'";
		$query     = $this->db->query($SQL_TASK);
		$UID_TASK  = $query->result_array();

		$sql = "SELECT * FROM APP_DELEGATION AD WHERE AD.DEL_THREAD_STATUS = 'OPEN' AND AD.APP_UID ='".$caseId."' AND AD.DEL_INDEX = (SELECT MAX(DEL_INDEX) FROM APP_DELEGATION WHERE APP_UID='".$caseId."')";
		$query     = $this->db->query($sql);
		$delega    = $query->result_array();
			

		$delegacion = array();
		$delegacion["UID_TASK"]   = "";
		$delegacion["APP_UID"]    = "";
		$delegacion["nextUser"]   = "";
		$delegacion["DEL_INDEX"]  = "";

		if(count($delega)>0 && $UID_TASK[0]['TUID'] == $delega[0]['TAS_UID']){

			$nextIndex = $delega[0]["DEL_INDEX"];
			$sqlUpDate ="UPDATE APP_DELEGATION  set USR_UID ='".$_SESSION["USR_LOGGED"]."' WHERE APP_UID = '".$caseId."' AND DEL_INDEX = '".$nextIndex."'";
			$query     = $this->db->query($sqlUpDate);
		

			$sql ="SELECT * FROM APP_DELEGATION AD WHERE AD.APP_UID = '".$caseId."' AND AD.DEL_INDEX = (SELECT MAX(DEL_INDEX) FROM APP_DELEGATION WHERE APP_UID='".$caseId."')";
			$query     = $this->db->query($sql);
			$delega    = $query->result_array();
			$nextUser  = $delega[0]["USR_UID"];

			$delegacion["UID_TASK"]   = $UID_TASK[0]['TUID'];
			$delegacion["APP_UID"]    = $DCasos[0]['APP_UID'];
			$delegacion["nextUser"]   = $nextUser;
			$delegacion["DEL_INDEX"]  = $delega[0]["DEL_INDEX"];
		}

		return $delegacion;
	}

	/*asiganr caso al usuario deseado usando en procesos de contabilidad*/
	function sendForceTriggerBpmContabilidad($numeroCASO ,$action , $sessionId , $comentarios, $nextUser,$caseId,$tuId,$nextIndex,$password){

		$sql_dele = "SELECT * FROM APP_DELEGATION AD WHERE TAS_UID = '".$tuId."' AND AD.DEL_THREAD_STATUS = 'OPEN' AND AD.APP_UID ='".$caseId."' AND AD.DEL_INDEX = (SELECT MAX(DEL_INDEX) FROM APP_DELEGATION WHERE APP_UID='".$caseId."')";
		$query     = $this->db->query($sql_dele);
		$delega    = $query->result_array();
		// si la tarea no ha sido delegada y correnponde a contabilidad avanzamos
		$response["estado"]    = null;
		$datos['pm_session']     = $sessionId;
		$datos['pm_uid_task']    = $tuId;
		$datos['pm_uid_app']     = $caseId;
		$datos['pm_caso']        = $numeroCASO;
		$datos['pm_accion']      = $action;
		$datos['pm_comentarios'] = $comentarios;
		$datos['pm_del_index']   = $nextIndex;
		$datos['pm_estado']      = "ERROR";
		$datos['pm_respuesta']   = "";
		$datos['pm_next_user']   = $nextUser;
		$datos['pm_next_user_password']   = $password;
		$datos['pm_fecha']       = date("Y-m-d H:i:s");

		//se debe quitar esta tarea de los caso pendiente en caso de error de procede de manera manual
		$OPEN["DEL_THREAD_STATUS"]= 'CLOSED';
		$this->db->where('APP_UID', $caseId);
		$this->db->where('TAS_UID', $tuId);
		$this->db->update('APP_DELEGATION', $OPEN);

		if(count($delega)>0){

			//buscar si el registro existe y actuzizar
			$this->db->select('*');
			$this->db->from('bpm_job_contabilidad');
			$this->db->where('pm_uid_app',$caseId);
			$this->db->where('pm_uid_task',$tuId);
			$this->db->where('pm_caso',$numeroCASO);
			$query     = $this->db->get();
			$existeCaso = $query->result_array();

			
			$datos['pm_estado']      = "PENDIENTE";
			$response["estado"]      = $action;

			if(count($existeCaso)>0){
				$this->db->where('pm_uid_app',$caseId);
				$this->db->where('pm_uid_task',$tuId);
				$this->db->where('pm_caso', $numeroCASO);
				$this->db->update('bpm_job_contabilidad', $datos);
			}
			else
			{
				/*insert el caso pendiente en la cola del job*/
				$this->db->insert('bpm_job_contabilidad',$datos);
			}
		}else{
			// se inserta en la table para restarara erro en la delegacion
			$this->db->insert('bpm_job_contabilidad',$datos);
		}
		return $response["estado"];
	}
}
?>