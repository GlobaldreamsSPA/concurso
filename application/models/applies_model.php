<?php

class Applies_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_applies_cant($casting_id)
    {
    	$this->db->where('casting_id', $casting_id);
    	$this->db->from('applies');
    	return $this->db->count_all_results();
    }


    function get_ncontest_by_sex($casting_id)
    {
    	$this->db->select('IF(sex = 0, "femenino", "masculino" ) as sex,COUNT(user_id) as number',false);
    	$this->db->where('casting_id', $casting_id);
    	$this->db->group_by('sex');
    	$this->db->from('applies');
		$this->db->join('users', 'users.id = applies.user_id');
		$query = $this->db->get();

		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
    }

    function get_ncontest_by_age($casting_id)
    {
    	$this->db->select('YEAR(birth_date) as year,COUNT(user_id) as number');
    	$this->db->where('casting_id', $casting_id);
    	$this->db->group_by('YEAR(birth_date)');
    	$this->db->from('applies');
		$this->db->join('users', 'users.id = applies.user_id');
		$query = $this->db->get();

		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
    }

    function get_ncontest_by_date($casting_id)
    {
    	$this->db->select('count(id) as number,date(timestamp) as date');
    	$this->db->where('casting_id', $casting_id);
    	$this->db->group_by('date(timestamp)');

    	$query= $this->db->get('applies');
    	
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
    }

    function get_ncontest_by_hour($casting_id)
    {
    	$this->db->select('count(id) as number,hour(timestamp) as hour');
    	$this->db->where('casting_id', $casting_id);
    	$this->db->group_by('hour(timestamp)');

    	$query= $this->db->get('applies');
    	
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
    }
	
	function get_applicant_applies($applicant_id)
    {
    	$this->db->select('id,casting_id,state');
    	$this->db->where('user_id', $applicant_id);
    	$query= $this->db->get('applies');
    	
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
		
    }

    function verify_apply($user_id, $casting_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('casting_id', $casting_id);
		$query = $this->db->get('applies');

		//Si el usuario no ha postulado retorna 1
		if($query->num_rows == 0)
			return 0;
		else
			return 1;
	}
	
	function get_castings_applies($casting_id,$page,$state=null,$cant=5)
	{
		$this->db->select('user_id,id,state');
    	$this->db->where('casting_id', $casting_id);
		
	    if(!is_null($state) && $state!=3)
    		$this->db->where('state', $state);

    	if(!is_null($page))
    		$query = $this->db->get('applies', $cant, ($page-1)*$cant);
		else
		   	$query = $this->db->get('applies');
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
		
	}
	
	function get_short_user_applies($casting_id,$state=NULL) //para sacar la información utilizada en casting_details
	{
		$this->db->select('user_id');
    	$this->db->where('casting_id', $casting_id);
		
    	if(is_null($state))
    	{
    		$this->db->where('state',0); //evita aceptados y rechazados
    		$query = $this->db->get('applies',5);		
    	}
   		else
   		{
   			$this->db->where('state',$state);
   			$query = $this->db->get('applies',5);
   		}
		   	
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
		
	}
	
	
	function count_casting_applies($casting_id,$state)
 	{
 		$this->db->select('id');
 	   	$this->db->where('casting_id', $casting_id);
 		
 		if($state != 3)
 	   		$this->db->where('state', $state);
 	 	
 	 	$query = $this->db->get('applies');
 	 	
 	 	return $query->num_rows;
	}
	
	/**
	 * @desc Verifica el estado de cada "apply" de un respectivo casting y retorna "true" si cada "apply" tiene estado distinto de 0.
	 * Retorna -1 si no recibe parametros
	 * */
	function verify_castings_applies_status($parametro)//se verifica si le paso el ID o un array de applies
	{
		if(is_array($parametro))
		{
			//es array, lo analizadirectamente
			$todos = $parametro;		
		}
		else
		{
			//Saca los applies del id_casting(parametro) recibido
			$todos = $this->get_castings_applies($parametro);	
		}
		
		//los revisa y si algun(status) es 0 retorna FALSO
		foreach ($todos as $apply) 
		{
			if($apply['state'] == 0)
			{
				return FALSE;
			}
		}
		//si no se salio => todos los "state" son distintos de 0
		return true;		
	}
	
	function get_selected($casting_id)
	{
		$this->db->select('user_id');
    	$this->db->where('casting_id', $casting_id);
		$this->db->where('state', 1);	
		$query = $this->db->get('applies');
		
		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
		
	}

	function verify_video_apply($video_id, $user_id)
	{
		$this->db->select('castings.*');
		$this->db->from('castings');
		$this->db->join('applies', 'applies.casting_id = castings.id');
		$this->db->join('videos_applies', 'videos_applies.apply_id = applies.id');
		$this->db->where('videos_applies.video_id', $video_id);
		$this->db->where('applies.user_id', $user_id);
		$this->db->group_by('castings.id');
		$query = $this->db->get();

		//Verificar que este video no este ingresado en una postulacion activa
		foreach($query->result_array() as $casting) {
			if($casting['active'] == 1)
			{
				return FALSE;
			}
		}
		return TRUE;
	}

	function apply($user_id, $casting_id)
	{
		//Verificar que el usuario no postule dos veces
		$this->db->select('id');
		$this->db->from('applies');
		$this->db->where('user_id', $user_id);
		$this->db->where('casting_id', $casting_id);
		$query = $this->db->get();

		if($query->num_rows() == 0)
		{
			//Crear postulacion (apply)
			$apply = array(
					'observation' => '',
					'user_id' => $user_id,
					'casting_id' => $casting_id,
					'state' => 0
				);

			$this->db->insert('applies', $apply);

			//Obtener el max id de apply
			$this->db->select_max('id');
			$apply_result = $this->db->get('applies')->first_row('array');

			return $apply_result['id'];
		}
		else
			return FALSE;
	}

	function delete($apply_id, $user_id)
    {
    	/* Primero verificar la categoria del casting */
    	
    	//Rescatar el casting
    	$this->db->select('*');
    	$this->db->from('applies');
    	$this->db->where('id', $apply_id);
    	$query = $this->db->get();
    	$apply = $query->first_row('array');
    	$casting_id = $apply['casting_id'];

    	//Rescatar la categoria del casting
    	$this->db->select('*');
    	$this->db->from('castings');
    	$this->db->where('id', $casting_id);
    	$query = $this->db->get();
    	$casting = $query->first_row('array');
    	$category = $casting['category'];

    	//Si la categoria es 1, se borra la foto de la BD, de disco y el apply
    	if(strcmp($category, "1") == 0)
    	{
    		//Buscar la foto y borrarla de disco
    		$this->db->select('*');
    		$this->db->from('photos');
    		$this->db->where(array('user_id' => $user_id, 'casting_id' => $casting_id));
    		$query = $this->db->get();
    		$photo = $query->first_row('array');
    		$photo_name = $photo['name'];

    		//Borrar archivo de disco
    		$photo_path = realpath(APPPATH.CONTEST_PHOTO_DIR.'/'.$photo_name);
    		unlink($photo_path);

    		//Borrar la row de la BD
    		$this->db->delete('photos', array('id' => $photo['id']));
    	}

    	//Se borra el apply share y el apply
    	if(strcmp($category, "2") == 0)
    	{
    		$this->db->delete('share_apply', array('apply_id' => $apply_id));
    	}

    	//Se borran las custom answers y se borra el apply
    	if(strcmp($category, "3") == 0)
    	{
    		$this->db->delete('custom_answers', array('apply_id' => $apply_id));
    	}

    	//Borrar el apply
    	$this->db->delete('applies', array('id' => $apply_id));
    	return TRUE;
    }
	
	function set_accepted($apply_id,$observation)
	{
		$data = array(
               'state' => 1,
               'observation' => $observation
            );

		$this->db->where('id', $apply_id);
		$this->db->update('applies', $data); 
	}

	function set_rejected($apply_id)
	{
		$data = array(
               'state' =>2,
               'observation' => NULL			   
            );

		$this->db->where('id', $apply_id);
		$this->db->update('applies', $data); 
	}

}