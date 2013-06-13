<?php

class Share_detail_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert('share_detail', $data);
    }

    function select($columns,$where)
    {
        $this->db->select($columns);
        $this->db->from('share_detail');
        $this->db->where($where);
        $query = $this->db->get();

    	return $query->result_array();
    }
}