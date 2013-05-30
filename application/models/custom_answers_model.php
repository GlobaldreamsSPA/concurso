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
}