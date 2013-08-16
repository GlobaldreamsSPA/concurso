<?php

class Castings_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert($casting)
    {
      $this->db->insert('castings',$casting);
      return $this->db->insert_id();
    }

	
	function update($casting,$id)
    {
		$this->db->where('id', $id);
		$this->db->update('castings', $casting);
    }

    function _routes($casting, $full_image = FALSE)
    {
        $casting['logo'] = HOME.HUNTER_PROFILE_IMAGE.$this->_get_hunter_logo($casting['entity_id']);
        
        if($full_image == TRUE)
            $casting['full_image'] = HOME.CASTINGS_FULL_PATH.$casting['image'];
        $casting['image'] = HOME.CASTINGS_PATH.$casting['image'];
        
        return $casting;
    }

    function _days($casting)
    {
        $end_date = date_create($casting['end_date']);
        $today = new DateTime(date('Y-m-d'));
        $interval = $this->date_diff($today->format('Y-m-d'), $end_date->format('Y-m-d'));
        $casting['days'] = $interval;
        if($interval < 0)
            $casting['days'] = 0;
        return $casting;
    }

    function _has_started($casting)
    {
        $interval = strtotime($casting['start_date']) - strtotime("now");
        
        if($interval > 0)
        {
            $casting['has_started'] = FALSE;
            $casting['interval'] = $interval;
        }
        else
        {
            $casting['interval'] = 0;
            $casting['has_started'] = TRUE;
        }

        return $casting;
    }

	function check_status_active($casting_id)
	{
		$this->db->select('*');
        $this->db->where('id', $casting_id);
		$this->db->where('status', 0);		
        $result = $this->db->get('castings');
		
		if($result->num_rows == 0)
			return FALSE;
		else
			return TRUE;
	}
	
    function insert_image($casting_id, $filename)
    {
        $data = array('image' => $filename);
        $this->db->where('id', $casting_id);
        $this->db->update('castings', $data);
    }

    function count_castings($hunter_id=NULL,$status=NULL,$categories=NULL)
    {
    	$this->db->select('id');
        if(!is_null($hunter_id))
            $this->db->where('entity_id', $hunter_id);
		if(isset($status) && $status!= 3)
            $this->db->where('status', $status);
			
		if(!is_null($categories))
		{
			$flag = FALSE;
			$where = "(";
			foreach ($categories as $iter) 
			{
				if($flag)
					$where=$where." OR ";
				$where = $where." category= ".$iter;
				$flag =TRUE;
			}
			$where = $where.")";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by("category", "asc");
		}
		
		$query = $this->db->get('castings');
		
		return $query->num_rows;
		
    }

    function get_full_casting($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('castings');
        $result = $this->db->get();
        $casting = $result->first_row('array');
        
        //Almacenar los dias que quedan
        $casting = $this->_days($casting);

        //Analizar si el casting empezo o todavia no
        $casting = $this->_has_started($casting);

        //Entregar las rutas de las imagenes
        $casting = $this->_routes($casting, TRUE);

        //Buscar datos del hunter: department
        $this->db->select('department');
        $this->db->from('entities');
        $this->db->where('id', $casting['entity_id']);
        $result = $this->db->get();
        $hunter = $result->first_row('array');
        $casting['department'] = $hunter['department'];
        $casting['status'] = $this->_get_status($casting);
        return $casting;
    }

    function get_castings($hunter_id=NULL, $cant=NULL, $page=NULL, $status=NULL, $categories=NULL)
    {
    	$this->db->select('*');
        
        if(!is_null($hunter_id))
            $this->db->where('entity_id', $hunter_id);

		if(isset($status) && $status!= 3)
            $this->db->where('status', $status);
		
				
		if(!is_null($categories))
		{
			$flag = FALSE;
			$where = "(";
			foreach ($categories as $iter) 
			{
				if($flag)
					$where=$where." OR ";
				$where = $where." category= ".$iter;
				$flag =TRUE;
			}
			$where = $where.")";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by("category", "asc");
		}
		
		
		

        if(!is_null($page) && !is_null($cant))
            $query = $this->db->get('castings', $cant, ($page-1)*$cant);
        else
            $query = $this->db->get('castings');

        $results = $query->result_array();

        foreach($results as &$casting)
        {
            //Almacenar los dias que quedan
            $casting = $this->_days($casting);

            //Analizar si el casting empezo o todavia no
            $casting = $this->_has_started($casting);

            //Entregar las rutas de las imagenes
            $casting = $this->_routes($casting ,TRUE);

            //Entregar estado del casting
            $casting['status'] = $this->_get_status($casting);
        }

        return $results;
    }

    function get_castings_search($search, $page=NULL, $cant=NULL)
    {
        $this->db->select('*');
                
        if($search["category"] != "" && !is_null($search["category"]))
            $this->db->where('category', $search["category"]);
                
        if($search["prize"] != "" && !is_null($search["prize"]))
            $this->db->like('prizes',$search["prize"]);        
        
        if($search["search_terms"] && !is_null($search["search_terms"]))
        {
            $search_value = array();
            $search_value = explode(' ', $search["search_terms"]);
            $flag = FALSE;
            $where="";

            foreach ($search_value as $iter) 
            {
                if($flag)
                    $where= $where." OR `title` LIKE '%".$iter."%'"; 
                else
                    $where = "(`title` LIKE '%".$iter."%'";

                $flag =TRUE;
            }
            $where= $where.")";

            $this->db->where($where);
        }
        
        $this->db->order_by("start_date", "desc");


        if(!is_null($page) && !is_null($cant))
            $query = $this->db->get('castings', $cant, ($page-1)*$cant);
        else
            $query = $this->db->get('castings');

                
        $results = $query->result_array();



        foreach($results as &$casting)
        {
            //Almacenar los dias que quedan
            $casting = $this->_days($casting);

            //Analizar si el casting empezo o todavia no
            $casting = $this->_has_started($casting);

            //Entregar las rutas de las imagenes
            $casting = $this->_routes($casting ,TRUE);

            //Entregar estado del casting
            $casting['status'] = $this->_get_status($casting);

            $this->db->select('name');
            $this->db->from('entities');
            $this->db->where('id', $casting['entity_id']);
            $result = $this->db->get();
            $hunter = $result->first_row('array');
            $casting['entity'] = $hunter['name'];
      
        }

        return $results;
    }

    function get_castings_especific($ids_query,$status=NULL)
    {
    	$this->db->select();
        
		
		$where= "";
		$flag = FALSE;
		foreach ($ids_query as $ids_row) 
		{
			
			if($flag)
				$where=$where." OR ";
			$where = $where." id=".$ids_row['casting_id'];
			$flag =TRUE;
		}  
        
		$flag =FALSE;
		
		if(isset($status))
		{
			$where = "(".$where.") AND (";
			foreach ($status as $iter) 
			{
				if($flag)
					$where=$where." OR ";
				$where = $where." status =".$iter;
				$flag =TRUE;
			}
			$where = $where.")";
			
		}
        
		$this->db->where($where, NULL, FALSE);
        $query= $this->db->get('castings');
		
		$results = $query->result_array();
		
		foreach($results as &$casting)
        {
            //Almacenar los dias que quedan
            $casting = $this->_days($casting);

            //Analizar si el casting empezo o todavia no
            $casting = $this->_has_started($casting);

            //Entregar las rutas de las imagenes
            $casting = $this->_routes($casting ,TRUE);

            //Entregar estado del casting
            $casting['status'] = $this->_get_status($casting);
        }
		
		
        return $results;
    }

	function finalize_casting($id_casting) 
	{
		$data = array(
	        'status' => 2
        );

		$this->db->where('id', $id_casting);
		$this->db->update('castings', $data); 
	}


    function date_diff($start, $end="NOW")
    {
        $ts1 = strtotime($start);
        $ts2 = strtotime($end);

        $seconds_diff = $ts2 - $ts1;

        return floor($seconds_diff/3600/24);
    }

    private function _get_hunter_logo($hunter_id)
    {
        $this->db->select('logo');
        $this->db->from('entities');
        $this->db->where('id', $hunter_id);
        $query = $this->db->get();
        $query = $query->first_row('array');
        return $query['logo'];
    }

    function _get_status($casting)
    {
        
        switch($casting['status'])
        {
	        case '0':
		        $casting['status'] = 'Activo';
		        break;
	        case '1':
		        $casting['status'] = 'En Revisión';
		        break;
	        case '2':
		        $casting['status'] = 'Finalizado';
		        break;
        }
        
        return $casting['status'];
    }

    function elegir_ganadores($casting_id, $ganador_id)
    {
        //Analizar si el casting tiene status distinto de 2
        $casting = $this->db->select('status')->where('id', $casting_id)->get('castings')->first_row('array');
        
        if(strcmp($casting['status'], '2') != 0)
        {
            //Buscar Los applies y asignarles a todos state igual a 2
            $this->db->where('casting_id', $casting_id)->update('applies', array('state' => 2));
            
            //Buscar al ganador y asignarle estado 1
            $this->db->where('user_id', $ganador_id)->where('casting_id', $casting_id)->update('applies', array('state' => 1));
            //Asignar estado 2 al casting
            $this->db->where('id', $casting_id)->update('castings', array('status' => 2));
        }
    }
}