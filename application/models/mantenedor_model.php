<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mantenedor_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}	

 	////cargar la variables de configuracion del sistema//
 	//////////////////////////////////////////////////////
	public function get_bpm_config($VARIABLE){
		$this->db->select('*');
        $this->db->from('bpm_config');
        $this->db->where('VARIABLE',$VARIABLE);
        $query     = $this->db->get();
		$variables = $query->result_array();
		return $variables[0]['VALOR'];
	}

	///////////buscar DT por filtro////////////////
	///////////////////////////////////////////////
	public function buscarDtFiltro($data){


		libxml_disable_entity_loader(false);
		$respuesta = array();

		try
		{

		$rut_proveedor = 0;
		$id_proceso    = 0;

		if(trim($data["RUTPROV"])!=""){
			$rut_proveedor =  strtoupper(str_replace(".","",$data["RUTPROV"]));
		}

		if(trim($data["PROCESO"])!=""){
			$id_proceso = $data["PROCESO"];
		}		

		$IP_WS        = $this->get_bpm_config("IP_WS");
		$proveedores  = array();

		//$IP_WS ="172.31.100.43";

		$opts = array('http'=>array('user_agent' => 'PHPSoapClient'));


		$context = stream_context_create($opts);
		$wsdlUrl = 'http://'.$IP_WS.'/WS00556_DT_Filtro/WS00556_DT_Filtro.svc?wsdl';
		$soapClientOptions = array('stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE);

		$client1  = new SoapClient($wsdlUrl, $soapClientOptions);
		$search_query = new StdClass();
		$search_query->request = new StdClass();

		$search_query->request->codigo_empresa  = $data["SOCIEDAD"];
		$search_query->request->rut_proveedor   = $rut_proveedor;
		$search_query->request->id_proceso      = $id_proceso;

		
		

		$server = $client1->GetProvDT($search_query);
        $rs     = $server->GetProvDTResult;
    	
	    	if($rs->estado->codigo ==0 ){
	    		
	    		if(count($rs->datos->DatosResponse)==1){
	    			$respuesta = array($rs->datos->DatosResponse);
	    		}
	    		if(count($rs->datos->DatosResponse)>1){
	    			foreach ($rs->datos->DatosResponse as $key => $value) {
	    				$respuesta[] = $value;
	    			}
	    		}
	    	}

    	}
    	catch(Exception $e)
    	{
	    	
		}

		return $respuesta;
	}

	////////////delete DT por filtro////////////////
	///////////////////////////////////////////////
    public function deteleDTFiltro($data){


    	libxml_disable_entity_loader(false);
		$IP_WS        = $this->get_bpm_config("IP_WS");
		$proveedores  = array();

		//$IP_WS   = "172.31.100.43";
		$opts    = array('http'=>array('user_agent' => 'PHPSoapClient'));
		$context = stream_context_create($opts);

		$wsdlUrl = 'http://'.$IP_WS.'/WS00035_ActualizaEstadoDT/WS00035_ActualizaEstadoDT.asmx?WSDL';
		$soapClientOptions = array('stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE);

  		
		$client1 	  = new SoapClient($wsdlUrl,$soapClientOptions);
  		$search_query = new StdClass();

  		$search_query->request = new StdClass();
    
  		$search_query->request->sociedad     = $data['SOCIEDA_HIDDEN'];
  		$search_query->request->id_proceso   = $data['CASO_ID_HIDDEN'];
  		$search_query->request->observacion  = "Eliminado";
  
        $search_query->request->estado      	= "RR";
  		$search_query->request->rut_autoriza    = "";
  		$search_query->request->nombre_autoriza = "";
  		$search_query->request->tipo_act 		= "";
   		$search_query->request->es_activo_fijo  = ""; 
	    
	    $result1 = $client1->actualizaEstadoDT($search_query);
  	  	$string  = $result1->actualizaEstadoDTResult;

  	  	if($string->error->cod_error ==0){
  	  		//ejecutar query que elima el caso de la base base worflok del bpm
  	  		$this->sqlEliminaCasoWorkflow($data["CASO_ID_HIDDEN"]);
  	  	}

  	  	return $data['CASO_ID_HIDDEN'];
    }

    public function sqlEliminaCasoWorkflow($id_proceso){

    	if($id_proceso!=""){
    		$sql[0] ="DELETE FROM APP_DOCUMENT USING APP_DOCUMENT INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_DOCUMENT.APP_UID";

			$sql[1] ="DELETE FROM APP_EVENT USING APP_EVENT INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_EVENT.APP_UID";

			$sql[2] ="DELETE FROM APP_MESSAGE USING APP_MESSAGE INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_MESSAGE.APP_UID";

			$sql[3] ="DELETE FROM APP_OWNER USING APP_OWNER INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_OWNER.APP_UID";
				
			$sql[4] ="DELETE FROM APP_THREAD USING APP_THREAD INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_THREAD.APP_UID";

			$sql[5] ="DELETE FROM SUB_APPLICATION USING SUB_APPLICATION INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = SUB_APPLICATION.APP_UID";

			$sql[6] ="DELETE FROM APP_DELAY USING APP_DELAY INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_DELAY.APP_UID";

			$sql[7] ="DELETE FROM APP_DELEGATION USING APP_DELEGATION INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_DELEGATION.APP_UID";

			$sql[8] ="DELETE FROM APP_CACHE_VIEW USING APP_CACHE_VIEW INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_CACHE_VIEW.APP_UID";
			$sql[9] ="DELETE FROM APP_HISTORY USING APP_HISTORY INNER JOIN APPLICATION WHERE APPLICATION.APP_NUMBER IN (".$id_proceso.") AND APPLICATION.APP_UID = APP_HISTORY.APP_UID";
				
			$sql[10] ="DELETE FROM APPLICATION WHERE APP_NUMBER IN (".$id_proceso.")";

			$sql[11] ="UPDATE bpm_job_contabilidad SET pm_estado = 'Eliminado' WHERE pm_caso = ".$id_proceso;


			foreach ($sql as $key => $value) {
				# code...
				$query = $this->db->query($value);
    			//$rs    = $query->result_array();
			}
    	}

    }

	public function listarColaboradores(){

		$col   = array();
		$query = $this->db->query("SELECT * from users as u inner join bpm_rut_users as bpm_u on u.USR_UID = bpm_u.USER_UID");
    	$row   = $query->result();
    	if(count($row)>0){
    	   $col = $row;
    	}
		return $col;
	}

	public function listarProveedores(){

		error_reporting(0);
		try {

			
			$SERVER     = $this->get_bpm_config("IP_WS");
			$empresa[0] = "CL01";
		    $empresa[1] = "CL24";

			$opts = array(
					'http'=>array(
					'user_agent' => 'PHPSoapClient'
					)
			);

			$context = stream_context_create($opts);
			$client1 = new SoapClient('http://'.$SERVER.'/WS00474_ListaProveedoresISA/ListaProveedoresISA.svc?wsdl',
			            array('stream_context' => $context,
		                'cache_wsdl' => WSDL_CACHE_NONE));

			$proveedores = array();

			if(count($empresa)>0){
				foreach ($empresa as $key => $value){
					$search_query = new StdClass();
					$search_query->request = new StdClass();
					$search_query->request->sociedad  = $value;

					$servicio     = $client1->GetListaProveedoresISA($search_query);
					$response     = $servicio->GetListaProveedoresISAResult;
					
					if(count($response)>0){
					   $proveedores[$value] = $response->datos->DatosResponse;
					    foreach ($proveedores as $x => $v) {
					   		$cont =0;
					   		foreach ($v as $f){
					   	   		$rs = $this->buscarCuentasProveedor($f->RUT, $f->SOCIEDAD);
					   	   		$proveedores[$x][$cont]->NUM_CUENTAS = count($rs);
					   	   		$cont++;
					   		}
					    }
					}
				}
			}
			return $proveedores;
		} catch (Exception $e) {
			
		}
	}


	public function validaRUTSAP($data =array()){

		$AMBAS 		  = false;
		$Sociedades_P = array($data['SOCIEDAD']);

		if($data['SOCIEDAD'] =="AMBAS"){ 
			$data['SOCIEDAD'] ="CL01"; 
			$AMBAS = true; 
			$Sociedades_P = array("CL01",'CL24');
		}
		//validar que el proveedores este credo en todas las sociedades diponibles en sap
		$data["RUT"]  = strtoupper($data["RUT"]);
		$RsExisteSAP  =1;
		
		$respuesta["estado"]  = 0;
		$respuesta["mensaje"] = "";

		for ($i=0; $i < count($Sociedades_P); $i++){ 
			if($RsExisteSAP == 1){
			   $validaRS    = $this->existeProSapBySociedad($data["RUT"],$Sociedades_P[$i]);
			    if(isset($validaRS->datos->DatosResponse->COD_ERROR)){

			   	    if($validaRS->datos->DatosResponse->COD_ERROR ==0){
			   	  	    $RsExisteSAP =0;
			   	  	    $socied_m ="Isapres Banmédica";
			   	  	    if($Sociedades_P[$i]=="CL24"){
			   	  	    	$socied_m ="Vida Tres";
			   	  	    }
			   	  	    $mensaje ="
			   	  	    	No existe el proveedor en SAP<br> Rut ".$data["RUT"]."
			   	  	    	sociedad ".$socied_m;
			   	  	    $respuesta["estado"]  = 2;
						$respuesta["mensaje"] = $mensaje;
			   	    }
			    }
			    else
			    {
			   		//Camnbio el valor de lavariba para cerra el ciclo
			   		$respuesta["estado"]  = 2;
					$respuesta["mensaje"] = "No existe el proveedor en SAP";
			    }
			}
		}
		//si no existe error validamos que no repita
		if($RsExisteSAP ==1){
			
			$proveedor =$this->buscarProveedorByRut($data["RUT"] , $data['SOCIEDAD']);
			$respuesta["estado"] = 0;

			if(isset($proveedor["rut"])){
				$respuesta["estado"]  = 1;
				$respuesta["mensaje"] = "proveedor ya existe";
			}
		}
		return $respuesta;
	}
	

	public function insertProveedor($data = array()){

		$AMBAS 		  = false;
		$Sociedades_P = array($data['SOCIEDAD']);
		if($data['SOCIEDAD'] =="AMBAS"){ 
			$data['SOCIEDAD'] ="CL01"; 
			$AMBAS = true; 
			$Sociedades_P = array("CL01",'CL24');
		}
		//validar que el proveedores este credo en todas las sociedades diponibles en sap
		$data["RUT"]  = strtoupper($data["RUT"]);
		$RsExisteSAP  =1;
		for ($i=0; $i < count($Sociedades_P); $i++){ 
			if($RsExisteSAP == 1){
			   $validaRS    = $this->existeProSapBySociedad($data["RUT"],$Sociedades_P[$i]);
			   if(isset($validaRS->datos->DatosResponse->COD_ERROR)){

			   	    if($validaRS->datos->DatosResponse->COD_ERROR ==0){
			   	  	    $RsExisteSAP =0;
			   	  	    $socied_m ="Isapres Banmédica";
			   	  	    if($Sociedades_P[$i]=="CL24"){
			   	  	    	$socied_m ="Vida Tres";
			   	  	    }
			   	  	    $mensaje ="
			   	  	    	No existe el proveedor en SAP<br> Rut ".$data["RUT"]."
			   	  	    	sociedad ".$socied_m;
			   	    }
			   }
			   else
			   {
			   	//Camnbio el valor de lavariba para cerra el ciclo
			   	$RsExisteSAP =0;
			   	$mensaje     ="No existe el proveedor en SAP";
			   }
			}
		}
		if($RsExisteSAP ==1){
			$proveedor =$this->buscarProveedorByRut($data["RUT"] , $data['SOCIEDAD']);
			$respuesta["estado"] =0;
			if(!isset($proveedor["rut"])){
				$ok =0;
				if(count($data["CUENTAS"])>0){

					foreach ($data["CUENTAS"] as $i => $c) {
						$this->db->set('RUT', $data["RUT"]);
						$this->db->set('CUENTA', $c["CUENTA"]);
						$this->db->set('DESCRIPCION', $c["DESCRIPCION"]);
						$this->db->set('SOCIEDAD', $data["SOCIEDAD"]);
						$ok = $this->db->insert('bpm_proveedor_cuentas');		
					}
					if($AMBAS == true){

						foreach ($data["CUENTAS"] as $i => $c){
							$this->db->set('RUT', $data["RUT"]);
							$this->db->set('CUENTA', $c["CUENTA"]);
							$this->db->set('DESCRIPCION', $c["DESCRIPCION"]);
							$this->db->set('SOCIEDAD', "CL24");
							$ok = $this->db->insert('bpm_proveedor_cuentas');		
						}
					}
					if($ok){
						$this->servicioInsertaProveedor($data);
						if($AMBAS == true){
							$data["SOCIEDAD"] = 'CL24';
							$this->servicioInsertaProveedor($data);
						}
					}
				}

				$respuesta["estado"]  = 0;
			}
			else
			{
				$respuesta["estado"]  = 1;
				$respuesta["mensaje"] = "proveedor ya existe";
			}
		}
		else
		{
			$respuesta["estado"]  = 2;
			$respuesta["mensaje"] = $mensaje;
		}

		return $respuesta;
	}

	public function existeProSapBySociedad($RUT, $SOCIEDAD){
		$SERVER      = $this->get_bpm_config("IP_WS");
		try {
		$opts = array(
				'http'=>array(
				'user_agent' => 'PHPSoapClient'
				)
		);
		$context = stream_context_create($opts);
		$client1 = new SoapClient('http://'.$SERVER.'/WS00495_Provee_Valida/WS00495_Provee_Valida.svc?wsdl',
		            array('stream_context' => $context,
	                'cache_wsdl' => WSDL_CACHE_NONE));
  		$search_query = new StdClass();
  		$search_query->request = new StdClass();
  		$search_query->request->COD_SAP = $SOCIEDAD;
  		$search_query->request->RUT_PROVEEDOR = $RUT;

  		$query = $client1->GetProvee_Valida($search_query);
  		$rs    = $query->GetProvee_ValidaResult;

  		return $rs;

  		}catch(Exception $e){

  		}
	}





	public function getProveedorByRut($rut,$sociedad){
		$respuesta = array();
		$data = $this->buscarProveedorByRut($rut,$sociedad);
		

		if(isset($data["rut"])){

		   $respuesta = $data;	

		   $sql   = "SELECT * FROM bpm_proveedor_cuentas where RUT='".$data['rut']."' and SOCIEDAD ='".$sociedad."' group by CUENTA";
		   $query = $this->db->query($sql);
    	   $rs    = $query->result_array();
    	   
    	   $respuesta["CUENTAS"] = array();

    	   if(count($rs)>0){
	          $respuesta["CUENTAS"] = $rs;
    	   }
		}

		return $respuesta;
	}

	public function UpdateProveedor($data){

		/*actualiza la informacion del proveedor cuando esta ya existe*/
		$data["RUT"]  = strtoupper($data["RUT"]);
		

		$this->servicioInsertaProveedor($data);

	    //elimnar todos lo antertior
    	$this->db->where('RUT', $data["RUT"]);
		$this->db->where('SOCIEDAD',$data["SOCIEDAD"]);
		$this->db->delete('bpm_proveedor_cuentas');

		//insertya lo nuevi
		foreach ($data["CUENTAS"] as $i => $c) {
			$this->db->set('RUT', $data["RUT"]);
			$this->db->set('CUENTA', $c["CUENTA"]);
			$this->db->set('DESCRIPCION', $c["DESCRIPCION"]);
			$this->db->set('SOCIEDAD', $data["SOCIEDAD"]);
			$ok = $this->db->insert('bpm_proveedor_cuentas');		
		}

		if($data["ambasEMP"]=="SI"){

		    if($data["SOCIEDAD"]=="CL24"){
		   	   $data["SOCIEDAD"] ="CL01";

		    }else if($data["SOCIEDAD"]=="CL01"){
		       $data["SOCIEDAD"] ="CL24";
		    }	
			$this->servicioInsertaProveedor($data);
			//elimnar todos lo antertior
			$this->db->where('RUT', $data["RUT"]);
			$this->db->where('SOCIEDAD',$data["SOCIEDAD"]);
			$this->db->delete('bpm_proveedor_cuentas');

			//insertya lo nuevi
			foreach ($data["CUENTAS"] as $i => $c) {
				$this->db->set('RUT', $data["RUT"]);
				$this->db->set('CUENTA', $c["CUENTA"]);
				$this->db->set('DESCRIPCION', $c["DESCRIPCION"]);
				$this->db->set('SOCIEDAD', $data["SOCIEDAD"]);
				$ok = $this->db->insert('bpm_proveedor_cuentas');		
			}
		}

		$respuesta['estado'] = 0;

		return $respuesta;
	}

	public function cargarListaCuentaSap($sociedad){

		$sql   = "SELECT * FROM bpm_lista_cuentas_sap where EMPRESA='".$sociedad."'";
		
		if($sociedad=="AMBAS"){
			$sql   = "SELECT * FROM bpm_lista_cuentas_sap where EMPRESA in('CL01','CL24') group by CODIGO";
		}
	    $query = $this->db->query($sql);
    	$rs    = $query->result_array();
    	$respuesta = array();
    	
    	if(count($rs)>0){
           $respuesta = $rs;
    	}
    	return $respuesta;
	}

	public function servicioInsertaProveedor($data){
		//http://192.168.6.169/
		
		
		$SERVER      = $this->get_bpm_config("IP_WS");
		
		$proveedores = array();

		

		try {

		$opts = array(
				'http'=>array(
				'user_agent' => 'PHPSoapClient'
				)
		);

		$context = stream_context_create($opts);
		$client1 = new SoapClient('http://'.$SERVER.'/WS00475_InsertaProveedoresISA/InsertaProveedoresISA.svc?wsdl',
		            array('stream_context' => $context,
	                'cache_wsdl' => WSDL_CACHE_NONE));

  		$search_query = new StdClass();
  		$search_query->request = new StdClass();
		


				$search_query->request->x_AGENCIA      = $data["AGENCIA"];
				$search_query->request->x_BCO_PROPIO   = $data["BANCO"];
				$search_query->request->x_CIUDAD       = "";
				$search_query->request->x_CONFIANZA    = "S";   
				$search_query->request->x_CONTACTO     = "";
				$search_query->request->x_DIRECCION    = "";
				$search_query->request->x_EMAIL        = $data["MAIL"];
				$search_query->request->x_FAX          = "";
				$search_query->request->x_GIRO         = ""; 
				$search_query->request->x_MONTO_BASE   = $data["MONTO_TOPE"];
				$search_query->request->x_NOMBRE         = $data["NOMBRE"];
				$search_query->request->x_NUMERO_CLIENTE = "";
				$search_query->request->x_RUT            = $data["RUT"];
				$search_query->request->x_SOCIEDAD       = $data["SOCIEDAD"];
				$search_query->request->x_TELEFONO       = "";
				$search_query->request->x_TELEFONO2      = "";
				$search_query->request->x_TIPO_PAGO      = $data["TIPO_P"];
				$search_query->request->x_RECURRENTE     = $data["RECURRENTE"];

			    $result1 = $client1->InsertProveedoresISA($search_query);
			    $string  = $result1->InsertProveedoresISAResult;
			    $gerente = json_decode(json_encode($string,true),true);

	     return $gerente;
		
		}catch(Exception $e){
			
		}
	}

	public function buscarProveedorByRut($rut , $sociedad){

		$SERVER       = $this->get_bpm_config("IP_WS");
		$proveedores  = array();

		try {

		$opts = array(
				'http'=>array(
				'user_agent' => 'PHPSoapClient'
				)
		);

		$context = stream_context_create($opts);
		$client1 = new SoapClient('http://'.$SERVER.'/WS00041_GetProveedorPorRut/WS00041_GetProveedorPorRut.asmx?WSDL',
		            array('stream_context' => $context,
	                'cache_wsdl' => WSDL_CACHE_NONE));

  		$search_query = new StdClass();
  		$search_query->request = new StdClass();
 
  		$search_query->request->holding  = "ISAPRES";
  		$search_query->request->sociedad = $sociedad; //'CL01'
 		$search_query->request->rut = $rut;//    '6077727-6'

	    $result1 = $client1->getProveedorPorRut($search_query);
	    $string  = $result1->getProveedorPorRutResult;
	    $data    = json_decode(json_encode($string,true),true);

	    return $data;
		
		}catch (Exception $e) {
			
		}

	}

	public function  buscarCuentasProveedor($RUT, $SOCIEDAD){
		
		$this->db->select('*');
        $this->db->from('bpm_proveedor_cuentas');
        $this->db->where('RUT',$RUT);
        $this->db->where('SOCIEDAD',$SOCIEDAD);
        $query     = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function listarAutorizadores(){

		$col   = array();
		$query = $this->db->query("SELECT * FROM `bpm_autorizadores` as bpm inner join bpm_rut_users as bpm_u on bpm.RUT = bpm_u.RUT group by bpm.RUT");
    	$row   = $query->result();
    	if(count($row)>0){
    	   $col = $row;
    	}
		return $col;
	}

	public function getGroupUserByid($userID =""){
		$sql ="SELECT C.CON_ID, C.CON_VALUE FROM CONTENT C, GROUP_USER GU, USERS U WHERE C.CON_ID=GU.GRP_UID AND U.USR_UID=GU.USR_UID AND U.USR_UID='".$userID."' group by C.CON_VALUE";

 		$query = $this->db->query($sql);
    	$row   = $query->result();
    	$respuesta = array();
    	if(count($row)>0){
    	   $respuesta = $row;
    	}
    	return $respuesta;
	}

	public function validarUSR_UID($user){
		
		$query 	   = "SELECT * from users WHERE USR_UID ='".$user."'";
		$respuesta = $this->db->query($query);
		$row 	   = $respuesta->result();

		$estado = array();
		if(count($row)>0){
			$grupos = $this->getGroupUserByid($user);
			$estado = $row;
			$estado[0]->grupos = $grupos;
		}
		return $estado;
	}

	public function convercionUIDBYRUt($USER_UID){
		
		
		$this->db->select('*');
        $this->db->from('bpm_rut_users');
        $this->db->where('USER_UID' ,$USER_UID);
        $query = $this->db->get();
		$user  = $query->result_array();

		return $user;
	}

	public function getRutCentroCostoByEmpresa($array =array()){
		
		$data = array();

		$user = $this->convercionUIDBYRUt($array['input_rut']);
		
		$this->db->select('*');
        $this->db->from('bpm_rut_ccosto');
        $this->db->where('RUT'     ,$user[0]['RUT']);
        $this->db->where('SOCIEDAD',$array["input_empresa"]);
        $this->db->order_by("DESCRIPCION", "asc");
        $query     = $this->db->get();
		$CosUsados = $query->result_array();
		
		if(count($CosUsados)>0){
			$data["rutCosto"]["usados"] =$CosUsados;
 		}

		return $data;
	}


	public function getRutcuentaContablesEmpresa($data=array()){

		$res = array();

		$user = $this->convercionUIDBYRUt($data['input_rut']);
		$this->db->select('*');
        $this->db->from('bpm_autorizadores_cuenta');
        $this->db->where('RUT'     ,$user[0]['RUT']);
        $this->db->where('SOCIEDAD',$data["input_empresa"]);
        $this->db->order_by("DESCRIPCION_CUENTA", "asc");
        $query     = $this->db->get();
		$CuentasUsados = $query->result_array();

		if(count($CuentasUsados)>0){
		   $res["rutCuentas"]["usados"] =$CuentasUsados;
 		}
 		return $res;
	}

	public function borrarCentorCostoByEmpresa($data = array()){

		$res  = 0;
		$user = $this->convercionUIDBYRUt($data['input_rut']);

		if(count($data["borrarCentros"])>0){
			foreach ($data["borrarCentros"] as $key => $c) {
				if($c!=""){
					$this->db->where('RUT', $user[0]['RUT']);
					$this->db->where('SOCIEDAD',$data["input_empresa"]);
					$this->db->where('CCOSTO', $c);
					$res =	$this->db->delete('bpm_rut_ccosto');
				}
			}
		}
		return $res;		
	}


	public function borrarCuentasContablesByEmpresa($data =array()){
		$res = 0;
		$user = $this->convercionUIDBYRUt($data['input_rut']);

		if(count($data["borrarCuentas"])>0){
			foreach ($data["borrarCuentas"] as $key => $c) {
				if($c!=""){
					$this->db->where('RUT', $user[0]['RUT']);
					$this->db->where('SOCIEDAD',$data["input_empresa"]);
					$this->db->where('CUENTA', $c);
					$res =	$this->db->delete('bpm_autorizadores_cuenta');
				}
			}
		}
		return $res;
	}

	public function CentroCostoValidarFilaExcel($excel){
		$excel = array_values($excel);
		$ultimaFila = count($excel)-1;
		if(count($excel[$ultimaFila])!=4){
		   unset($excel[$ultimaFila]);
		}
		if(count($excel)>0){
			$i =2;
			foreach ($excel as $key => $value) {

				if(count($excel[$key])==4){
					if(isset($value['A']) && isset($value['B']) && isset($value['C']) && isset($value['D'])){
						$excel[$key]["error"] = array();
						if($value['A']=="" || $value['B']=="" || $value['C']=="" || $value['D']==""){
						   $excel[$key]["error"][0] ="Fila ".$i." contiene columnas en blanco";
						}
						if($value['A']!="CL01" && $value['A']!="CL24"){
						   $excel[$key]["error"][1] ="Fila ".$i." columna A solo permite valores CL01 o CL24";
						}
						if(!$this->validaRut($value["B"])){
						   $excel[$key]["error"][2] ="Fila ".$i." columna B contiene un rut invalido";
						}
						else
						{
							if(!$this->exiteUsuarioBPM($value["B"])){
								$excel[$key]["error"][2] ="Fila ".$i." columna B rut ".$value["B"]." no esta creado como un usuario ,favor de solicitar creación de este usuario";
							}
						}

						if(!$this->validarCentroCosto($value['C'], $value['A'])){
							$excel[$key]["error"][4] ="Fila ".$i." columna C centro de costos (".$value['C'].") no existe en SAP";
						}

						/*if(strlen(trim($value["C"]))!=10){
							$excel[$key]["error"][4] ="Fila ".$i." columna C ingrese codigo de 10 digitos";
						}*/
					}
					else
					{
						$excel[$key]["error"][3] ="Fila ".$i." estructura o columnas no validas utilice plantilla para cargar los datos";	
					}
				}else{
					$excel[$key]["error"][3] ="Fila ".$i." no permite campos en blanco";
				}
				$i++;
			}
		}
		return $excel;
	}

	////////////////validar centor de costos contra SAP
	public function validarCentroCosto($CCOSTO , $SOCIEDAD){

		//error_reporting(0);
		libxml_disable_entity_loader(false);
		$IP_WS        = $this->get_bpm_config("IP_WS");
		$proveedores  = array();

		$estado = false;

		//$IP_WS ="172.31.100.43";


		$opts = array(
					'http'=>array(
					'user_agent' => 'PHPSoapClient'
					)
		);

		$context = stream_context_create($opts);

		$wsdlUrl = 'http://'.$IP_WS.'/WS00555_ConsultaCCosto/WS00555_ConsultaCCosto.svc?wsdl';
		$soapClientOptions = array(
		'stream_context' => $context,
		'cache_wsdl' => WSDL_CACHE_NONE
		);

		$client1  = new SoapClient($wsdlUrl, $soapClientOptions);
		$search_query = new StdClass();
		$search_query->request = new StdClass();
		$search_query->request->codigo_empresa  = $SOCIEDAD;
		$search_query->request->idCentro_Costo  = $CCOSTO;

		
		$server = $client1->GetCentroCostos($search_query);
        $rs     = $server->GetCentroCostosResult;
    	if( $rs->estado->codigo ==0 ){
    		if($rs->datos->DatosResponse->ESTADO == 'E'){ //existe
    			$estado = true;
    		}
    	}

	    return $estado;
	}


	public function CentroCostoInsertarExcel($data){
		$estado = 0;

		if(count($data)>0){
			foreach ($data as $key => $value){
				$this->db->set('SOCIEDAD'   , $value["A"]);
				$this->db->set('RUT'        , $value["B"]);
				$this->db->set('CCOSTO'     , $value["C"]);
				$this->db->set('DESCRIPCION', $value["D"]);
				$estado = $this->db->insert('bpm_rut_ccosto');
			}
		}
		return $estado;
	}

	public function CuentaContablesInsertarExcel($data){
		$estado = 0;
		if(count($data)>0){
			foreach ($data as $key => $value){
				$this->db->set('SOCIEDAD'   , $value["A"]);
				$this->db->set('RUT'        , $value["B"]);
				$this->db->set('CUENTA'     , $value["C"]);
				$this->db->set('DESCRIPCION_CUENTA', $value["D"]);
				$estado = $this->db->insert('bpm_autorizadores_cuenta');
			}
		}
		return $estado;
	}

	public function CuentasContablesValidarFilaExcel($excel){

		$excel = array_values($excel);
		$ultimaFila = count($excel)-1;
		if(count($excel[$ultimaFila])!=4){
		   unset($excel[$ultimaFila]);
		}
		if(count($excel)>0){
			$i =2;
			foreach ($excel as $key => $value) {

				if(count($excel[$key])==4){
					if(isset($value['A']) && isset($value['B']) && isset($value['C']) && isset($value['D'])){
						$excel[$key]["error"] = array();
						if($value['A']=="" || $value['B']=="" || $value['C']=="" || $value['D']==""){
						   $excel[$key]["error"][0] ="Fila ".$i." contiene columnas en blanco";
						}
						if($value['A']!="CL01" && $value['A']!="CL24"){
						   $excel[$key]["error"][1] ="Fila ".$i." columna A solo permite valores CL01 o CL02";
						}

						if(!$this->validaRut($value["B"])){
						    $excel[$key]["error"][2] ="Fila ".$i." columna B contiene un rut invalido";

						}else if(!$this->exiteUsuarioBPM($value["B"])){
							$excel[$key]["error"][2] ="Fila ".$i." columna B rut ".$value["B"]." no esta creado como un usuario, favor de solicitar creación de este usuario";
							
						}else if(!$this->existeAutorizador($value["B"])){
							$excel[$key]["error"][2] ="Fila ".$i." columna B rut ".$value["B"]." no esta registrado como un autorizador";
						}

						if(strlen(trim($value["C"]))!=10){
						   $excel[$key]["error"][4] ="Fila ".$i." columna C ingrese codigo de 10 digitos";
						}
					}else{
						$excel[$key]["error"][3] ="Fila ".$i." estructura o columnas no validas utilice plantilla para cargar los datos";	
					}

				}else{
					$excel[$key]["error"][3] ="Fila ".$i." no permite campos en blanco";
				}
				$i++;
			}
		}
		return $excel;
	}
	public function exiteUsuarioBPM($rut){
		$estado = false;
		$this->db->select('*');
        $this->db->from('bpm_rut_users');
        $this->db->where('RUT',$rut);
        $query       = $this->db->get();
		$autorizador = $query->result_array();
		if(count($autorizador)>0){
			$estado = true;
		}
		return $estado;
	}

	public function existeAutorizador($rutAutorizador){
		$estado = false;
		
		$this->db->select('*');
        $this->db->from('bpm_autorizadores');
        $this->db->where('RUT',$rutAutorizador);
        $query       = $this->db->get();
		$autorizador = $query->result_array();

		if(count($autorizador)>0){
			$estado = true;
		}
		return $estado;
	}

	public function getListaUsuarios(){
		
		$user = array();
		$this->db->select('*');
        $this->db->from('users');
        $this->db->join('bpm_rut_users', 'users.USR_UID = bpm_rut_users.USER_UID');
         $this->db->order_by("users.USR_FIRSTNAME", "asc");
        $query = $this->db->get();
		$usuarios = $query->result_array();
		
		if(count($usuarios)>0){
			$user = $usuarios;
		}
		return $user;
	}
	public function actualizar_usuario($op){

		$this->db->set('USR_FIRSTNAME'   , $op["nombre"]);
		$this->db->set('USR_LASTNAME'    , $op["apellido"]);
		$this->db->set('USR_EMAIL'       , $op["correo"]);
		$this->db->set('USR_REPLACED_BY' , $op["sustitucion"]);
		$this->db->where('USR_UID'       , $op["USR_UID"]);
		$estado = $this->db->update('Users');
		return $estado;
	}
	public function validaRut($rut){
		$suma=0;
	    if(strpos($rut,"-")==false){
	        $RUT[0] = substr($rut, 0, -1);
	        $RUT[1] = substr($rut, -1);
	    }else{
	        $RUT = explode("-", trim($rut));
	    }
	    $elRut = str_replace(".", "", trim($RUT[0]));
	    $factor = 2;
	    for($i = strlen($elRut)-1; $i >= 0; $i--):
	        $factor = $factor > 7 ? 2 : $factor;
	        $suma += $elRut{$i}*$factor++;
	    endfor;
	    $resto = $suma % 11;
	    $dv = 11 - $resto;
	    if($dv == 11){
	        $dv=0;
	    }else if($dv == 10){
	        $dv="k";
	    }else{
	        $dv=$dv;
	    }
	   if($dv == trim(strtolower($RUT[1]))){
	       return true;
	   }else{
	       return false;
	   }
	}

}
function pr($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";

}

/* End of file server_model.php */
/* Location: ./application/models/matenedor_model.php */