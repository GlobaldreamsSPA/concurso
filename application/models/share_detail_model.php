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

    function increase_counter($casting_id)
    {
        $this->db->select('visits, id');
        $this->db->from('share_detail');
        $this->db->where('casting_id', $casting_id);
        $query = $this->db->get();

        $share_detail = $query->first_row('array');

        $share_detail['visits'] = $share_detail['visits'] + 1;

        $this->db->where('id', $share_detail['id']);
        $this->db->update('share_detail', array('visits' => $share_detail['visits']));
    }
}