<?php

class Prize_categories_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function select($columns)
    {
        $this->db->select($columns);
        $this->db->from('prize_categories');
        $query = $this->db->get();

    	return $query->result_array();
    }
}