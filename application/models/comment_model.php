<?php

class Comment_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_comment($user_id, $comment)
    {
    	$this->db->select('timestamp');
    	
    	$this->db->insert('comments', array('user_id' => $user_id, 'comment' => $comment));
    	return 2;
    }
}