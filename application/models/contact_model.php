<?php

class Contact_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /* Funcion que almacena los contactos enviados por las personas en el sitio */
    function insert($data)
    {    	
    	$this->db->insert('contact',$data);
    }
}