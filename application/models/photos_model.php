<?php

class Photos_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert($photo)
    {
      $this->db->insert('photos',$photo);
      return $this->db->insert_id();
    }
	function delete($photo_id)
    {
    	$this->db->delete('photos', array('id' => $photo_id));
		
    }
	
	function purgar($from, $id_photo)
	{
		$file = "";
		if($from == 1)//desde carpeta profile
		{
			//$id_photo pasa a ser el nombre directamente
			$file = LOCAL_USER_PROFILE_IMAGE.$id_photo;
		}
		else//desde carpeta gallery
		{
			$name = $this->get_name($id_photo);
			$file = LOCAL_GALLERY.$name;
			
		}
		unlink($file);
	}

	
	function update($photo)
    {
    	$data = array(
				'name' => $photo['name'],
				'description' => $photo['description']
			);

		$this->db->where('id', $photo['id']);
		$this->db->update('photos', $data);
    }

    function get_photos($user_id=NULL)
    {
    	$this->db->select('*');
		if(!is_null($user_id))
			$this->db->where('user_id', $user_id);
		$query = $this->db->get('photos');
		
        $results = $query->result_array();
        return $results;
    }
	
	function get_name($id)
	{
		$this->db->select('name');
		$this->db->from('photos');
		$this->db->where('id',$id);
		$query = $this->db->get()->first_row('array');
		return $query['name'];
    	
	}
	
	function get_last_indicator($id_user) //obtiene el valor "indicador" del name "userid_indicador.formato" de la última foto subida por el usuario
	{
		$this->db->select('name');
		$this->db->from('photos');
		$this->db->where('user_id',$id_user);
		$this->db->order_by('id',"desc");
		$query = $this->db->get()->first_row('array');
		$resultado = explode(".",$query['name']);
		
		$resultado_dos = explode("_",$resultado[0]);
		return $resultado_dos[1];//retorna el valor indicador del "name" de la foto guardado en la base de datos
    	
	}
	
    
}