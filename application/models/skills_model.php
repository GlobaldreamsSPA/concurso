<?php

class Skills_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_skills()
	{
		$this->db->select('id, name');
		$query = $this->db->get('skills');

		$result = array();

		foreach ($query->result_array() as $item)
		{
			$result[$item['id']] = $item['name'];
		}

		return $result;
	}

	function get_user_skills($id)
	{
		$this->db->select('skills.name');
		$this->db->from('skills');
		$this->db->join('users_skills', 'users_skills.skill_id = skills.id');
		$this->db->join('users', 'users.id = users_skills.user_id');
		$this->db->where('users.id', $id);
		$query = $this->db->get();

		$result = array();

		foreach ($query->result_array() as $item)
		{
			$result[] = $item['name'];
		}

		return $result;
	}

	function get_user_skills_id($id)
	{
		$this->db->select('skills.id');
		$this->db->from('skills');
		$this->db->join('users_skills', 'users_skills.skill_id = skills.id');
		$this->db->join('users', 'users.id = users_skills.user_id');
		$this->db->where('users.id', $id);
		$query = $this->db->get();

		$result = array();

		foreach ($query->result_array() as $item)
		{
			$result[] = $item['id'];
		}

		return $result;
	}
	
	function get_name($id)
	{
		$this->db->select('name');
		$this->db->from('skills');
		$this->db->where('id',$id);
		$query = $this->db->get()->first_row('array');
		return $query['name'];
    	
	}

	function link_skills($profile)
	{
		//Primero borrar todas las habilidades linkeadas del usuario anteriormente existentes
		$this->db->delete('users_skills', array('user_id' => $profile['id']));


		foreach ($profile['skills'] as $skill)
		{
			$data = array(
					'user_id' => $profile['id'],
					'skill_id' => $skill
				);

			//Verificar que el par no exista en la BD
			$this->db->select('user_id, skill_id');
			$this->db->from('users_skills');
			$this->db->where('user_id', $data['user_id']);
			$this->db->where('skill_id', $data['skill_id']);

			$result = $this->db->get();

			if($result->num_rows() == 0)
				$this->db->insert('users_skills',$data);
		}

		
	}

	function filter_user_categories($users,$skills, $page=null, $cant=5)
	{
    	$this->db->select('user_id, count(user_id)');
		$flag = FALSE;
		$where = "(";
		
		foreach ($users as $user) 
		{
			if($flag)
				$where=$where." OR ";
			$where = $where." user_id= ".$user;
			$flag =TRUE;
		}
		$where = $where.")";
		$this->db->where($where, NULL, FALSE);	
		
		$flag = FALSE;		
		$where = "(";
		foreach ($skills as $skill) 
		{
			if($flag)
				$where=$where." OR ";
			$where = $where." skill_id= ".$skill;
			$flag =TRUE;
		}
		$where = $where.")";
		
		$this->db->where($where, NULL, FALSE);
		
		$this->db->group_by("user_id"); 

		$this->db->order_by("count(user_id)", "desc"); 
		
		
		if(!is_null($page)){
			$this->db->limit($cant,($page-1)*$cant);
		}
		
		$query = $this->db->get("users_skills");

		if($query->num_rows == 0)
			return 0;
		else
		{
			$temp=array();

			foreach ($query->result_array() as $value) {

				$temp[$value["user_id"]]= $value["user_id"];
			}

			return $temp;
		}
			
	}
	
	
}