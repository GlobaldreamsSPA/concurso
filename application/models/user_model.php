<?php

class User_model extends CI_Model
{
    function __construct() 
    {
        parent::__construct();
    }

	function participants()
	{
		$this->db->select('users.id,id_main_video,name,last_name');
		$this->db->from('users');
		$this->db->join('videos', 'users.id = user_id');
		$this->db->distinct();
		$query = $this->db->get();
		return $query;

	}
		
	function get_image_profile($user_id)
	{
		$this->db->select('image_profile');
		$this->db->where('id', $user_id);
		$query = $this->db->get('users')->first_row('array');
		return $query['image_profile'];
	}
	
	function update($profile)
	{
		$data = array(
				'name' => $profile['name'],
				'email' => $profile['email'],
				'last_name' => $profile['last_name'],
			);

		$this->db->where('id', $profile['id']);
		$this->db->update('users', $data);
	}

	function update_detail($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}


	function select($id)
	{
		//Rescatar los datos de la tabla usuario
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get()->first_row('array');

		return $query;
	}

	function select_applicant($id)
	{
		//Rescatar los datos de la tabla usuario
		$this->db->select('id, name, last_name, sex, email, birth_date,image_profile');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get()->first_row('array');

		return $query;
	}

	function verifyfb_id($id_fb)
	{
		$this->db->select('id_fb, id');
		$this->db->from('users');
		$this->db->where('id_fb', $id_fb);
		$query = $this->db->get();
		
		if($query->num_rows == 0)
			return 0;

		else
			return $query->result_array();
				
	}

	function insert($fb_data,$friends_count)
	{
		$data = array(
			'id_fb' => $fb_data['id'],
			'name' => $fb_data['first_name'],
			'last_name' => $fb_data['last_name'],
			'email' => $fb_data['email'],
			'sex' => $fb_data['gender'],
			'facebook_profile_url' => $fb_data['link'],
			'birth_date' => $fb_data['birthday'],
			'location_language' => $fb_data['locale'],
			'number_friends' => $friends_count
			);
			
			//guarda el sexo como binario
			if($data['sex'] == 'male') $data['sex'] = 1;
			else $data['sex'] = 0;
			
			//cambia formato al date
			$data['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
			
			
		
	    if(isset($fb_data['hometown']))
	     	$data["hometown"] = $fb_data['hometown']['name']; 

	    if(isset($fb_data['location']))
	      	$data["location"] = $fb_data['location']['name']; 

	   
		$this->db->insert('users', $data);

		return $this->db->insert_id();
	}

	function update_profile_image($id_photo,$id_user)
	{
		$data = array(
				'image_profile' => $id_photo
		);

		$this->db->where('id', $id_user);
		$this->db->update('users', $data);
	}

	function get_name($id_user)
	{
		$this->db->select("name,last_name");
		$this->db->where("id",$id_user);
		$query = $this->db->get("users");
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
				

	}

	function has_rut($id_user)
	{
		$this->db->select("rut");
		$this->db->where("id",$id_user);
		$query = $this->db->get("users")->result_array();

		if(is_null($query[0]["rut"]))
			return false;
		else
			return true;
	}


}