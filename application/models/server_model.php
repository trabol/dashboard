<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_model extends CI_Model {

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

	public function getGroupUserByid($userID =""){
		$sql ="SELECT C.CON_ID, C.CON_VALUE FROM CONTENT C, GROUP_USER GU, USERS U WHERE C.CON_ID=GU.GRP_UID AND U.USR_UID=GU.USR_UID AND U.USR_UID='".$userID."' group by C.CON_VALUE";

 		$query = $this->db->query($sql);
    	$row   = $query->row_array();
    	$respuesta = array();
    	if(count($row)>0){
    	   $respuesta = $row;
    	}
    	return $respuesta;
	}

	public function buscarUserPM($username){

		$query = $this->db->query("SELECT * from users where USR_USERNAME ='".$username."' limit 1");
    	$row   = $query->row_array();
    	$respuesta = array();
    	if(isset($row['USR_USERNAME'])){
    	   $respuesta = $row;
    	}
    	return $respuesta;
	}

	public function validarUserBPM_MENU($ID_USUARIO){

		$query = $this->db->query("SELECT * from user_menu_modulos as bpm INNER JOIN users as u on bpm.id_user = u.USR_UID where bpm.id_user ='".$ID_USUARIO."' limit 1");
    	$row   = $query->row_array();
    	$estado = false;
    	if(isset($row["id_user"])){
           $_SESSION["USR_LOGGED"]   = $row["id_user"];
           $_SESSION["SE_NOMBRE"]    = $row["USR_FIRSTNAME"];
           $_SESSION["SE_APELLIDO"]  = $row["USR_LASTNAME"];
           $_SESSION["USER_NAME"]    = $row['USR_USERNAME'];
           $estado = true;
    	}
    	return $estado;
	}
	
 	public function validarUserBPM($parametros = array()){
		# Response Data Array
		
		try
		{

			$PM_SERVER = $this->get_bpm_config('PM_SERVER');
			//$PM_SERVER = "172.31.100.78:8080";
			$resp = array();
			$client = new SoapClient("http://".$PM_SERVER."/sysworkflow/en/green/services/wsdl2?wsdl");
			//echo $PM_SERVER."<br>";
			//$pass = 'md5:' . md5($parametros["password"]);
			//echo $parametros["password"]."<br>";
			$params = array(array('userid'=>$parametros['username'], 'password'=>$parametros["password"]));
	 		$result = $client->__SoapCall('login', $params);
			$resp['submitted_data'] = $_POST;
			$login_status = 'invalid';
			//echo $result->status_code;
			if($result->status_code == '0')
			{
				$login_status = 'success';	
			}

			if($login_status == 'success')
			{
				//buscar solo usuarios que puedan hacer consultas
				$user = $this->buscarUserPM($parametros['username']);
				if(isset($user['USR_USERNAME'])){
					$userMode = $this->validarUserBPM_MENU($user['USR_UID']);
					unset($_SESSION['USR_LOGGED']);
					if($userMode){
					   $_SESSION["USR_LOGGED"] = $user['USR_UID'];
					   $_SESSION["USER_NAME"]  = $parametros['username'];
					   //variable usada para validar un tarea de manera externa
					   $_SESSION["sessionId"]  = $result->message;
 					   $resp['redirect_url']   = base_url().'consultapagos';
 					   $resp['sessionId']      = $_SESSION["sessionId"];
					}
					else
					{
					   $login_status = 'invalid';
					}
				}
			}

			$resp['login_status'] = $login_status;
			

			return $resp;
		}
		catch(Exception $e){
			//echo $e->getMe;
		}
	}
}

/* End of file server_model.php */
/* Location: ./application/models/server_model.php */