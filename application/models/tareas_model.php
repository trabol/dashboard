<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tareas_model extends CI_Model {
	private $db_PM;
	public function __construct()
	{
		parent::__construct();
		$this->db_PM = $this->load->database('workflow', TRUE); 
	}

	public function getSociedades(){
		$this->db->select('*');
        $this->db->from('adt_sociedades');
        $this->db->where('ESTADO',1);
        $query     = $this->db->get();
		$sociedades = $query->result_array();
		return $sociedades;
	}

	public function getUserBygrupo($grupo){
		//conusltamoa base worflow
		$sql ="SELECT * FROM (USERS U LEFT JOIN GROUP_USER GU ON U.USR_UID=GU.USR_UID) LEFT JOIN CONTENT C ON GU.GRP_UID=C.CON_ID WHERE C.CON_VALUE='".$grupo."'";
		$query = $this->db_PM->query($sql);
    	$row   = $query->result_array();
		return $row;
	}
	public function getGrupoTareas(){
		$sql1  = "SELECT * from bpm_adt_grupo_tareas GROUP by NUMERO_PLANTILLA";
		$query = $this->db->query($sql1);
    	$row   = $query->result_array();
    	return $row;
	}
	public function nuevoGrupoTareas($data,$nombreGrupo){

		$sql1  = "SELECT * from bpm_adt_grupo_tareas GROUP by NUMERO_PLANTILLA";
		$query = $this->db->query($sql1);
    	$row   = $query->result_array();
		$ESTADO = false;
		if(count($row)==0){
		   $contador =1;
		}else{
			$contador = count($row)+1;
		}
		if(count($data)>0){
			$sql =array();																							
			foreach ($data as $key => $value){
				$sql["NUMERO_PLANTILLA"]  = $contador;
				$sql["NOMBRE_TAREA"]      = $nombreGrupo;
				$sql["DESCRIPCION_TAREA"] = $value["descripcion"];
				$sql["SOCIEDAD"]          = $value["sociedades"];
				$sql["USER_RESPONSABLE"]  = $value["userGrupo"];
				$sql["ACTIVO"] = 1;
				$this->db->insert('bpm_adt_grupo_tareas', $sql);
			}
			$ESTADO = true;
		}
		return $ESTADO;
	}
	public function getGrupoTareasBYID($ID_GRUPO){
		$data = array();
		$sql1  = "SELECT  * from bpm_adt_grupo_tareas  as bpm , adt_sociedades  as soc where bpm.`SOCIEDAD` = soc.SOCIEDAD and bpm.NUMERO_PLANTILLA ='".$ID_GRUPO."' and ACTIVO =1";

		$query = $this->db->query($sql1);
    	$row   = $query->result_array();

    	if(count($row)>0){
    		foreach ($row as $key => $value) {
    			$consulta = "SELECT * from users where USR_UID='".$value['USER_RESPONSABLE']."'";
    			$query    = $this->db_PM->query($consulta);
    			$row[$key]["USER"] = $query->result_array();
    		}
    		$data = $row;
    	}
    	//pr($data);
    	return $data;
	}
	public function enviarTareasUser($ID_GRUPO){

		$tareas = $this->getGrupoTareasBYID($ID_GRUPO);

		$this->load->model('workflow_model');
		$this->workflow_model->createNuevoCaso();
	}
	public function nuevaEmpresa($var = array()){

		$sql["NOMBRE"]      = $var["NOMBRE"];
		$sql["CODIGO"]      = $var["CODIGO"];
		$sql["FECHA"]       = date("Y-m-d H:i:s");
		$sql["ACTIVO"] 		= 1;
		$estado 			= 0;

		if($var["NOMBRE"]!=""){
		   $estado = $this->db->insert('bpm_odt_empresa', $sql);
		}
		return $estado;
	}
	public function editarEmpresa($var=array()){
		$sql["NOMBRE"]      = $var["NOMBRE"];
		$sql["CODIGO"]      = $var["CODIGO"];
		$this->db->where('ID', $var["ID"]);
		$estado = $this->db->update('bpm_odt_empresa', $sql);
		return $estado;
	}
	public function eliminarEmpresa($IDEMP){
		//Cuando elminado solo debemos cambiar el estado 0
		//esto se aplica para todas la tablas
		echo $IDEMP;
		$sql["ACTIVO"]      = 0;
		$this->db->where('ID', $IDEMP);
		$estado = $this->db->update('bpm_odt_empresa', $sql);
		return $estado;
	}
	public function  getAllEmpresas(){

		$this->db->select('*');
        $this->db->from('bpm_odt_empresa');
        $this->db->where('ACTIVO',1);
        $query      = $this->db->get();
		$sociedades = $query->result_array();
		return $sociedades;
	}
	public function findEmpresaByID($ID){

		$empresa = array();
		$this->db->select('*');
        $this->db->from('bpm_odt_empresa');
        $this->db->where('ACTIVO',1);
        $this->db->where('ID',$ID);
        $query      = $this->db->get();
		$data = $query->result_array();

		if(count($data)>0){
		  $empresa = $data;
		}
		return $empresa;
	}
}
function pr($arra){
	echo "<pre>";
	print_r($arra);
	echo "</pre>";
}
?>