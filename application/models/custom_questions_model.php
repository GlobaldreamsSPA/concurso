<?php

class Custom_questions_model extends CI_Model
{
	private $table = "custom_questions"; //la taba desde la cual se consultará
	
    function __construct()
    {
        parent::__construct();
    }
	
	function getQuestion($idQuestion)
	{
		$this->db->select('*');
    	$this->db->where('id', $idQuestion);
		
		$query = $this->db->get($this->table);
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
	}
	
	function getQuestionsBy($id_casting,$by=NULL)
	{
		$this->db->select('*');
		if(!is_null($by))
		{
			switch($by)
			{
				case 'type':
					$this->db->where('type', $by);
					break; 
			}
		}
		
		$this->db->where('idcasting', $id_casting);
		
		$query = $this->db->get($this->table);
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
	}
	
		
	function insert($casting_id, $question_data)
	{
		$data = array(
		'type' => $question_data['tipo'],
		'text' => $question_data['texto'],
		'idcasting' => $casting_id
		);

		$this->db->insert($this->table, $data);//realiza el insert
		return $this->db->insert_id(); //devuelve el valor del id insertado
	}
	
	function delete($id_question)
	{
		$this->db->delete($this->table, array('id' => $id_question));
	}
	
	function update($id_question, $new_value)
	{
		$data = array(
				'type' => $new_value[''],
				'text' => $new_value[''],
				'id_casting' => $new_value['']
			);

		$this->db->where('id', $id_question);
		$this->db->update($this->table, $data);
	}
}

?>