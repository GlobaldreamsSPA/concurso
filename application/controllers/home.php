<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//error_reporting(0);

		$this->load->helper(array('url', 'form'));

		//Modelos
		$this->load->model(array('videos_model','share_detail_model','prize_categories_model','video_votes_model','contact_model','photos_model','user_model', 'hunter_model', 'castings_model','applies_model','skills_model','casting_categories_model','custom_options_model','custom_questions_model', 'custom_answers_model'));
	
	}

	public function index($page=1)
	{
		$args = array();
		
		$args["get_uri"] ="";
		
		if(isset($_GET["search_terms"]))
		{

			$args["get_uri"] = "/?search_terms=".str_replace(' ', '+', $_GET["search_terms"])."&prize=".$_GET["prize"]."&category=".$_GET["category"];
			$args["search_values"]=$_GET;

			$args["contest_list"] = $this->castings_model->get_castings_search($_GET, $page, 9);
			
			$args["chunks"]=ceil(count($this->castings_model->get_castings_search($_GET)) / 9);
		}
		else
		{
			$args["search_values"]["search_terms"] = NULL;
			$args["search_values"]["prize"] = NULL;
			$args["search_values"]["category"] = NULL;		
			$args["contest_list"]  = $this->castings_model->get_castings_search($args["search_values"],$page, 9);
			$args["chunks"] = ceil(count($this->castings_model->get_castings_search($args["search_values"])) / 9);
		}		
    	
		$args["page"]=$page;

		$args["castings"] = $this->castings_model->get_castings(NULL, 1, 1, 0);

		$prizes =  $this->prize_categories_model->select("name");
		$counter=0;

		foreach ($prizes as $prize) {
			$args["prizes"][$counter] = $prize["name"];
			$counter = $counter + 1;
		}

		$args["prizes"] = array(""=>"Elige: tipo de premio") + $args["prizes"];
		$args['categories'] = array(""=>"Elige: tipo de concurso")+$this->casting_categories_model->get_casting_categories();
		

		$args["content"] = "home/home_view";
		$args["inner_args"] = NULL;
		$this->load->view('template',$args);
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

	public function contest()
	{
		if(isset($_GET['id']))
		{
			$categories = $this->casting_categories_model->get_casting_categories();
			
			$args['id_casting'] = $_GET['id'];		
			$args['title'] = $_GET['title'];		
			$args['entity'] = $_GET['entity'];
			$args['days'] = $_GET['days'];	
			$args['logo'] = $_GET['logo'];		
			$args['description'] = $_GET['description'];
			$args['steps'] = $_GET['steps'];	
			$args['prizes_description'] = $_GET['prizes_description'];	
			$args['bases'] = $_GET['bases'];		
			$args['full_image'] = $_GET['full_image'];
			$args['category'] = $categories[$_GET['category']];	
			$args['category_id'] = $_GET['category'];
			

			$args['logged_in'] = $this->session->userdata('id');

			if( !in_array($args['category_id'],array(1,2,3)))
				$args['apply_url'] = $_GET['apply_url'];
			else
			{
				if($args['category_id']==2)
				{
					if($args['logged_in'])
					{
						$share_data= $this->share_detail_model->select('*',array('casting_id'=>$args['id_casting']));
						$share_data =$share_data[0];
						$args['apply_url'] = "https://www.facebook.com/dialog/feed?
										  app_id=374106952676336&
										  link=".$_GET['apply_url']."&
										  picture=".urlencode(HOME.CASTINGS_SHARE_PATH.$share_data['image'])."&
										  name=".urlencode($share_data['title'])."&
										  caption=".$_GET['apply_url']."&
										  description=".urlencode($share_data['description'])."&
										  redirect_uri=".HOME;
					
					}
					else
						$args['apply_url'] = "none";
				}
				elseif($args['category_id'] == 1)
					$args['apply_url'] = "video";
				elseif($args['category_id'] == 3)
				{
					$args['apply_url'] = "trivia";

					//Aca se recuperan las preguntas personalizadas
					$custom_questions = $this->custom_questions_model->getQuestionsBy($args['id_casting']);
					$custom_options = array();

					if($custom_questions != 0)
					{
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

						$args['custom_options'] = $custom_options;
					}
				}
				else
					$args['apply_url'] = null;
			}	
			
			$args['entity_id'] = $_GET['entity_id'];	
			$args['prizes'] = explode("-", $_GET['prizes']);	
			$prizes_id = $args['prizes'];

			
			$prizes =  $this->prize_categories_model->select("name");
			$prizes_temp= array();
			
			$counter=0;
			foreach ($prizes as $prize) {
				$prizes_temp[$counter] = $prize["name"];
				$counter = $counter +1 ;
			}

			foreach ($args['prizes'] as &$prize) 
				if($prize!="")
					$prize = $prizes_temp[$prize];

			$args['prizes'] = array_combine($prizes_id ,$args['prizes']);

			$this->load->view('home/contest_modal',$args);
		}
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


	public function terms()
	{
		$args['content'] = 'home/terms';		
		$args["inner_args"]=NULL;
		$this->load->view('template',$args);
	}


	/* HAY Q OBTENER FUNCIONES DE ACA AUN; LUEGO BORRAR*/
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