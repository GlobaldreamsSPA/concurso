<?php

class Casting_categories_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /* Funcion utilizada para recuperar el id de la categoria utilizando el nombre de la misma */
	function get_id_by_name($name)
	{
		$this->db->select('id');
		$this->db->from('castings_categories');
		$this->db->where('name',$name);
		$query = $this->db->get()->first_row('array');
		return $query['id'];
    	
	}
	
    /* Funcion utilizada para recuperar el nombre de la categoria utilizando el id de la misma */
	function get_name($id)
	{
		$this->db->select('name');
		$this->db->from('castings_categories');
		$this->db->where('id',$id);
		$query = $this->db->get()->first_row('array');
		return $query['name'];
    	
	}
	
	/* Funcion utilizada para recuperar la lista de categorias de concursos	*/
	function get_casting_categories()
    {
    	$this->db->select('id,name');
    	$query= $this->db->get('castings_categories');
    	
		$result = array();
		

		foreach ($query->result_array() as $item)
		{
			$result[$item['id']] = $item['name'];
		}
		return $result;
		
    }
}