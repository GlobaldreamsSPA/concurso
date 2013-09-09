<?php

class Custom_questions_model extends CI_Model
{
	private $table = "custom_questions"; //la tabla desde la cual se consultará
	
    function __construct()
    {
        parent::__construct();
    }
	
	/* Funcion utilizada para recuperar las preguntas de un concurso en especifico */	
	function getQuestionsBy($id_casting)
	{
		$this->db->select('*');
		$this->db->where('idcasting', $id_casting);
		
		$query = $this->db->get($this->table);
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
	}
	
	/* Funcion utilizada para insertar una pregunta asociada a un concurso*/
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
	
}

?>