<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class layout_modal extends CI_Model {

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

	public function buscar_modulosByUser(){
		
		$sql ="SELECT * from menu_modulos as m inner join user_menu_modulos as us  on m.id = us.id_modulo where us.id_user ='".$_SESSION['USR_LOGGED']."' and us.estado =1 group by m.id";
		$query = $this->db->query($sql);
		$menu  = $query->result_array();
		$row   = array();
		if(count($menu)>0){
			foreach($menu as $key => $value){

				$sql ="select * from user_menu_modulos as us inner join sub_menu_modulos as s on us.id_sud_modulo = s.id where us.id_user ='".$_SESSION['USR_LOGGED']."' and us.estado =1 and us.id_modulo ='".$value['id_modulo']."'";
				$query = $this->db->query($sql);
				$row   = $query->result();
				if(count($row)>0){
					$menu[$key]["subMenu"] =$row;
				}
			}
		}
		return $menu;
	}
}

/* End of file server_model.php */
/* Location: ./application/models/server_model.php */