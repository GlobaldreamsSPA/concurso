<?php

class Video_votes_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    } 

    function insert($data)
    {
		$this->db->insert('video_votes', $data);

    }

    function ip_time_check($ip,$video_id)
    {
    	$this->db->select("id");
    	$this->db->where("ip",$ip);
        $this->db->where("video_id",$video_id);

    	$this->db->where("TIMESTAMPDIFF(MINUTE,timestamp,now()) <", "20");
    	$query = $this->db->get('video_votes');

		if($query->num_rows == 0)
			return FALSE;
		else
			return TRUE;    
	}

}