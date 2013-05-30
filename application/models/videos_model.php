<?php

class Videos_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

	function update($id_video,$titulo_video,$descripcion,$categories)
	{
		$data = array(
               'title' => $titulo_video,
               'description' => $descripcion,
               'categories' => $categories
            );

		$this->db->where('id', $id_video);
		$this->db->update('videos', $data); 
	}
	
    function insert($data)
    {
    	//Primero verificar que el video no exista
    	$this->db->select('id');
    	$this->db->from('videos');
    	$this->db->where('link', $data['link']);

    	$result = $this->db->get();

    	if($result->num_rows() == 0)
    	{
			$this->db->insert('videos', $data);
			$video_id= $this->db->insert_id();

			$this->db->select('*');
			$this->db->where('user_id', $data['user_id']);
	    	$this->db->from('videos');

	    	$validate = $this->db->get();

	    	if($validate->num_rows() == 1)
				return $video_id;
			else 
				return 0;
		}
		else
		{
			return 0;
		}

		
	}

    function delete($video_id)
    {
    	$this->db->delete('videos', array('id' => $video_id));
		
    }

    //Verifica que el usuario tenga al menos un video
    function verify_videos($user_id)
	{
		$this->db->select('id');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('videos');

		//Retorna 0 si no tiene videos
		if($query->num_rows == 0)
			return 0;
		else
			return 1;
	}

	//Verifica que el video pertenezca al usuario user_id
	function verify_user_video($youtube_video_id, $user_id)
	{
		$this->db->select('id');
		$this->db->where('link', $youtube_video_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('videos');

		//Retorna 0 si el video no pertenece al usuario
		if($query->num_rows == 0)
			return 0;
		else
			return 1;
	}

	//Retorna los datos del primer video que pertenece al usuario
	function get_video($id_user)
	{
		$this->db->where('user_id', $id_user);
		$query = $this->db->get('videos')->first_row('array');

		return $result;
	}

	function search_videos($search, $page, $cant)
	{
		$this->db->select('*,count(id),upvotes - downvotes as votes');
		
		if($search["search_terms"])
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

		if($search["category"] != "")
				$this->db->like('categories', $search["category"]);



		if($search["order"] != "")
			$this->db->order_by($search["order"], "desc");	
		else
			$this->db->order_by("count(id)", "desc");	


		
		$this->db->group_by('id');

		$query = $this->db->get('videos', $cant, ($page-1)*$cant);
		$result = array();
		foreach ($query->result_array() as $value) 
		{
			$result[] = array($value['title'], $value['link'], $value['user_id'],$value['description'],$value['id'],$value['reproductions']);
		}
		return $result;
	}

	function count_search_videos($search)
	{
		$this->db->select('*,upvotes - downvotes as votes');
		
		if($search["search_terms"])
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

		if($search["category"] != "")
				$this->db->like('categories', $search["category"]);

		
		$this->db->group_by('id');

		$query = $this->db->get('videos');
		
		return $query->num_rows();
	}


	function get_video_applicant($id_user)
	{
		$this->db->where('user_id', $id_user);
		$query = $this->db->get('videos')->first_row('array');
		$result["video_id"]=$query['link'];
		return $result;
	}
	
	/*
	 * Saca el "link" del video utilizado en la postulación(apply)
	 */
	function get_applied_video_applicant($id_user,$id_casting)
	{
		$this->db->from('applies');
		$this->db->join('videos_applies', 'applies.id = videos_applies.apply_id');
		$this->db->join('videos', 'videos_applies.video_id = videos.id');
		$this->db->where('videos.user_id', $id_user);
		$this->db->where('applies.casting_id', $id_casting);
		$query = $this->db->get()->first_row('array');
		$result["video_id"]=$query['link'];
		return $result;
	}
	

	function get_video_id($youtube_video_id)
	{
		$this->db->select('id');
		$this->db->where('link', $youtube_video_id);
		$query = $this->db->get('videos')->first_row('array');

		return $query['id'];
	}
	
	function get_main_video($id_video)
	{
		$this->db->select('*');
		$this->db->where('id', $id_video);
		$query = $this->db->get('videos');
		if($query->num_rows() > 0)
		{
			$results = $query->result_array();
			return $results[0];
		}else return false;
	}
	

	function get_videos($page, $cant)
	{
		$this->db->select('*');
		$this->db->order_by('id', "desc");
		$query = $this->db->get('videos', $cant, ($page-1)*$cant);
		$result = array();
		foreach ($query->result_array() as $value) 
		{
			$result[] = array($value['title'], $value['link'], $value['user_id'],$value['description'],$value['id'],$value['reproductions']);
		}
		return $result;
	}
	
	/*
	 * Se le pasa un array de skills
	 */
	function get_videos_by_skills($page, $cant,$skills_actual=NULL)
	{
		//la consulta
		// select V.id as id_video,V.user_id,title,link,type,description,Us.skill_id from videos as V inner join users_skills as Us on V.user_id = Us.user_id where skill_id =2 OR skill_id=1 OR skill_id=5 OR skill_id=4 group by id_video;
		$this->db->select('V.id as id_video,V.user_id,V.title,V.link,V.type,V.description,Us.skill_id,count(V.id)');
		$this->db->from('videos AS V');
		$this->db->join('users_skills AS Us', 'V.user_id = Us.user_id', 'INNER');
		
		if(!is_null($skills_actual)){
			$flag = FALSE;
			$where = "";
			foreach ($skills_actual as $iter) 
			{
				if($flag)
					$where=$where." OR ";
				$where = $where." skill_id= ".$iter;
				$flag =TRUE;
			}
			
			$this->db->where($where, NULL, FALSE);
		}
		
		$this->db->order_by("count(V.id)", "desc");	
		$this->db->group_by('id_video');
		$query = $this->db->get('videos', $cant, ($page-1)*$cant);
		$result = array();

		foreach ($query->result_array() as $value) 
		{
			$result[] = array($value['title'], $value['link'], $value['user_id']);
		}
		
		return $result;
	}
	
	function count_videos_by_skills($skills_actual=NULL)
	{
		//la consulta
		// select V.id as id_video,V.user_id,title,link,type,description,Us.skill_id from videos as V inner join users_skills as Us on V.user_id = Us.user_id where skill_id =2 OR skill_id=1 OR skill_id=5 OR skill_id=4 group by id_video;
		$this->db->select('V.id as id_video,Us.skill_id');
		$this->db->from('videos AS V');
		$this->db->join('users_skills AS Us', 'V.user_id = Us.user_id', 'INNER');
		
		if(!is_null($skills_actual)){
			$flag = FALSE;
			$where = "";
			foreach ($skills_actual as $iter) 
			{
				if($flag)
					$where=$where." OR ";
				$where = $where." skill_id= ".$iter;
				$flag =TRUE;
			}
			
			$this->db->where($where, NULL, FALSE);
		}
		
		$this->db->group_by('id_video');
		$query = $this->db->get('videos');

		
		return $query->num_rows;
	}
	
	function get_videos_by_user($id_user,$page,$cant=8)
	{
		$this->db->select('*');
		$this->db->where('user_id',$id_user);
		$query = $this->db->get('videos', $cant, ($page-1)*$cant);
		$result = array();
		foreach ($query->result_array() as $value) 
		{
			$result[] = array($value['title'], $value['link'], $value['description'],$value['id'],$value['reproductions'],$value['categories']);
		}
		return $result;
	}

	function count_videos_by_user($id_user)
	{
		$this->db->select('*');
		$this->db->where('user_id',$id_user);
		$query = $this->db->get('videos');
	
		return $query->num_rows;
	}

	function count()
	{
		return $this->db->count_all_results('videos');
	}

	function get_all_videos()
	{
		$query = $this->db->get('videos');
		$result["video_id"]=$query['video_id'];
		$result["video_title"] = $query['title'];
		$result["video_description"] = $query['description'];

		return $result;
	}

	function get_videos_update_creation()
	{
		$this->db->select('id,link');
		$this->db->where('creation_date', '0000-00-00');			
		$query = $this->db->get('videos');
		return $query->result_array();
	}

	function update_date($data)
	{
		$info = array(
               'creation_date' => $data["date"]
            );

		$this->db->where('id', $data["id"]);
		$this->db->update('videos', $info); 
	}

	function get_videos_update_repro()
	{
		$this->db->select('id,link');
		$query = $this->db->get('videos');

		return $query->result_array();
	}

	function update_repro($data)
	{
		$info = array(
               'reproductions' => $data["views"]
            );

		$this->db->where('id', $data["id"]);
		$this->db->update('videos', $info); 
	}

	function get_votes($id)
	{
		$this->db->select('upvotes,downvotes');
		$this->db->where('id', $id);	
		$query = $this->db->get('videos');

		return $query->result_array();
	}


	function update_votes($data)
	{
		$flag=TRUE;

		if($data["type"] == 1)
		{
			$this->db->select('upvotes');
			$this->db->where('id',$data["video_id"]);
			$query = $this->db->get('videos');
			$info["upvotes"] = $query->result_array();
			$info["upvotes"] = (int) $info["upvotes"][0]["upvotes"];
			$info["upvotes"] = $info["upvotes"] + 1;


		}elseif($data["type"] == 0)
		{
			$this->db->select('downvotes');
			$this->db->where('id',$data["video_id"]);
			$query = $this->db->get('videos');
			$info["downvotes"] = $query->result_array();
			$info["downvotes"] = (int) $info["downvotes"][0]["downvotes"];
			$info["downvotes"] = $info["downvotes"] + 1;
		}
		else
			$flag=FALSE;
			

		if($flag)
		{	
			$this->db->where('id', $data["video_id"]);
			$this->db->update('videos', $info); 
		}
	}
}