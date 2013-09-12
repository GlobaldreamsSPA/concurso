<?php

class Applies_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*Funcion que retorna la cantidad de concursantes por concurso, utilizada principalmente para
    mostrar el estado del concurso*/
    function get_applies_cant($casting_id)
    {
    	$this->db->where('casting_id', $casting_id);
    	$this->db->from('applies');
    	return $this->db->count_all_results();
    }

    /* Funcion para setear el numero del concursante para los sorteos */
    function set_postulation_number($casting_id)
    {
        $this->db->select('id');
        $this->db->where('casting_id', $casting_id);
        $this->db->order_by('id',"asc");
        $this->db->from('applies');
        $results = $this->db->get();
        
        if($results->num_rows != 0)
        {
            $results = $results->result_array();

            $counter= 1;

            foreach ($results as $apply) {
                $this->db->where('id', $apply["id"]);
                $this->db->update('applies', array('postulation_number' => $counter ));
                $counter= $counter + 1;
            }
        }
    }


    /*Funcion que calcula el alcance posible de los concursos de compartir sumando la cantidad de amigos
    de cada participante*/
    function get_share_reach($casting_id)
    {
    	$this->db->select('SUM(number_friends) as number');
    	$this->db->where('casting_id', $casting_id);
    	$this->db->group_by('casting_id');
    	$this->db->from('applies');
		$this->db->join('users', 'users.id = applies.user_id');
		$query = $this->db->get();

		if($query->num_rows == 0)
			return 0;
		else
		{
			$return = $query->result_array();
			return  $return[0]["number"];
    	}
    }


    /*Funcion que retorna los datos utilizados para las estadisticas de concurso: Sexo vs Postulaciones*/
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

    /*Funcion que retorna los datos utilizados para las estadisticas de concurso: Edad vs Postulaciones*/
    function get_ncontest_by_age($casting_id)
    {
    	$this->db->select('(YEAR(CURDATE()) - YEAR(birth_date)) as age,COUNT(user_id) as number');
    	$this->db->where('casting_id', $casting_id);
    	$this->db->group_by('YEAR(birth_date)');
    	$this->db->order_by('age');
    	$this->db->from('applies');
		$this->db->join('users', 'users.id = applies.user_id');
		$query = $this->db->get();

		if($query->num_rows == 0)
			return 0;
		else
			return $query->result_array();
    }

    /*Funcion que retorna los datos utilizados para las estadisticas de concurso: Fecha vs Postulaciones*/
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

    /*Funcion que retorna los datos utilizados para las estadisticas de concurso: Hora del dia vs Postulaciones*/
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
	
	/*Funcion utilizada para recuperar todas las postulaciones de un usuario a un concurso*/
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

    /*Funcion utilizada para validar que un concursante solo participe una vez por concurso*/
    function verify_apply($user_id, $casting_id)
	{
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$this->db->where('casting_id', $casting_id);
		$query = $this->db->get('applies');

		if($query->num_rows == 0)
			return FALSE;
		else
			return TRUE;
	}
	
	/*Funcion utilizada para actualizar tabla de postulantes*/
	function get_castings_applies_data_tables($casting_id,$from,$length,$search,$order,$direction)
	{
		$this->db->select('applies.postulation_number as number, photos.name as image_profile, CONCAT(users.name," ", users.last_name) as full_name, users.email as email, applies.user_id as user_id',false);
		$this->db->join('users', 'users.id = applies.user_id');
		$this->db->join('photos', 'photos.user_id = applies.user_id', 'left');
    	$this->db->where('applies.casting_id', $casting_id);	
        $this->db->where('photos.casting_id', null);    
    	$this->db->where('state', 0);

		if(!is_null($search))
		{
			$where = '(CONCAT(users.name," ", users.last_name) LIKE "%'.$search.'%" OR applies.postulation_number LIKE "%'.$search.'%" )';
			$this->db->where($where); 
		}
		if(!is_null($order))
    		$this->db->order_by('applies.id',$direction);

    	if(!is_null($from))
    		$query = $this->db->get('applies', $length, $from);
		else
		   	$query = $this->db->get('applies');
		

		if($query->num_rows == 0)
			return null;
		else
			return $query->result_array();
		
	}

	/*Funcion a utilizar, puesto que debe haber una parte del concurso para ver el ganador y sus 
	datos de contacto*/	
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

	/*Funcion utilizada para guardar la postulacion de un concursante,
	 es utilizada para todos los concursos*/
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

	/* Funcion utilizada para borrar la postulacion del concursante, funciona para todos los tipos
	 de concursos actualmente*/
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
    	if(strcmp($category, "3") == 0 || strcmp($category, "4") == 0)
    	{
    		$this->db->delete('custom_answers', array('apply_id' => $apply_id));
    	}

    	//Borrar el apply
    	$this->db->delete('applies', array('id' => $apply_id));
    	return TRUE;
    }


}