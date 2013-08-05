<?php

class Custom_answers_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function save($data, $apply_id)
    {
        $this->db->insert('custom_answers', array('answer' => $data['answer'], 'custom_questions_id' => $data['custom_questions_id'], 'apply_id' => $apply_id));
    }

    function retrieve($custom_questions_id)
    {
    	$this->db->select('*');
    	$this->db->where('custom_questions_id', $custom_questions_id);
		
		$query = $this->db->get("custom_answers");
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
    }
}