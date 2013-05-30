<?php

class Casting_categories_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

	function get_id_by_name($name)
	{
		$this->db->select('id');
		$this->db->from('castings_categories');
		$this->db->where('name',$name);
		$query = $this->db->get()->first_row('array');
		return $query['id'];
    	
	}
	
	function get_name($id)
	{
		$this->db->select('name');
		$this->db->from('castings_categories');
		$this->db->where('id',$id);
		$query = $this->db->get()->first_row('array');
		return $query['name'];
    	
	}
	
    function get_casting_categories_cant()
    {
    	$this->db->from('castings_categories');
    	return $this->db->count_all_results();
    }
	
	/**
	 * Si $id_casting es NULL =>Saca todo de todas las categorias
	 */
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