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
	
	function get_castings_applies_selected($casting_id)
	{
		$this->db->select('user_id,observation');
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
					'casting_id' => $casting_id
				);

			$this->db->insert('applies', $apply);

			//Obtener el max id de apply
			$this->db->select_max('id');
			$apply_result = $this->db->get('applies')->first_row('array');

			
			$this->db->select('id_main_video');
			$this->db->where('id', $user_id);
			$main_id_result = $this->db->get('users')->first_row('array'); //obtiene id_main_video
			if(!is_null($main_id_result['id_main_video']))//si no es null
			{
				$videos_result = array("id" => $main_id_result['id_main_video']);
			}
			else
			{
				//sino buscar el id del primer video del usuario
				$this->db->select_min('id');
				$this->db->where('user_id', $user_id);
				$videos_result = $this->db->get('videos')->first_row('array');
					
			}
			
			//Ahora crear el videos_applies
			$videos_applies = array(
					'apply_id' => $apply_result['id'],
					'video_id' => $videos_result['id']
				);

			$this->db->insert('videos_applies', $videos_applies);

			return $apply_result['id'];
		}
		else
			return FALSE;
	}

	function delete($apply_id)
    {
    	$this->db->delete('videos_applies', array('apply_id' => $apply_id));		
    	$this->db->delete('applies', array('id' => $apply_id));
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