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



}