<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class workflow_model extends CI_Model {
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
	public $apiServer   ="http://172.31.100.61:8080";
    
	function pmRestLogin() { 

		$pmServer     = 'http://172.31.100.61:8080';
	    $pmWorkspace  = 'workflow';
	    
	    $IDSECRET     = "EQFNAQKYHJRJFTAJMBXCIEGCLLPMCSWV";
	    $PASSSECRET   = "991180419587d269e12d417041552241";
		$userIDsecret = "admin";
		$passIDsecret = "admin";
	    
	    //global $pmServer, $pmWorkspace;

	    $postParams = array(
	      'grant_type'    => 'password',
	      'scope'         => '*' ,       //set to 'view_process' if not changing the process
	      'client_id'     => $IDSECRET ,
	      'client_secret' => $PASSSECRET ,  
	      'username'      => $userIDsecret ,
	      'password'      => $passIDsecret , 
	   );

	   //print_r($postParams); 
	    //http://{pm-server}/{workspace}/oauth2/token
	    echo $pmServer."/workflow/oauth2/token";
	   $ch = curl_init($pmServer."/workflow/oauth2/token");
	   //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	   curl_setopt($ch, CURLOPT_POST, 1);
	   curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	   $oToken = json_decode(curl_exec($ch));
	   print_r($oToken);

	    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);
	 
	   if ($httpStatus != 200) {
	      print "Error in HTTP status code: $httpStatus\n";
	      return null;
	   }
	   elseif (isset($oToken->error)) {
	      print "Error logging into $pmServer:\n" .
	         "Error:       {$oToken->error}\n" .
	         "Description: {$oToken->error_description}\n";
	   }
	   else {
	      //At this point $oToken->access_token can be used to call REST endpoints.
	      //If planning to use the access_token later, either save the access_token 
	      //and refresh_token as cookies or save them to a file in a secure location. 
	      //If saving them as cookies:
	      setcookie("access_token",  $oToken->access_token,  time() + 86400);
	      setcookie("refresh_token", $oToken->refresh_token); //refresh token doesn't expire
	      setcookie("client_id",     $IDSECRET);
	      setcookie("client_secret", $PASSSECRET);
	      //If saving to a file:
	      //file_put_contents("/secure/location/oauthAccess.json", json_encode($tokenData));
	   }
	 
	   return $oToken; 
	}

	function pmRestUsers(){
		
		//echo $this->$apiServer;
		$apiServer = $this->apiServer;
		$oToken    = $this->pmRestLogin();
		
		$accessToken = $oToken->access_token;


		$ch = curl_init($apiServer . "/api/1.0/workflow/users");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$aUsers = json_decode(curl_exec($ch));
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$aActiveUsers = array();
		if ($statusCode != 200) {
			if (isset ($aUsers) and isset($aUsers->error))
				print "Error code: {$aUsers->error->code}\nMessage: {$aUsers->error->message}\n";
			else
				print "Error: HTTP status code: $statusCode\n";
		}
		else {
			if(count($aUsers)>0){
				foreach ($aUsers as $oUser) {
					if($oUser->usr_status == "ACTIVE") {
					   $aActiveUsers[] = array(
			   							"uid"           => $oUser->usr_uid,
			   		 					"username"      => $oUser->usr_username,
										"usr_firstname" => $oUser->usr_firstname,
										"usr_lastname"  => $oUser->usr_lastname,
										"usr_email"     => $oUser->usr_email,
										"usr_position"  => $oUser->usr_position,
					   		 			);
					}
				}
			}
		}
		return $aActiveUsers;
	}

	function pmUsersByid($userId){
		
		$apiServer   = $this->apiServer;
		$oToken      = $this->pmRestLogin();
		$accessToken = $oToken->access_token;

		//$apiServer = "https://example.com";           //set to your ProcessMaker address
		//$userId = '55324179754ca442baeb994077387342'; //set to the unique ID of a user

		$fullName ="";
		$ch = curl_init($apiServer . '/api/1.0/workflow/user/' . $userId);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$oUser = json_decode(curl_exec($ch));
		curl_close($ch);

		if (!isset($oUser)) {
		   print "Error accessing $apiServer: \n" . curl_error($ch);
		}
		elseif (isset($oUser->error)) {
		   print "Error in $apiServer: \nCode: {$oUser->error->code}\nMessage: {$oUser->error->message}\n";
		}
		else{

		   ///print_r($oUser);
		   $fullName['usr_uid']       = $oUser->usr_uid;
		   $fullName["username"]      = $oUser->usr_username;
		   $fullName['usr_firstname'] = $oUser->usr_firstname;
		   $fullName['usr_lastname']  = $oUser->usr_lastname;
		   $fullName['usr_email']     = $oUser->usr_email;
		   $fullName['usr_position']  = $oUser->usr_position;
		   $fullName['usr_password']  = $oUser->usr_password;
		   //echo $fullName;
		}
		return $fullName;
	}

	function pmGetAllUsersAssignTask(){
		$processId = '37725830057d99d1c0552f4014213210';
		$taskId    = '59164428757d99d1c0552f9077813115';
				       
		$apiServer   = $this->apiServer;
		$oToken      = $this->pmRestLogin();
		$accessToken = $oToken->access_token;
				       
		$url = "/api/1.0/workflow/project/".$processId."/activity/".$taskId."/assignee/all";

		$oRet = $this->pmRestRequest("GET", $url,null,$accessToken);
		if (isset($oRet->status) and $oRet->status == 200) {
			return $oRet;   
		}
		
    }
    
	function pmRestRequest($method, $endpoint, $aVars = null, $accessToken = null) {
	   
	   $pmServer =$this->apiServer;
	 
	   
	   //add beginning / to endpoint if it doesn't exist:
	   if (!empty($endpoint) and $endpoint[0] != "/")
	      $endpoint = "/" . $endpoint;
	 
	   $ch = curl_init($pmServer . $endpoint);
	   curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
	   curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   $method = strtoupper($method);
	 
	   switch ($method) {
	      case "GET":
	         break;
	      case "DELETE":
	         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	         break;
	      case "PUT":
	         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	      case "POST":
	         curl_setopt($ch, CURLOPT_POST, 1);
	         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aVars));
	         break;
	      default:
	         throw new Exception("Error: Invalid HTTP method '$method' $endpoint");
	         return null;
	   }
	 
	   $oRet = new StdClass;
	   $oRet->response = json_decode(curl_exec($ch));
	   $oRet->status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	   curl_close($ch);
		
	   if ($oRet->status == 401) { //if session has expired or bad login:
	      //header("Location: loginForm.php"); //change to match your login method
	      //die();  
	   }
	   elseif ($oRet->status != 200 and $oRet->status != 201) { //if error
	      if ($oRet->response and isset($oRet->response->error)) {
	         print "Error in $pmServer:\nCode: {$oRet->response->error->code}\n" .
	               "Message: {$oRet->response->error->message}\n";
	      }
	      else {
	         print "Error: HTTP status code: $oRet->status\n";
	      }
	   }
	   return $oRet;
	}

	function PM_validarLogin($data=array()){

		$client = new SoapClient("http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/sysworkflow/en/green/services/wsdl2");

		$pass   = 'md5:'.md5($data['pass']);
		$params = array(array('userid'=>$data['user'], 'password'=>$pass));
		$result = $client->__SoapCall('login', $params);
		$array  =  array();
		if(isset($result->message)){
   			$array['status_code'] = $result->status_code;
   			$array['message']     = $result->message;
		}	
		return $array;
	}

	public function createNuevoCaso(){
		//creamos un nuevo caso como admintrador es importante que el usuario admin ete asigando a la tarea
		$apiServer   = $this->apiServer;
		$oToken      = $this->pmRestLogin();
		$accessToken = $oToken->access_token;

		$aVars = array(
  			'pro_uid'   => '88815307657e16ee61ca3e7013923193',           
   			'tas_uid'   => '95150756857e16eecc5afa8050146519',
   			'usr_uid'   => '00000000000000000000000000000001',
		);

		$url = "/api/1.0/workflow/case"; 
		$method = "POST";
		$oRet = $this->pmRestRequest($method, $url, $aVars ,$accessToken);

		//una vez creado el caso lo asigamos a otro usuario este caso aparece en la baseja de borradores
		//Esto segun la documentociion processmaerk "2.0"

		if($oRet->status == 200){
		    print "New Case created.\n";
		    $aVars = array(
   			 	"usr_uid_source"=> "00000000000000000000000000000001",
        		"usr_uid_target"=> "682281494587d1ea41a4532069045713",
			);

		    $method = "PUT";
		    $url    = "/api/1.0/workflow/cases/".$oRet->response->app_uid."/reassign-case";
		    $oRet   = $this->pmRestRequest($method,$url, $aVars ,$accessToken);
		}
	}
}


