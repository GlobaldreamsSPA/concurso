<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		error_reporting(0);

		$this->load->helper(array('url', 'form'));

		//Modelos
		$this->load->model(array('videos_model','video_votes_model','contact_model','photos_model','user_model', 'hunter_model', 'castings_model','applies_model','skills_model','casting_categories_model','custom_options_model','custom_questions_model', 'custom_answers_model'));
	
	}



	public function index($page=1)
	{

		/* Codigo para hacer feed, esta a medias

		$rss = new DOMDocument();
		$rss->load('http://www.viddon.com/blog/?cat=23&feed=rss2');
		
		$feed = array();
		foreach ($rss->getElementsByTagName('item') as $node) 
		{
			array_push($feed, $item);
		}
		
		*/
		$args = array();
		
		$args["get_uri"] ="";
		
		if(isset($_GET["search_terms"]))
		{
			
			$args["get_uri"] = "/?search_terms=".str_replace(' ', '+', $_GET["search_terms"])."&order=".$_GET["order"]."&category=".$_GET["category"];
			$args["search_values"]=$_GET;

			$video_list = $this->videos_model->search_videos($_GET, $page, 9);
			
			$args["chunks"]=ceil($this->videos_model->count_search_videos($_GET) / 9);
		}
		else
		{
			$args["search_values"]["search_terms"] = NULL;
			$args["search_values"]["order"] = NULL;
			$args["search_values"]["category"] = NULL;
			$video_list = $this->videos_model->get_videos($page, 9);
			$args["chunks"]=ceil($this->videos_model->count() / 9);


		}

		$args["video_list"] = array();
		
		foreach ($video_list as $video_data)
		{
			
			$user_data= $this->user_model->select($video_data["2"]);
			if($user_data['image_profile']!=0)
				$user_data['image_profile'] = $this->photos_model->get_name($user_data['image_profile']);

			$video_votes= $this->videos_model->get_votes($video_data["4"]);
			array_push($video_data,$user_data["name"],$user_data["image_profile"], $user_data["last_name"],$video_votes[0]["upvotes"],$video_votes[0]["downvotes"]);
			array_push($args["video_list"], $video_data);
		}
    
		
		$args["tags"]=	$this->skills_model->get_skills();
		
		
		$args["page"]=$page;
		
		$query= $this->user_model->participants();
		$ranking= array();
		foreach ($query->result() as $row)
		{

	
			
			$item["likes"] = $row->likes;
	

			$item["id"] = $row->id;
			$item["tags"] = $this->skills_model->get_user_skills($item["id"]);
			sort($item["tags"]);
			$item["image"] = $this->user_model->get_image_profile($row->id);
			$item["image"] = $this->photos_model->get_name($item["image"]);
			$item["video_id"] = $this->user_model->get_main_video_id($row->id);
			$item["video_id_y"] = $this->videos_model->get_main_video($item["video_id"]);
 			$item["video_title"] =$item["video_id_y"]["title"];
 			$item["video_description"] =$item["video_id_y"]["description"];
 			$item["video_reproductions"] = $item["video_id_y"]["reproductions"];
 			$item["video_id_y"] = $item["video_id_y"]["link"]; 			
 			$item["first_name"]= $row->name;
			$item["last_name"]= $row->last_name;
			$item["bio"] = $row->bio;
			$item["video"] = $row->id_main_video;
			$ranking[] = $item;
		}
		$args["castings"] = $this->castings_model->get_castings(NULL, 2, 1, 0);
		$args["ranking"] = $ranking;
    	$args["order_options"]= array("" => "", "creation_date" => "Los más nuevos", "votes" => "Los más votados", "reproductions" => "Los más vistos");
		$args["category_options"]= array(""=>"","1"=>"Canto","2"=>"Actuación","3"=>"Humor","5"=>"Cover","6"=>"Instrumentos","7"=>"Danza","9"=>"Música","10"=>"Grupo","8"=>"Otros");
		$args["content"] = "home/home_view";
		$args["inner_args"] = NULL;
		$this->load->view('template',$args);
	}


	public function casting_list($page = 1,$actual_categories = -2)//el actual es un string de categorias
	{
		$args = array();
		
		$args["actual_categories_url"] = $actual_categories;

		if($actual_categories!=-2)
		{			
			$args["actual_categories"] = explode("_",$actual_categories);//PARAMETROS FILTRO URL
			$args["chunks"]=ceil($this->castings_model->count_castings(NULL,0,$args["actual_categories"])/9);						
			$args["casting_list"]= $this->castings_model->get_castings(NULL, 9, $page, 0, $args["actual_categories"]);
		}else
		{
			$args["chunks"]=ceil($this->castings_model->count_castings(NULL,0)/9);			
			$args["actual_categories"] = $actual_categories;			
				
			$args["casting_list"]= $this->castings_model->get_castings(NULL, 9, $page, 0, NULL);		
		}		
		
		$args["categories_cant"] = $this->casting_categories_model->get_casting_categories_cant();//cuantas categorias
		$args["categories"] = $this->casting_categories_model->get_casting_categories();//carga la lista de categorias
		
	
		$temp[-1]= "--  Seleccionar Todos  --";
		$temp[-2]= "--     Vaciar Campo    --";
		
		$args["categories"] = $temp + $args["categories"];
		
		$args["page"]=$page;

		$args['content']='home/castings_list';
		$args["inner_args"]=NULL;
		
		$this->load->view('template',$args);
	}

	public function likes_update()
	{

		$query= $this->user_model->participants();
		foreach ($query->result() as $row)
		{

	
			$url = "http://www.viddon.com/user/index/".$row->id;
			$fqlResult = json_decode(file_get_contents("http://api.facebook.com/method/fql.query?query=select+total_count+from+link_stat+where+url='$url'&format=json"));

			$data["likes"] = $fqlResult[0]->total_count;
			$data["id"] = $row->id;

	
			$data["name"]= $row->name." ".$row->last_name;

			$this->user_model->update_likes($data);

			echo "NOMBRE: ".$data["name"];
			echo "<br>";
			echo "ID: ".$data["id"];
			echo "<br>";
			echo "LIKES: ".$data["likes"];
			echo "<br>";
			echo "<br>";


		}

	}

	public function video_reproductions_update()
	{

		$query= $this->videos_model->get_videos_update_repro();
		foreach ($query as $video)
		{
			$JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video['link']}?v=2&alt=json");
			$JSON_Data = json_decode($JSON);
			$data=array();
			$data["id"]= $video["id"];
			if(array_key_exists('yt$statistics', $JSON_Data->{'entry'}))
			{
				$data["views"] = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};
			}
			else
			{
				$data["views"] = "0";
			}		
	
			$this->videos_model->update_repro($data);

			echo "idvideo: ".$data["id"];
			echo "<br>";
			echo "reproducciones: ".$data["views"];
			echo "<br>";
			echo "<br>";

		}

	}

	public function video_creation_date_update()
	{

		$query= $this->videos_model->get_videos_update_creation();
		foreach ($query as $video)
		{
			$JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video['link']}?v=2&alt=json");
			$JSON_Data = json_decode($JSON);
			$data=array();
			$data["id"]= $video["id"];
			
			$data["date"] = $JSON_Data->{'entry'}->{'published'}->{'$t'};
			$data["date"] = substr($data["date"],0,10);

			$this->videos_model->update_date($data);

			echo "idvideo: ".$data["id"];
			echo "<br>";
			echo "fecha: ".$data["date"];
			echo "<br>";
			echo "<br>";

		}

	}

	public function vote($type,$video_id)
	{
		if(isset($video_id) && isset($type))
		{
			$data["ip"] = $_SERVER['REMOTE_ADDR'];
			$data["video_id"] = $video_id;


			if(!$this->video_votes_model->ip_time_check($data["ip"],$data["video_id"]))
			{
				$data["type"] = $type;
				if($this->session->userdata('id'))
					$data["user_id"] = $this->session->userdata('id');

				$this->videos_model->update_votes($data);
				
				$this->video_votes_model->insert($data);
			}

			$new_votes_count= $this->videos_model->get_votes($video_id);

			echo $new_votes_count[0]["upvotes"]."-".$new_votes_count[0]["downvotes"];


		}		
		else
			redirect(HOME);
	}


	public function login_hunter()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_message('required', 'Este campo es obligatorio');
		$this->form_validation->set_message('valid_email', 'Este campo debe ser un correo v&aacute;lido');

		$this->form_validation->set_rules('contact_name', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('contact_email', 'Correo', 'required|xss_clean|valid_email');
		$this->form_validation->set_rules('contact_message', 'Mensaje', 'required|xss_clean');

		if($this->form_validation->run() != FALSE)
		{
			$data= array();
			$data["nombre"] =$_POST["contact_name"];
			$data["email"] =$_POST["contact_email"];
			$data["mensaje"] =$_POST["contact_message"];

			$this->contact_model->insert($data);

			$args["flag"]=true;

			
		}

		$args['content'] = 'home/login_hunter';
		$args['inner_args'] = NULL;
		$this->load->view('template',$args);
	}

	public function what_is()
	{
		$args['content'] = 'home/what_is';		
		$args["inner_args"]=NULL;
		$this->load->view('template',$args);
	}


	public function video()
	{
		if(isset($_GET['id']))
		{
			$args['id_video'] = $_GET['id'];		
			$args['name'] = $_GET['name'];		
			$args['description'] = $_GET['description'];
			$args['username'] = $_GET['username'];	
			$args['userlastname'] = $_GET['userlastname'];		
			$args['image'] = $_GET['image'];	
			$args['iduser'] = $_GET['iduser'];
			$args['id_bdd_video'] = $_GET['id_bdd'];	
			$args['video_reproductions'] = $_GET['video_reproductions'];	
			$votes = $this->videos_model->get_votes($args['id_bdd_video']);
			$args['upvotes'] = $votes[0]['upvotes'];	
			$args['downvotes'] = $votes[0]['downvotes'];	
						


			$this->load->view('home/video_modal',$args);
		}
	}

	public function video_ranking()
	{
		if(isset($_GET['id']))
		{
			$args['id_video'] = $_GET['id'];		
			$args['title'] = $_GET['title'];			
			$args['iduser'] = $_GET['iduser'];
			$args['id_bdd_video'] = $_GET['id_bdd'];
			$args['video_reproductions'] = $_GET['video_reproductions'];
			$args['description'] = $_GET['description'];
			$votes = $this->videos_model->get_votes($args['id_bdd_video']);	
			$args['upvotes'] = $votes[0]['upvotes'];	
			$args['downvotes'] = $votes[0]['downvotes'];	
		
			$this->load->view('home/video_modal_ranking',$args);
		}
	}

	public function terms()
	{
		$args['content'] = 'home/terms';		
		$args["inner_args"]=NULL;
		$this->load->view('template',$args);
	}

	public function casting_detail($id)
	{
		if(is_numeric($id))
		{
			$args["casting"] = $this->castings_model->get_full_casting($id);
			$args["casting"]["applies"] = $this->applies_model->get_applies_cant($id);
			
			$args["temp"][-1]= "--  Seleccionar Todos  --";
			$args["temp"][-2]= "--     Vaciar Campo    --";
			
			//carga las preguntas custom de este casting
			$custom_questions = $this->custom_questions_model->getQuestionsBy($id);
			$custom_options = array();
			if($custom_questions != 0)
				for($i =0; $i < count($custom_questions); $i++)
				{
					$custom_options[$i] = array('id' => $custom_questions[$i]['id'], 'type' => $custom_questions[$i]['type'], 'text' => $custom_questions[$i]['text'], 'options' => array());
					$opciones = $this->custom_options_model->getOptionsByQuestion($custom_questions[$i]['id']);

					if((!$opciones == 0))
					{
						//hay opciones
						foreach ($opciones as $option) {
							$custom_options[$i]['options'][] = array('id' => $option['id'], 'option' => $option['option']);	
						}
					}
				}

			else
				$custom_options = FALSE;

			$args['custom_options'] = $custom_options;
		}

		
		if($this->session->userdata('msj'))
		{
			$args["postulation_message"]=$this->session->userdata('msj');		
			$this->session->unset_userdata('msj');
		}
		
		$gender_interpreter= array("Ambos","Masculino","Femenino");		
		$args["castings"] = $this->castings_model->get_castings(NULL, 2, 1, 0);
		if(isset($args["casting"]['sex']))
			$args["casting"]['sex'] = $gender_interpreter[$args["casting"]['sex']]; 

		if(isset($args["casting"]["skills"]))
		{
			$args["tags"]=	$this->skills_model->get_skills();
			$tags_id= explode('-', $args["casting"]["skills"]);
			$tags_id_temp=array();
			foreach ($tags_id as $tag) {
				array_push($tags_id_temp, $args["tags"][$tag]);
			}
			$args["tags"]=$tags_id_temp;
		}
		
		$args["content"]="home/casting_detail";
		$args["inner_args"]=NULL;

		$this->load->view('template',$args);
	}

	public function apply_casting($id_casting)
	{
		if($this->session->userdata('id'))
		{
			if($this->session->userdata('type'))
			{
				if($this->castings_model->check_status_active($id_casting))			
				{
					if ($this->videos_model->verify_videos($this->session->userdata('id')) != 0) 
					{
						$apply_id = $this->applies_model->apply($this->session->userdata('id'), $id_casting);

						if($apply_id !== FALSE)
						{
							$postulation_message = "Postulaci&oacute;n Exitosa.";
							//Ahora guardas las preguntas custom
							foreach($this->input->post() as $post_data_name => $post_data_answ)
							{
								$data = explode("_", $post_data_name);
								echo "<br>";
								var_dump($data);
								if(strcmp($data[1], "text") == 0 || strcmp($data[1], "select") == 0)
								{
									$answers['custom_questions_id'] = $data[3];
									
									if(strcmp($post_data_answ, "") != 0)
										$answers['answer'] = $post_data_answ;
									else
										$answers['answer'] = "omite";

									$this->custom_answers_model->save($answers, $apply_id);
								}
								if(strcmp($data[1], "multiselect") == 0)
								{
									$answers['custom_questions_id'] = $data[3];
									$answers['answer'] = "";
									
									foreach ($post_data_answ as $answ) {
										if(strcmp($answ,"") != 0)
											$answers['answer'] = $answers['answer'].$answ.", ";
									}
									
									$answers['answer'] = substr($answers['answer'], 0, -2);
									$this->custom_answers_model->save($answers, $apply_id);
								}
							}
						}
						else
							$postulation_message = "Ya Postulaste a este Casting.";
					}
					else
						$postulation_message = "No tienes un video para poder postular.";
				}
				else
					$postulation_message = "Casting no activo";
			}
			else
				$postulation_message = "No eres un postulante.";
				
		}
		else 
			$postulation_message = "Debes iniciar sesi&oacute;n";
				
		$this->session->set_userdata('msj', $postulation_message);
		redirect(HOME."/home/casting_detail/".$id_casting);
	}
}