<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class conexion_workflow extends CI_Model 
{
	function __construct() 
	{
		parent::__construct();
	}	
	function usuarios_prueba()
	{
        //con esta línea cargamos la base de datos prueba
        //y la asignamos a $db_prueba
		$db_prueba = $this->load->database('workflow', TRUE);
        //y de esta forma accedemos, no con $this->db->get,
        //sino con $db_prueba->get que contiene la conexión
        //a la base de datos prueba
		$usuarios = $db_prueba->get('content');
		foreach($usuarios->result() as $fila)
		{
			$data[] = $fila;
		}
		return $data;
	}

}	