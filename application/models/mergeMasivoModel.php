<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MergeMasivoModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}	

	/*cargar documentos*/
	public function get_bpm_config($VARIABLE){
		$this->db->select('*');
        $this->db->from('bpm_config');
        $this->db->where('VARIABLE',$VARIABLE);
        $query     = $this->db->get();
		$variables = $query->result_array();
		return $variables[0]['VALOR'];
	}

	public function buscarElectronico($empresa,$rut,$nroDocto){
		$SERVER["VALOR"] ="172.31.100.76";
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
		
		$search_query = new StdClass();
		$search_query->request = new StdClass();
		$search_query->request->holding = "ISAPRES";
		$search_query->request->sociedad = $empresa;
		$search_query->request->rutProveedor = $rut;
		$search_query->request->tipoDocto = '';
		$search_query->request->tipoImpuesto = '';
		$search_query->request->nroDocto = $nroDocto;

		$result1 = $client1->getDTEs($search_query);
		$string  = $result1->getDTEsResult;
		$data    = json_decode(json_encode($string,true),true);
		
		$respuesta = array();
		if(isset($data['documentos']['DTE']['urlDoc'])){
			$respuesta["doc"] = $data["documentos"]['DTE']['urlDoc'];
		}

		return $respuesta;

	}
 	/*cargar la variables de configuracion del sistema*/
	public function listarDocumentos(){

		$sql = "SELECT * FROM bpm_tablau_log as tab INNER JOIN application as app on tab.PROCESO = app.app_number where TAB.`ESTADO_DOC` LIKE '%PENDIENTE%' order by RAND() limit 1";

		$query  = $this->db->query($sql);
		$rs     = $query->result_array();
		
		$z =0;
		$docGeneradoPDF ="";
		$respuesta   = array();
		foreach ($rs as $key => $value){

			$electronico = $this->buscarElectronico($value["EMPRESA"],$value["RUT"],$value['NRO_DOC']);
			if(count($electronico)>0){
			   $docGeneradoPDF =  $electronico["doc"];
			}
			else
			{
				$url            = $this->GetDocumentoManual($value['PROCESO']);
				if(isset($url['doc'])){
					$docGeneradoPDF = $url['doc'];
				}
			}

            $APP_DATA   = unserialize($value["APP_DATA"]);
            $nombre_Documento =  $APP_DATA['c021']."_".$APP_DATA['c008']."_0_".$APP_DATA['c009']."_".$APP_DATA['c025']."_".$APP_DATA['c024'].".pdf";
		    
		    if($docGeneradoPDF !=""){
			    $respuesta[$z]["docGeneradoPDF"]   = $docGeneradoPDF;
			    $respuesta[$z]["nombre_Documento"] = $nombre_Documento;
			    $respuesta[$z]["c008"] = $APP_DATA['c008'];
			    $respuesta[$z]["c066"] = $APP_DATA['c066'];
			    $respuesta[$z]["c009"] = $APP_DATA['c009'];
			    $respuesta[$z]["c025"] = $APP_DATA['c025'];
			    $respuesta[$z]["c024"] = $value['NRO_DOC'];
			    $respuesta[$z]["c127"] = $APP_DATA['c127'];
			    $respuesta[$z][0] =$value; 
			}else{
				echo "ERROR :".$value['PROCESO']."<br>";
			}
		    $z++;
        }

		return $respuesta;
	}

	public function GetDocumentoManual($id_proceso){
		$PM_SERVER = $this->get_bpm_config("IP");
		
		$sql ="SELECT doc.*, app.APP_NUMBER , doc.APP_DOC_UID FROM app_document as doc , application as app where app.APP_NUMBER = '".$id_proceso."' and app.APP_UID =doc.APP_UID and doc.APP_DOC_FIELDNAME ='c037'";
		$query  = $this->db->query($sql);
		$rw = $query->row_array();
		$url =array();

		if(count($rw)>0){
		   $url["doc"]="http://".$PM_SERVER.":8000/".$rw['APP_UID']."/".$rw['APP_DOC_UID']."_1.pdf";
		}
		return $url;
	}

	public function GetDocumentoAnexos_bpm($id_proceso){
		$PM_SERVER = $this->get_bpm_config("IP");
		
		$sql ="SELECT doc.*, app.APP_NUMBER , doc.APP_DOC_UID FROM app_document as doc , application as app where app.APP_NUMBER = '".$id_proceso."' and app.APP_UID =doc.APP_UID and doc.APP_DOC_FIELDNAME = 'c037' ";

		echo $sql."<br>";

		$query  = $this->db->query($sql);

		$rw = $query->result_array();
		$url =array();
		if(count($rw)>0){
			foreach ($rw as $key => $value){
			$url[$key]["doc"]    = "http://".$PM_SERVER.":8000/".$value['APP_UID']."/".$value['APP_DOC_UID']."_1.pdf";
			}
		}
		else
		{
			
			$sql ="SELECT doc.*, app.APP_NUMBER , doc.APP_DOC_UID FROM app_document as doc , application as app where app.APP_NUMBER = '".$id_proceso."' and app.APP_UID =doc.APP_UID and doc.APP_DOC_FIELDNAME = 'Adjuntos_1_adjunto'";
			$query  = $this->db->query($sql);
			$rw 	= $query->result_array();

			if(count($rw)>0){
				foreach ($rw as $key => $value){
					$url[$key]["doc"]    = "http://".$PM_SERVER.":8000".$value['APP_UID']."/".$value['APP_DOC_UID']."_1.pdf";
				}
			}
		}
		//$url["doc"]   ="ftp://172.31.100.80/10140991258cad78f6668f8068104465/36724853558cad83bbaf654076502768_1.pdf";
		return $url;
	}


	public function buscarDelegacionByAPP_NUMBER($APP_NUMBER){
		$sql   ="SELECT app.* , a.* , u.* FROM app_delegation as app INNER JOIN application as a on app.APP_UID = a.APP_UID INNER JOIN users u on app.USR_UID = u.USR_UID  WHERE a.APP_NUMBER='".$APP_NUMBER."' AND app.DEL_THREAD_STATUS = 'CLOSED' GROUP BY app.USR_UID order by app.DEL_DELEGATE_DATE ASC";
        $grupo = $this->db->query($sql);

        //echo $sql;

		$data  = $grupo->result_array();
		return $data;
	}



	public function firmarDocumentoMoverServer(){
		libxml_disable_entity_loader(false);


		/******************************************************************************************/	
		///////////Ingresar los numeros de caso separados por coma  ,    //////
		/******************************************************************************************/
		$procesos = array('15263','14980','14865','14828','15189','15332','15286','15372','15368','15382','15388','15317','15312','15301','15371','15390');

		$IP_WS = '172.31.100.76';

		if(count($procesos)>0){

			foreach ($procesos as $llave => $val){
				$sql       = $this->db->query("SELECT *  FROM APPLICATION WHERE APP_NUMBER =".$val);
				$resAPP    = $sql->result_array();
				$appTable  = unserialize($resAPP[0]["APP_DATA"]);
				//$appTable  = $resAPP["APP_DATA"];

				$opts = array('http'=>array('user_agent' => 'PHPSoapClient'));
				$context = stream_context_create($opts);
				$wsdlUrl = 'http://'.$IP_WS.'/WS00103_MergePDF/WS00103_MergePDF.asmx?wsdl';
				$soapClientOptions = array('stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE);

				$client1  = new SoapClient($wsdlUrl, $soapClientOptions);

				$docGeneradoPDF = "";
				//echo "<pre>";
				//print_r($appTable['search_query_merge']);
				//echo "</pre>";

				

				/******************************************************************************************/	
				///////////Descomentar esto seccion solo cuando se quieran generar las nuevas imagenes//////
				/******************************************************************************************/


				//$resultado 	  = $client1->mergePDF($appTable['search_query_merge']);
				//$docGeneradoPDF = $resultado->mergePDFResult->pathArchivo;
				//$docGeneradoPDF = str_replace("ftp://172.31.100.143:24","172.31.100.143/Imagenes",$docGeneradoPDF);

				if($appTable["c008"] =="CL01"){
					$appTable["c008"] =1;
				}else{
					$appTable["c008"] =24;
				}

				echo $appTable["c008"].";"; // sociedad CL01 isapres CL24 vida tres   
 				echo $appTable["c009"].";"; //RUT PROVEEDOR 
				echo $val.";";				//"NUMERO PROCESo   =".
				echo $appTable["c024"].";"; //"NUMERO DOCUMENTO =".
				echo $docGeneradoPDF.";";   //"URL DOCUMENTO    =".

				echo "<br>";
				
				
			}
		}
	}
}


/* End of file server_model.php */
/* Location: ./application/models/matenedor_model.php */