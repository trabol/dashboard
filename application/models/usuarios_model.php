<?php
/**
* 
*/
class Usuarios_Model  extends CI_Model
{
	
	public function __construct()
    {
                // Call the CI_Model constructor
                parent::__construct();
    }
	public function getAll(){
		$result = $this->db->get('adt_tareas');
		$user   = $result->result_array();
		return $user;
	}	
}
?>