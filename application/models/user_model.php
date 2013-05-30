<?php

class User_model extends CI_Model
{
    function __construct() 
    {
        parent::__construct();
    }

	function get_main_video_id($id_user)
	{
		$this->db->select('id_main_video');
		$this->db->where('id', $id_user);
		$query = $this->db->get('users')->first_row('array');
		return $query['id_main_video'];
	}
		
	function participants()
	{
		$this->db->select('users.id,bio,likes,id_main_video,name,last_name');
		$this->db->from('users');
		$this->db->join('videos', 'users.id = user_id');
		$this->db->distinct();
		$query = $this->db->get();
		return $query;

	}
		
	function has_main_video($id_user)
	{
		if($this->get_main_video_id($id_user) == NULL)
		{
			return false;
		}else return true;
	}
	
	function set_main_video($id_user,$id_video_nuevo=NULL)
	{
			$data = array(
				'id_main_video' => $id_video_nuevo
			);

		$this->db->where('id', $id_user);
		$this->db->update('users', $data);
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
				'bio' => $profile['bio']
			);

		$this->db->where('id', $profile['id']);
		$this->db->update('users', $data);
	}


	function update_likes($data)
	{
		$info = array(
				'likes' => $data['likes']
			);

		$this->db->where('id', $data['id']);
		$this->db->update('users', $info);
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
		$this->db->select('id, name, email, image_profile, bio');
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

	function insert($fb_data)
	{
		$data = array(
			'id_fb' => $fb_data['id'],
			'name' => $fb_data['first_name'],
			'last_name' => $fb_data['last_name'],
			'email' => $fb_data['email'],
			'sex' => $fb_data['gender'],
			'facebook_profile_url' => $fb_data['link'],
			'birth_date' => $fb_data['birthday'],
			'location_language' => $fb_data['locale']
			);
			
			//guarda el sexo como binario
			if($data['sex'] == 'male') $data['sex'] = 1;
			else $data['sex'] = 0;
			
			//cambia formato al date
			$data['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
			
			
		if(isset($fb_data['religion']))
       		$data["religion"]=$fb_data['religion']; 
   		
   		if(isset($fb_data['political']))
        	$data["political"]=$fb_data['political']; 

    	if(isset($fb_data['bio']))
        	$data["bio"] = $fb_data['bio']; 

	    if(isset($fb_data['hometown']))
	     	$data["hometown"] = $fb_data['hometown']['name']; 

	    if(isset($fb_data['location']))
	      	$data["location"] = $fb_data['location']['name']; 

	    if(isset($fb_data['relationship_status']))
        	$data["relationship_status"] = $fb_data['relationship_status']; 

	
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

	
	function welcome_name($id_user)
	{
		$result = $this->select($id_user);

		if($result["name"] != NULL)
			return $result["name"];
		if($result["email"] != NULL)
			return $result["email"];
		
		return 'Usuario';
	}

	function filter_user($filtered_ids,$sex,$age_range,$name,$page=null,$cant=5)
	{
		$this->db->select("id");		
		//SEXO
		if(!is_null($sex)) //genera la condicion where ( sex = N or sex = P) y la adjunta a string
		{
			$flag = FALSE;
			$sex_where="(";
			foreach ($sex as $sexi) 
			{
				if($flag)
					$sex_where=$sex_where." OR ";
				$sex_where = $sex_where." sex=".$sexi;
				$flag =TRUE;
			}
			$sex_where=$sex_where.")";
			$this->db->where($sex_where,NULL,FALSE);//se agrega a la consulta		
		}
		
		//EDAD
		if(!is_null($age_range))
		{

			$age_list= array(0=>"10",1=>"10-15",2=>"15-20",3=>"20-25",4=>"25-30",5=>"30-35",6=>"35-40",7=>"40");	

			$rango_variable = array();
			$flag = FALSE;
			$age_where = "("; 
						
			foreach ($age_range as $edad) 
			{
				if($flag)
					$age_where= $age_where." OR ";

				switch($edad)//dependiendo de la clave seleccionada
				{
					case 0://si es la primera
						$rango_variable=array(0=>0,1=>$age_list[$edad]);//hace que sea desde 0 a el valor inicial
						break;
					case (sizeof($age_list)-1)://si es la ultima
						$rango_variable=array(0=>$age_list[$edad],1=>200);//hace que sea desde el valor maximo a 200
						break;
					default://si es de los internos lo separa tal cual
						$rango_variable=explode("-", $age_list[$edad]);
						break;
				}
				$age_where = $age_where." FLOOR(DATEDIFF(CURDATE(),STR_TO_DATE(birth_date,'%Y-%m-%d'))/365) BETWEEN ".$rango_variable[0]." AND ".$rango_variable[1];
				$flag =TRUE;
			}
			$age_where = $age_where.")";
			$this->db->where($age_where,NULL,FALSE);//se agrega a la consulta		
		}



		//WHERE DE NOMBRES O PALABRAS
		if($name != "")
		{
			$name = explode(" ", $name);
			$flag = FALSE;
			$name_where = "("; 
			
			foreach ($name as $word) 
			{
				if($flag)
					$name_where=$name_where." OR ";
				$name_where = $name_where." name LIKE '%".$word."%'";
				$flag =TRUE;
			}
			$name_where = $name_where.")"; 
			$this->db->where($name_where,NULL,FALSE);//se agrega a la consulta		

		}

		$flag = FALSE;
		$users_where = "(";
		foreach ($filtered_ids as $user_id) 
		{
			if($flag)
				$users_where=$users_where." OR ";

			$users_where = $users_where." id = ".$user_id["user_id"];
			$flag =TRUE;
		}
		$users_where=$users_where.")";
		$this->db->where($users_where,NULL,FALSE);//se agrega a la consulta		
		
	
		if(!is_null($page)){
			$this->db->limit($cant,($page-1)*$cant);
		}
		
		$query = $this->db->get("users");

		if($query->num_rows == 0)
			return 0;
		else
		{
			$temp=array();

			foreach ($query->result_array() as $value) {

				$temp[$value["id"]]= $value["id"];
			}

			return $temp;
		}
	}

}