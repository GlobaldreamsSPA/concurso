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

    function retrieve($custom_questions_id, $sex = "",$from_age = 0,$to_age = 0)
    {
    	$this->db->select('answer,sex,YEAR(CURDATE()) - YEAR(birth_date) as age');
    	$this->db->where('custom_questions_id', $custom_questions_id);
        if($sex != "")
            $this->db->where('sex', $sex);
        if(($from_age != 0 && $to_age != 0) && ($from_age <= $to_age))
        {
            $this->db->having('age >=', $from_age);
            $this->db->having('age <=', $to_age);
               
        }

		$this->db->from("custom_answers");
		$this->db->join('applies', 'apply_id = applies.id');
        $this->db->join('users', 'users.id = user_id');

        $query = $this->db->get();
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
    }
}