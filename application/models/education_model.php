<?php

class Education_model extends CI_Model
{
    function __construct() 
    {
        parent::__construct();
    }

    function insert($user_id,$education_data)
	{
		$data = array(
			'user_id' => $user_id,
			'type' => $education_data['school']['name'],
			'name' => $education_data['type']
			);



		if(isset($education_data['concentration']))
		{
			$data['career']="";
			$flag=0;
          	foreach ($education_data['concentration'] as $speciality) 
          	{
          		if($flag > 0)
          			$data['career'] = $data['career']." - ";
            	$data['career'] = $data['career'].$speciality['name'];
        		$flag+=1;
        	}
        }
	
		return $this->db->insert('education', $data);
	}

}