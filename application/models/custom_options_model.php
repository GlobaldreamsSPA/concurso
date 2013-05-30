<?php

class Custom_options_model extends CI_Model
{
	private $table = "custom_options"; //la taba desde la cual se consultará
	
    function __construct()
    {
        parent::__construct();
    }
	
	function getOption($idOption)
	{
		$this->db->select('*');
    	$this->db->where('id', $idOption);
		
		$query = $this->db->get($this->table);
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
	}
	
	
	function getOptionsByQuestion($idQuestion)
	{
		$this->db->select('*');
    	$this->db->where('custom_questions_id', $idQuestion);
		
		$query = $this->db->get($this->table);
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
	}
	
	function insert($id_question, $option_text)
	{
		$data = array(
		'option' => $option_text,
		'custom_questions_id' => $id_question
				);

		return $this->db->insert($this->table, $data);
	}
	
	function delete($idOption)
	{
		$this->db->delete($this->table, array('id' => $idOption));
	}
	
	function update($new_data, $idOption)
	{
		$data = array(
				'option' => $new_data['opcion_value'],
				'custom_questions_id' => $new_data['id_pregunta']
			);

		$this->db->where('id', $idOption);
		$this->db->update($this->table, $data);
	}
}

?>