<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class contabilidad_model extends CI_Model {

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

	public function get_bpm_user_by_id($sessionID){
		$this->db->select('*');
        $this->db->from('users');
        $this->db->where('USR_UID',$sessionID);
        $query     = $this->db->get();
		$data      = $query->result_array();
		return $data;

	}

	public function buscarTaskPorNombre($task){
		$this->db->select('*');
        $this->db->from('content');
        $this->db->where('CON_VALUE',$task);
        $query     = $this->db->get();
		$data      = $query->result_array();
		return $data;
	}

	public function buscarDelegacionByTaks($TAS_UID){
		$sql   ="SELECT app.* , a.* FROM app_delegation as app INNER JOIN application as a on app.APP_UID = a.APP_UID  WHERE app.TAS_UID='".$TAS_UID."' AND app.DEL_THREAD_STATUS = 'CLOSED' GROUP BY a.APP_NUMBER";
        $grupo = $this->db->query($sql);
		$data  = $grupo->result_array();
		return $data;
	}

	public function buscarApplicacionByUIAPP($APP_UID){
		$this->db->select('*');
        $this->db->from('application');
        $this->db->where('APP_UID',$APP_UID);
        $this->db->group_by('APP_NUMBER');
        $query     = $this->db->get();
		$data      = $query->result_array();
		return $data;
	}


	public function buscarHistorialcaso($opciones){
		
		$fecha ="2017-05-18";

		$SQL_U = "SELECT * FROM bpm_job_contabilidad as job INNER JOIN application as app 
          on job.pm_uid_app = app.APP_UID 
          WHERE job.pm_accion  = '".$opciones."' 
                AND job.pm_next_user = '".$_SESSION['USR_LOGGED']."' 
                ";
		$rs   = $this->db->query($SQL_U);
		$casos = $rs->result_array();	

		$data =array();
		if(count($casos)>0){
			foreach ($casos as $key => $value){
				//$res       = $this->buscarApplicacionByUIAPP($value["APP_UID"]);
				$appTable  = unserialize($value["APP_DATA"]);
				//buscar opcion seleccionaa
				if(count($appTable)>0){
					$data[$key]["ESTADO"]      = $opciones;
					$data[$key]["NUMERO_CASO"] = $value["APP_NUMBER"];
					$data[$key]["COMENTARIOS"] = $value["pm_comentarios"];
					$data[$key]["EMPRESA"]     = "";
					
					if(isset($appTable["c008"])){
						
						$data[$key]["EMPRESA"] =$appTable["c008"];
					}
					
					$data[$key]["FECHA"]       = substr($value["pm_fecha"], 0, 10);
					$data[$key]["RESPONDIDO"]  = $this->get_bpm_user_by_id($value['pm_next_user']);
				}
			}
		}
		return $data;
	}

	public function send_permisos_lecturaFTP(){
		$cmd = 'c:\permisosFTP.bat';
		shell_exec($cmd);
	}

	public function GetTodoCase()
	{
		error_reporting(0);
		//se ejecuta cada vez que contabilidad carga la aplicacion 
		$this->send_permisos_lecturaFTP();

		$user = $this->get_bpm_user_by_id($_SESSION['USR_LOGGED']);
		
		$Sql_grupo ="SELECT C.CON_VALUE as grupo , U.USR_UID, U.USR_USERNAME FROM (USERS U LEFT JOIN GROUP_USER GU 	ON U.USR_UID=GU.USR_UID) LEFT JOIN CONTENT C ON GU.GRP_UID=C.CON_ID WHERE U.USR_UID = '".$_SESSION['USR_LOGGED']."'";
		$grupo  = $this->db->query($Sql_grupo);
		$grupo  = $grupo->result_array();

		if($grupo[0]['grupo'] =="G07 - Contabilidad CL01"){
		   $grupoC ="CL01";
		}
		else
		{
		   $grupoC ="CL24";
		}

		$sql ="SELECT * FROM app_delegation as DE WHERE DE.TAS_UID ='387847900572a27a1317102050304344' AND DE.DEL_THREAD_STATUS ='OPEN' group by APP_UID";

		$query   = $this->db->query($sql);
		$tareas  = $query->result_array();
		$casos   = array();

		if(count($tareas)>0){
			foreach ($tareas as $key => $value) {
				$AppSQL    = "SELECT * FROM application where APP_UID ='".$value["APP_UID"]."'";
				$query     = $this->db->query($AppSQL);
				$appTable  = $query->result_array();
				$appTable  = unserialize($appTable[0]["APP_DATA"]);

				if($appTable["c008"] == $grupoC){

					//buscar usuario que tiene reclamado el caso
					$SQL_U    = "SELECT * FROM USERS where USR_UID ='".$value["USR_UID"]."'";
					$query_U  = $this->db->query($SQL_U);
					$USER_U   = $query_U->result_array();
					$array_U  = array();
					if(count($USER_U)>0){
						$array_U = $USER_U;
					}


					$casos[$key] = $value;
					$casos[$key]["caso"] 		= $appTable["numero_caso"];
					$casos[$key]["num_dt"] 		= $appTable["c024"];
					$casos[$key]["fecha"] 		= $appTable["c025"];
					$casos[$key]["Proveedor"] 	= $appTable["c009"]." ".$appTable["c010"];
					$casos[$key]["Solicitante"] = $appTable["c006"];
					
					$casos[$key]["empresa"] 		= $appTable["c008"];
					$casos[$key]["rut"]    			= $appTable["c009"];
					$casos[$key]["numero_DT"]       = $appTable["c024"];
					$casos[$key]["FORMA_PAGO"]      = "";//$appTable["forma_pago"];
					$casos[$key]["PRONTO_PAGO"]     = 'NO';
					$casos[$key]["ACTIVO_NOTICACION"]  = 'NO';

					$casos[$key]["DELEGADO_A"]      = $array_U;
					if($appTable["c054"] =="ON" || $appTable["c054"] =="On" || $appTable["c054"] =="on"){
					   $casos[$key]["PRONTO_PAGO"]    = 'SI';
					   $casos[$key]["ACTIVO_NOTICACION"] = 'SI';
					}
				}
			}
		}
		return $casos;
	}

	public function GetDocumentoAnexos($id_proceso){
		$PM_SERVER = $this->get_bpm_config("IP");
		
		$sql ="SELECT doc.*, app.APP_NUMBER , doc.APP_DOC_UID FROM app_document as doc , application as app where app.APP_NUMBER = '".$id_proceso."' and app.APP_UID =doc.APP_UID and doc.APP_DOC_FIELDNAME <> 'c037'";
		$query  = $this->db->query($sql);

		$rw  = $query->result_array();
		$url = array();

		if(count($rw)>0){

			foreach ($rw as $key => $value) {
	            $url[$key]["input"]    = "http://".$PM_SERVER.":8000/".$value['APP_UID']."/".$value['APP_DOC_UID']."_1.pdf";
			}
		}
		//$url["doc"]   ="ftp://172.31.100.80/10140991258cad78f6668f8068104465/36724853558cad83bbaf654076502768_1.pdf";

		//echo $url[$key]["input"];
		return $url;
	}

	

	public function GetDocumentoManual($id_proceso){
		$PM_SERVER = $this->get_bpm_config("IP");
		
		$sql ="SELECT doc.*, app.APP_NUMBER , doc.APP_DOC_UID FROM app_document as doc , application as app where app.APP_NUMBER = '".$id_proceso."' and app.APP_UID =doc.APP_UID and doc.APP_DOC_FIELDNAME ='c037' order by DEL_INDEX DESC";
		$query  = $this->db->query($sql);
		$rw = $query->row_array();
		$url =array();

		if(count($rw)>0){
		   $url["doc"]="http://".$PM_SERVER.":8000/".$rw['APP_UID']."/".$rw['APP_DOC_UID']."_1.pdf";
		}
		
		//echo  $url["doc"];
		return $url;
	}

	public function setChmod($file){
		// set up basic connection
		$PM_SERVER = $this->get_bpm_config("IP");

		$conecionFTP = ftp_connect($PM_SERVER) or die("No se pudo conectar a $ftp_server"); 


		$login = ftp_login($conecionFTP, 'anonymous','');
		

		if (ftp_chmod($conecionFTP, 0755, $file) !== false) {
 			echo "$file chmoded successfully to 644\n";
		} 
		else 
		{
 			echo "could not chmod $file\n";
		}
	}

	public function GetDocumentoElectronico($data = array()){
		error_reporting(0);
		try {
			
			
			$PM_SERVER = $this->get_bpm_config("IP_WS");

			$opts = array(
						'http'=>array(
						'user_agent' => 'PHPSoapClient'
						)
					);
		    $context = stream_context_create($opts);
		    //echo "http://'.$PM_SERVER.'/WS00160_GetDTEs/WS00160_GetDTEs.asmx?WSDL";

		    //echo  "http://".$PM_SERVER."/WS00160_GetDTEs/WS00160_GetDTEs.asmx?WSDL";

		    $client1 = new SoapClient('http://'.$PM_SERVER.'/WS00160_GetDTEs/WS00160_GetDTEs.asmx?WSDL',
		                             array('stream_context' => $context,
	                                   'cache_wsdl' => WSDL_CACHE_NONE));

			
			$empresa      = $data["COD_EMPRESA"];
			$rutProveedor = $data["RUT_PROVEEDOR"];
			$numero_DT    = $data["NUMERO_DOCUMENTO"];
			

			$tipoDOC  = $data["TIPDOC"];
		    $tipoIMP  = $data["TIPIMP"]; 

		    if($tipoIMP =="M"){

		    	$tipoDOC ="";
		    	$tipoIMP ="";
		    }

			$search_query = new StdClass();
			$search_query->request = new StdClass();
			$search_query->request->holding      = "ISAPRES";
			$search_query->request->sociedad     = $empresa;
			$search_query->request->rutProveedor = $rutProveedor;
			$search_query->request->tipoDocto    = $tipoDOC;
			$search_query->request->tipoImpuesto = $tipoIMP;
			$search_query->request->nroDocto     = $numero_DT;

		    $result1 = $client1->getDTEs($search_query);
	    	$string  = $result1->getDTEsResult;
	      	$data    = json_decode(json_encode($string,true),true);


	        /*
	        echo "<pre>";
	      	print_r($search_query);
	      	echo "</pre>";
	      	*/


	      	/*echo "<pre>";
	      	print_r($data);
	      	echo "</pre>";
	      	*/

	      	$respuesta = array();
			if(isset($data['documentos']['DTE']['urlDoc'])){
				$respuesta[] = $data["documentos"]['DTE']['urlDoc'];
			}
			
			/*echo "<pre>";
			print_r($search_query);
			echo "</pre>";*/
			return $respuesta;

		} catch (Exception $e) {
			
		}
	}

	public function GetcasoByNumero($numCaso){
		$detalleCaso = array();
		$sql ="SELECT *  FROM `application` WHERE `APP_NUMBER` = '".$numCaso."'";
		$query = $this->db->query($sql);
		$json  = $query->result_array();
		$jsonA["data"] = unserialize($json[0]["APP_DATA"]);
		if(count($jsonA)>0){
			$casos = $jsonA;
		}
		return $casos;
	}

	public  function GetProvee_DT($sociedad,$ID_PROCESO){
		error_reporting(0);
		try {
		
			$SERVER = $this->get_bpm_config("IP_WS");
			$opts   = array
					(
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

			$response     = $servicio->GetProvee_DTResult;
			$data         = array();

			if(count($response->datos)>0){
				if(isset($response->datos->DatosResponse)){
					$data = (array)$response->datos->DatosResponse;

				}
			}
			return $data;

		}catch(Exception $e){
			
		}
	}
}
?>