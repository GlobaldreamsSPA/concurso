<?php

class Custom_options_model extends CI_Model
{
	private $table = "custom_options"; //la taba desde la cual se consultará
	
    function __construct()
    {
        parent::__construct();
    }
	
	
	/*Funcion para recuperar las opciones asociadas a una pregunta*/
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

	/* Funcion para insertar una opcion asociada a una pregunta */
	function insert($id_question, $option_text)
	{
		$data = array(
		'option' => $option_text,
		'custom_questions_id' => $id_question
				);

		return $this->db->insert($this->table, $data);
	}
	
}

?>