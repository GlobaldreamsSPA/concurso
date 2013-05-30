<?php

class Video_categories_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

    }

    function get()
    {
    	$this->db->select("*");
        $query = $this->db->get("video_categories");
       
        $result = array();

        foreach ($query->result_array() as $item)
        {
            $result[$item['id']] = $item['name'];
        }

        return $result;
    }
}