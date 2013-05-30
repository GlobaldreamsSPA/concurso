<?php

class Likes_model extends CI_Model
{
    function __construct() 
    {
        parent::__construct();
    }

    function insert($user_id,$like_data)
	{
		$data = array(
			'user_id' => $user_id,
			'name' => $like_data['name'],
			'category' => $like_data['category']
			);

	
		return $this->db->insert('likes', $data);
	}

}