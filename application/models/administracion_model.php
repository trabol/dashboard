<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class administracion_model extends CI_Model {

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
	public function GetListaModulos(){
		$query = $this->db->query("SELECT * FROM `menu_modulos` WHERE  estado =1");
    	$row   = $query->result_array();
    	return $row;
	}
	public  function GetSubModulosBYUser($moduloUID)
	{

		$data  = array();
	    if($moduloUID!=""){
			$sql   = "SELECT * FROM `sub_menu_modulos` WHERE  ID_MODULO ='".$moduloUID."'";
			$query = $this->db->query($sql);
	    	$row   = $query->result_array();
	    	if(count($row)>0){
	    		$data = $row;
	    	}
    	}
    	return $data;
	}

	public function getSubMenuByUser($userUID , $moduloUID){

		$modulos = $this->GetSubModulosBYUser($moduloUID);
		if(count($modulos)>0){
			
			$sql = "SELECT *  FROM `user_menu_modulos` WHERE `id_user` ='".$userUID."'";
			//echo $sql; 
			$query = $this->db->query($sql);
	    	$row   = $query->result_array();
	    	
	    	if(count($row)>0){
	    		foreach ($modulos as $key => $value) {
	    			$modulos[$key]["estado"] = 0;
	    			foreach ($row as $r => $rv){

	    				if($value["ID"] == $rv["id_sud_modulo"]){
	    				   $modulos[$key]["estado"] = 1;
						}
	    			}
	    		}
	    	}
		}
		return $modulos;
	}

	public function updateUserSubModulo($data,$id_modulo,$userUID,$ID_PERFIL){

		//debemos elimnar todo lo modulos de estre isiairo para el modulo escogido 
		$sql   ="DELETE FROM user_menu_modulos where `id_modulo` = '".$id_modulo."' and `id_user` ='".$userUID."'";
		$query = $this->db->query($sql);

		if(count($data)>0){
			if($query){
				//Carafar los modulo nuevos
				$i =0;
				foreach ($data as $key => $value) {

					$new["id_sud_modulo"] = $key;
					$new["id_user"]       = $userUID;
					$new["id_modulo"]     = $id_modulo;
					$new["fecha"]         = date("Y-m-d H:i:s");
					$new["estado"]        = 1;
					$new["id_perfil"]     = $ID_PERFIL;
					
					$this->db->insert('user_menu_modulos',$new); 
					$i++;
				}
			}
		}
	}
}
?>