<?php
Class Hunter_model extends CI_Model
{

   function __construct()
   {
     parent::__construct();
   }

   /* Funcion de inicio de sesion del usuario para crear concursos*/
   function login($email, $password)
   {
     $this->db->select('id, name, email, password, about_us, logo');
     $this->db->from('entities');
     $this->db->where('email', $email);
     $this->db->where('password', MD5($password));
     $this->db->limit(1);

     $query = $this->db->get();
     $first_row = $query->first_row('array');

     if($query->num_rows() > 0)
     {
       return $first_row;
     }
     else
     {
       return false;
     }
   }


  /* Funcion utilizada para la actualizacion del perfil del usuario creador de concursos*/
  function update($profile)
  {
  	$data = array(
  			'name' => $profile['name'],
  			'email' => $profile['email'],
  			'address' => $profile['address'],
  			'about_us' => $profile['about_us']
  		);

  	$this->db->where('id', $profile['id']);
  	$this->db->update('entities', $data);
  }

  /* Funcion utilizada para recuperar los datos del usuario creador de concursos*/
	function select($id)
	{
		//Rescatar los datos de la tabla entities
		$this->db->select('name, email, address,about_us,logo');
		$this->db->from('entities');
		$this->db->where('id', $id);
		$query = $this->db->get()->first_row('array');

		return $query;
	}

}
?>